<?php

namespace App\Presenter;

use Arr;
use Laracasts\Presenter\Presenter;


class AngebotPresenter extends Presenter {


    /**
     * @param $unit
     *
     * @return array|\ArrayAccess|mixed
     * @todo move to BulkPrices
     */
    public function selectunit( $unit ) {
        $arr = [
            'tag'      => 'Wie viele Tage',
            'haustier' => 'Wie viele Haustiere',
            'hund'     => 'Wie viele Hunde',
            'katze'    => 'Wie viele Katzen',
            'person'   => 'Wie viele Personen',
            'nacht'    => 'Wie viele Nächte',
            'paket'    => 'Wie viele Pakete',
            'kurs'     => 'Wie viele Kurse',
            'stk'      => 'Stückzahl',
            'std'      => 'Wie viele Stunden',
            'tour'     => 'Wie viele Touren',
            'einheit'  => 'Wie viele Einheiten',
        ];

        return Arr::get( $arr, $unit, 'Anzahl' );
    }


}
