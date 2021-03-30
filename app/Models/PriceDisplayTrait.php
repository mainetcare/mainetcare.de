<?php


namespace App\Models;


use App\Services\Calculator;
use App\Services\DiscountCalculator;
use App\Services\PriceDisplay;

trait PriceDisplayTrait {


    /**
     * @var null | PriceDisplay
     */
    protected $pricedisplay = null;

    /**
     * PriceDisplayTrait constructor.
     *
     * @param PriceDisplay|null $pricedisplay
     */


    public function pricedisplay() {
        return $this->pricedisplay;
    }

    public function initPricedisplay( Calculator $calculator, Rabatt $rabatt = null ) {
        $price_display = new PriceDisplay();
        $price_display->setRegularPrice( $calculator->getUnitPrice() );
        if($rabatt) {
            $price_display->setRabatt( $rabatt );
        }
        if ( $rabatt && $rabatt->effects( $this ) ) {
            $discount_calculator = new DiscountCalculator( $calculator, $rabatt );
            $price_display->setDiscountPrice( $discount_calculator->getUnitPrice() );
        }
        $this->pricedisplay = $price_display;
    }

}
