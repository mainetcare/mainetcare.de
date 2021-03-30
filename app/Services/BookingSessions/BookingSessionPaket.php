<?php

namespace App\Services\BookingSessions;


use App\Services\BookingSessionValidator;

class BookingSessionPaket extends BookingSession implements BookingSessionContract {


    protected function getSteps() {
        return [
            1 => route( 'paket-select.index' ),
            2 => route( 'paket-pferdepension-select.index' ),
            3 => route( 'paket-transferservice-select.index' ),
            4 => route( 'paket-kontaktdaten.index' ),
        ];
    }

    public function gateStep1() {
        $validator = app( BookingSessionValidator::class, [ 'session' => $this ] );
        $v1        = $validator->validateHasAppartements();
        if ( ! $v1 ) {
            return false;
        }
        if ( $validator->validatePersonsLeft() ) {
            return false;
        }

        return true;
    }

    public function gateStep2() {
        return $this->gateStep1();
    }

    public function gateStep3() {
        return $this->gateStep2();
    }

    public function gateStep4() {
        return false;
    }


}
