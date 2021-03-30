<?php

namespace App\Services;

use App\Exceptions\BookingException;
use App\Exceptions\PriceException;
use App\Models\Appartement;
use App\Models\Rabatt;

class DiscountCalculator implements Calculator {

    /**
     * @var Calculator|null
     */
    protected $calculator = null;
    /**
     * @var Rabatt|null
     */
    protected $rabatt = null;
    /**
     * @var int
     */
    private $discount_percent;

    /**
     * DiscountCalculator constructor.
     *
     * @param Calculator $calculator
     * @param Rabatt $rabatt
     */
    public function __construct( Calculator $calculator, Rabatt $rabatt ) {
        $this->calculator       = $calculator;
        $this->rabatt           = $rabatt;
        $this->discount_percent = (int) $rabatt->entry->get( 'rabatt_prozent' );
    }

    public function getTotal() {
        return $this->calcDiscount($this->calculator->getTotal());
    }

    public function getUnitPrice() {
        return $this->calcDiscount($this->calculator->getUnitPrice());
    }

    protected function calcDiscount($regular_price) {
        return round( $regular_price - ( $regular_price / 100 * $this->discount_percent ), 2 );
    }


}
