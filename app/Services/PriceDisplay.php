<?php


namespace App\Services;

use App\Models\Rabatt;

class PriceDisplay {


    /**
     * @var float
     */
    protected $regular_price = 0.0;

    /**
     * @var null | Rabatt
     */
    protected $rabatt = null;

    /**
     * @var float
     */
    protected $discount_price = 0.0;


    public function __construct() {

    }

    /**
     * @param Rabatt $rabatt
     */
    public function setRabatt( Rabatt $rabatt ): void {
        $this->rabatt = $rabatt;
    }

    /**
     * @return Rabatt|null
     */
    public function getRabatt() {
        return $this->rabatt;
    }

    /**
     * @param float $discount_price
     */
    public function setDiscountPrice( float $discount_price ): void {
        $this->discount_price = $discount_price;
    }

    public function hasStreichpreis() {
        return $this->rabatt && $this->discount_price > 0;
    }

    /**
     * @param float $price
     */
    public function setRegularPrice( float $price ) {
        $this->regular_price = $price;
    }

    /**
     * @return float
     */
    public function getRegularPrice() {
        return $this->regular_price;
    }

    /**
     * @return float
     */
    public function getDiscountPrice() {
        return $this->discount_price;
    }

    /**
     * @return float
     */
    public function getCurrentPrice() {
        if ( $this->hasStreichpreis() ) {
            return $this->getDiscountPrice();
        }
        return $this->getRegularPrice();
    }

    /**
     * @return mixed|string|null
     * @deprecated
     */
    public function getDiscountPercent() {
        if(! $this->hasStreichpreis()) {
            return '';
        }
        return $this->rabatt->getDiscountPercent();

    }


}
