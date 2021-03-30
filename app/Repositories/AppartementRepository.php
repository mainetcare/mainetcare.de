<?php


namespace App\Repositories;

use App\Factories\AppartementFactory;
use App\Models\Appartement;
use App\Models\BlockedPeriod;
use App\Models\Cart;
use App\Services\AppartementPriceCalculator;
use App\Services\SaisonManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Statamic\Facades\Entry;

class AppartementRepository {

    /**
     * @var Appartement | null
     */
    protected $appartement = null;

    const KEY_CACHE_LISTE = 'appliste';

    public function __construct( Appartement $appartement = null ) {
        if ( $appartement === null ) {
            $this->app = new Appartement();
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function get() {
        return Cache::remember( self::KEY_CACHE_LISTE, 3600, function () {
            $liste   = collect( [] );
            $entries = Entry::query()->where( 'collection', 'appartements' )->orderBy( 'rf' )->get();
            foreach ( $entries as $entry ) {
                $appartement = app(AppartementFactory::class)->initByEntry( $entry );
                $liste->add( $appartement );
            }

            return $liste;
        } );
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getAdmin() {
        $liste   = collect( [] );
        $entries = Entry::query()
                        ->where( 'collection', 'appartements' )
                        ->orderBy( 'rf' )
                        ->get();
        $today = new Carbon('today');
        foreach ( $entries as $entry ) {
            $appartement = app(AppartementFactory::class)->initByEntry( $entry );
            if(! $appartement->availableIn($today, $today)) {
                $appartement->status = Appartement::STATUS_NOT_AVAILABLE;
            } else {
                $appartement->status = null;
            }
            $liste->add( $appartement );
        }

        return $liste;
    }


    /**
     * Modifies the get() List by calculating the current price
     * and setting if it is available or not (4 Persion Appartement not bookable by 1 Person)
     *
     * @param Cart $cart
     *
     * @return \Illuminate\Support\Collection
     *
     */
    public function getMutatedList( Cart $cart ) {
        $entries = $this->get();
        $is_hs   = app( SaisonManager::class )->isInHauptsaison( $cart->getPeriod() );
        foreach ( $entries as $appartement ) {
            /**
             * @var $appartement Appartement
             */
            $price = app( AppartementPriceCalculator::class )
                ->input( $appartement, $cart->nights, $is_hs )
                ->getPricePerNight();
            $appartement->setCurrentPrice( $price );
            $appartement->setAvailableByGuests( $cart->gaeste );
            if ( $appartement->inCart( $cart ) ) {
                $appartement->setStatus( Appartement::STATUS_NOT_AVAILABLE, 'Ihr gewähltes Appartement' );
            }
            if(! $appartement->availableIn($cart->checkin, $cart->checkout)) {
                $appartement->setStatus( Appartement::STATUS_NOT_AVAILABLE, 'Dieses Appartement ist bereits reserviert' );
            }
        }

        return $entries;
    }


    /**
     * @param string $klasse Preisklasse Slug
     *
     * @return \Illuminate\Support\Collection
     */
    public function getByPreisklasse( $klasse ) {
        return Entry::query()
                    ->where( 'collection', 'appartements' )
                    ->where( 'appartementklasse', $klasse )
                    ->orderBy( 'rf' )
                    ->get()->map( function ( $item ) {
                return app(AppartementFactory::class)->initByEntry( $item );
            } );
    }

//    public function getAvailable(Carbon $von = null, Carbon $bis = null ) {
//        if( $von === null) {
//            $von = new Carbon();
//        }
//        if($bis === null) {
//            $bis = new Carbon();
//        }
//        $ids = BlockedPeriod::query()
//            ->where('blockable_type', Appartement::class)
//            ->where('start', '<=' $start)
//
//    }


}
