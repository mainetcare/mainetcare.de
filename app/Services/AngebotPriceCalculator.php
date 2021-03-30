<?php

namespace App\Services;

use App\Exceptions\PriceException;
use App\Models\Angebot;
use Arr;

/**
 * Class AngebotPriceCalculator
 * @package App\Services
 */
class AngebotPriceCalculator implements Calculator {

    protected $bulkprices = null;
    protected $amount = null;
    protected $multiplier = null;
    protected $staffelpreis = null;

    /**
     * AngebotPriceCalculator constructor.
     *
     * @param BulkPrices $bulkprices
     * @param int $amount
     * @param int $multiplier
     */
    public function __construct( BulkPrices $bulkprices, int $amount, int $multiplier ) {

        $this->bulkprices = $bulkprices;
        $this->amount     = $amount;
        $this->multiplier = $multiplier;

    }

    public function getUnitPrice() {
        $set = $this->bulkprices->getPriceByAmount( $this->amount );
        return $set->get( 'preis' );
    }


    public function getTotal() {
        $set = $this->bulkprices->getPriceByAmount( $this->amount );
        $price     = $set->get( 'preis' );
        return $this->amount * $price * $this->multiplier;
    }

}
