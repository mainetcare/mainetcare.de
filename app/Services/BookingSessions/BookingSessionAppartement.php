<?php

namespace App\Services\BookingSessions;

use App\Models\Appartement;
use App\Services\AppartementPriceCalculator;
use App\Services\BookingSessionValidator;
use App\Services\SaisonManager;

class BookingSessionAppartement extends BookingSession implements BookingSessionContract {


    protected function getSteps() {
        return [
            1 => route( 'appartement-select.index' ),
            2 => route( 'fitness-select.index' ),
            3 => route( 'wellness-select.index' ),
            4 => route( 'pferd-select.index' ),
            5 => route( 'kunst-select.index' ),
            6 => route( 'funpark-select.index' ),
            7 => route( 'transferservice-select.index' ),
            8 => route( 'kontaktdaten.index' ),
            9 => route( 'summary.index' ),
        ];
    }

//    /**
//     * @param Appartement $app
//     *
//     * @deprecated
//     */
//    public function addAppartementToCart( Appartement $app ) {
//        $cart  = $this->cart();
//        $is_hs = app( SaisonManager::class )->isInHauptsaison( $cart->getPeriod() );
//        $price = app( AppartementPriceCalculator::class )->input( $app, $cart->nights, $is_hs )->getTotal();
//        $this->cart()->addAppartement( $app, 1, $price );
//    }

    public function gateStep1() {
        return app(BookingSessionValidator::class, ['session' => $this])->validateHasAppartements();
    }

    public function gateStep2() {
        return app(BookingSessionValidator::class, ['session' => $this])->validateHasAppartements();
    }

    public function gateStep3() {
        return $this->gateStep2();
    }

    public function gateStep4() {
        return $this->gateStep2();
    }

    public function gateStep5() {
        return $this->gateStep2();
    }

    public function gateStep6() {
        return $this->gateStep2();
    }

    public function gateStep7() {
        return $this->gateStep2();
    }

    public function gateStep8() {
        return false;
    }













}
