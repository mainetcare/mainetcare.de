<?php

namespace App\Services;


use App\Exceptions\PriceException;
use App\Models\EntryModel;

class BulkPrices {

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
    protected $multiplier = null;
    protected $variant = null;

    /**
     * BulkPrices constructor.
     * Wenn Variante null ist die Unit der Key in der Liste, ansonsten ist Variante + Unit = Key in der Preisliste
     *
     * @param EntryModel $model
     * @param string|null $unit
     * @param string|null $variant
     */
    public function __construct( EntryModel $model, string $unit = null, string $variant = null ) {

        // set:
        $this->unit    = $unit;
        $this->variant = $variant;
        $this->model   = $model;
        // calc:
        $this->pricelist = collect( $this->model->entry->get( 'preisliste' ) );

        if($this->isUnitUnique()) {
            $this->variant = $this->variant();
        }

        $this->prices     = $this->prices();
        $this->multiplier = $this->multiplier();
    }

    public function getPrices() {
        return $this->prices;
    }

    public function getMultiplier() {
        return $this->multiplier;
    }

    public function getVariant() {
        return $this->variant;
    }

    public function hasVariant() {
        return $this->variant !== null;
    }

    public function hasMultiplier() {
        return $this->multiplier !== null;
    }

    public function getPriceByAmount( $amount ) {
        $bulks       = $this->prices;
        $upper_limit = 0;
        foreach ( $bulks as $i => $bulk ) {
            $lower_limit = (int) $bulk->get( 'ab_me' );
            if ( ( $i + 1 ) < count( $bulks ) ) {
                $upper_limit = ( (int) ( $bulks[ $i + 1 ]['ab_me'] ) ) - 1;
            } else {
                $upper_limit = null;
            }
            if ( $this->isInInterval( $amount, [ $lower_limit, $upper_limit ] ) ) {
                return $bulk;
            }
        }
        if ( $upper_limit <= $amount ) {
            return $this->prices->last();
        }
        // An dieser Stelle ist die Preisstaffel im Objekt nicht korrekt definiert:
        // @todo: better throw Exception?
        return $this->prices->first();
    }


    private function isInInterval( int $amount, array $arrInterval ) {

        if ( $arrInterval[1] == 0 ) {
            return true;
        }

        if ( $arrInterval[1] === null ) {
            return $arrInterval[0] <= $amount;
        }

        return ( $arrInterval[0] <= $amount ) && ( $amount <= $arrInterval[1] );
    }

    private function prices() {
        return
            collect(
                $this->pricelist
                    ->where( 'unit', $this->unit )
                    ->where( 'variant', $this->variant )
                    ->pluck( 'preise' )
                    ->first()
            )->sortBy( 'ab_me' )
             ->map( function ( $arr ) {
                 return collect( $arr );
             } );
    }

    /**
     * @return string | null
     */
    private function multiplier() {
        return $this->pricelist
            ->where( 'unit', $this->unit )
            ->pluck( 'multiplier' )
            ->first();
    }

    private function isUnitUnique() {
        return $this->pricelist
                   ->where( 'unit', $this->unit )
                   ->pluck( 'unit' )
                   ->count() <= 1;
    }

    /**
     * @return string | null
     */
    private function variant() {
        return $this->pricelist
            ->where( 'unit', $this->unit )
            ->pluck( 'variant' )
            ->first();
    }

}
