<?php

namespace App\Services;


use App\Models\Appartement;
use App\Services\BookingSessions\BookingSessionAppartement;
use App\Services\BookingSessions\BookingSessionContract;
use App\Services\BookingSessions\BookingSessionPaket;
use Log;

class BookingSessionValidator {


    /**
     * @var BookingSessionAppartement | BookingSessionPaket
     */
    protected $session;

    /**
     * @var \App\Models\Cart
     */
    protected $cart;


    /**
     * BookingSessionValidator constructor.
     *
     * @param BookingSessionContract|null $session
     */
    public function __construct( BookingSessionContract $session = null ) {

        if ( $session === null ) {
            $session = booking_session();
        }

        $this->session = $session;
        $this->cart    = $session->cart();
    }

    public function validateCheckinCheckout() {
        if ( ! $this->cart->checkin ) {
            return false;
        }
        if ( ! $this->cart->checkout ) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function validatePaketSelected() {

        if ( $this->cart->pakete()->count() == 0 ) {
            return false;
        }

        if ( ! $this->validateCheckinCheckout() ) {
            return false;
        }

        return true;
    }

    public function validatePersonsLeft() {
        return $this->cart->remaining()->get( 'all' ) > 0;
    }

    /**
     *
     * @return int|mixed
     */
    public function validateHasCheckinData() {

        if ( ! $this->validateCheckinCheckout() ) {
            Log::debug( 'validation failed checkin checkout' );

            return false;
        }


        if ( ! $this->validateHasBookablePersons() ) {
            Log::debug( 'validation failed no Bookable Persons' );

            return false;
        }

        if ( ! $this->validateHasAppartements() ) {
            Log::debug( 'validation failed no Appartements in Cart' );

            return false;
        }

        return true;
    }

    public function validateHasBookablePersons() {
        return ( (int) $this->cart->gaeste + (int) $this->cart->teilnehmer ) >= 0;
    }

    /**
     * check if cart has any appartements
     * @return bool
     */
    public function validateHasAppartements() {
        return $this->cart->items()->where( 'class', Appartement::class )->count() > 0;
    }

    /**
     * Muss Kontakt enthalten
     * @return bool
     */
    public function validateHasContact() {
        if ( ! $this->validateHasCheckinData() ) {
            return false;
        }
        if ( ! $this->cart->contact()->first() ) {
            return false;
        }

        return true;
    }


}
