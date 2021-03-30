<?php

namespace App\Services;


use App\Exceptions\PriceException;
use App\Models\EntryModel;

class PackagePrices {

    /**
     * @var EntryModel|null
     */
    protected $model = null;

    /**
     * @var null | string
     */
    protected $unit = null;

    public $pricelist = null;

    protected $prices = null;


    public function __construct( EntryModel $model ) {

        $this->model     = $model;
        $this->pricelist = collect( $this->model->entry->get( 'preisliste' ) )->map( function ( $item ) {
            return array_merge( $item, [
                'teilnehmer_hs'    => get_price_as_float( $item['teilnehmer_hs'] ),
                'teilnehmer_ns'    => get_price_as_float( $item['teilnehmer_ns'] ),
                'begleitperson_hs' => get_price_as_float( $item['begleitperson_hs'] ),
                'begleitperson_ns' => get_price_as_float( $item['begleitperson_ns'] ),
            ] );
        } );

    }

    public function getPrices( $klasse ) {
        return
            collect(
                $this->pricelist
                    ->where( 'klasse', $klasse )
                    ->first()
            );
    }

    public function getPriceEZ( $klasse, $is_hs) {

        $suffix           = $is_hs ? '_hs' : '_ns';
        $staffel          = $this->pricelist->where( 'klasse', $klasse )->first();
        if($staffel === null) {
            return 0;
        }
        $preis_teilnehmer = $staffel[ 'teilnehmer' . $suffix ];
        return round( $preis_teilnehmer / 100 * $staffel['ez'], 2 );

    }

    public function getPricesBySaison( $klasse, $is_hs, $with_ez = false ) {

        $suffix           = $is_hs ? '_hs' : '_ns';
        $staffel          = $this->pricelist->where( 'klasse', $klasse )->first();

        if($staffel === null) {
            return collect( [
                'teilnehmer'    => 0,
                'begleitperson' => 0,
            ] );
        }
        $preis_teilnehmer = $staffel[ 'teilnehmer' . $suffix ];
        $preis_begleitperson = $staffel[ 'begleitperson' . $suffix ];

        if ( $with_ez ) {
            $preis_teilnehmer += round( $preis_teilnehmer / 100 * $staffel['ez'], 2 );
            $preis_begleitperson += round( $preis_begleitperson / 100 * $staffel['ez'], 2 );
        }


        return collect( [
            'teilnehmer'    => $preis_teilnehmer,
            'begleitperson' => $preis_begleitperson,
        ] );
    }

}
