<?php

namespace App\Services;

use App\Exceptions\BookingException;
use App\Exceptions\PriceException;
use App\Models\Appartement;

class AppartementPriceCalculator implements Calculator {

    /**
     * @var null | Appartement
     */
    protected $appartement = null;

    /**
     * Anzahl Nächte
     * @var null | int
     */
    protected $nights = null;

    /**
     * @var null | boolean
     */
    protected $is_hs = null;

    /**
     * @param Appartement $app
     * @param int $nights
     * @param bool $is_hauptsaison
     *
     * @return $this
     */
    public function input( Appartement $app, int $nights, bool $is_hauptsaison ) {
        $this->appartement = $app;
        $this->nights      = $nights;
        $this->is_hs       = $is_hauptsaison;

        return $this;
    }

    /**
     * @return float |int
     * @throws BookingException
     * @throws PriceException
     */
    public function getTotal() {
        $price = $this->getUnitPrice();
        return ( $this->nights * $price );
    }


    /**
     * gets the "Einzelpreis, e.g. Appartementpreis pro Nacht, Angebot without Multiplier, Paket is the same as Totalprice)
     * @return mixed
     * @throws PriceException
     * @throws BookingException
     */
    public function getUnitPrice() {
        $prices = $this->getPricetable();
        $key    = 'ns';
        if ( $this->is_hs ) {
            $key = 'hs';
        }

        return $prices->get( $key );
    }



    /**
     * @return array|mixed
     * @throws PriceException
     * @throws BookingException
     */
    private function getPricetable() {
        if ( ! $this->appartement ) {
            throw new PriceException( 'Appartment für Kalkulation fehlt' );
        }

        return $this->appartement->getPrices();
    }

    /**
     * @return mixed
     * @throws BookingException
     * @throws PriceException
     * @deprecated
     */
    public function getPricePerNight() {
        return $this->getUnitPrice();
    }


}
