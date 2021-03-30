<?php


namespace App\Factories;


use App\Models\Saison;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class SaisonFactory {


    const KEY_CACHE_HAUPTSAISON = 'hslist';


    /**
     * @return \Illuminate\Support\Collection
     */
    public function getCachedHauptsaisons() {
        return Cache::remember(self::KEY_CACHE_HAUPTSAISON, 3600, function () {
            return $this->getHauptsaisonByGlobals();
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function getHauptsaisonByGlobals() {
        $globals = \Statamic\Facades\GlobalSet::findByHandle( 'kalender' )->localizations()->first();
        $hs      = $globals->get( 'hs' );
        if(is_array($hs) && array_key_exists('von', $hs[0])) {
            return collect($hs)->map(function($item, $key) {
                $saison = new Saison();
                $saison->von = new Carbon($item['von']);
                $saison->bis = new Carbon($item['bis']);
                return $saison;
            });
        } else {
            $saison = new Saison();
            $saison->von = Carbon::createFromDate(date('Y'), 1, 1);
            $saison->bis = Carbon::createFromDate(date('Y'), 12, 31);
            return collect($saison);
        }
    }

    /**
     * @param $arr
     * Arr vom Typ [ ['von' => '', 'bis' => ''] ]
     *
     * @return \Illuminate\Support\Collection
     */
    public function createHauptsaisons($arr) {
        if(array_key_exists('von', $arr)) {
            $arr = [ $arr ];
        }
        $hs = collect([]);
        foreach($arr as $key => $entry) {
            $saison = new Saison();
            $saison->von = new Carbon($entry['von']);
            $saison->bis = new Carbon($entry['bis']);
            $hs->push($saison);
        }
        return $hs;
    }

    /**
     * @param Carbon | string $von
     * @param Carbon | string $bis
     *
     * @return Saison
     */
    public function createSaison($von, $bis) {
        $saison = new Saison();
        $saison->von = $von;
        $saison->bis = $bis;
        return $saison;
    }


}
