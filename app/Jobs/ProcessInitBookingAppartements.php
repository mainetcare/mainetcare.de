<?php

namespace App\Jobs;

use App\Models\Cart;
use App\Services\BookingSessions\BookingSessionAppartement;
use App\Services\BookingSessions\BookingSessionRouter;
use Illuminate\Support\Carbon;

class ProcessInitBookingAppartements {


    /**
     * @var Cart
     */
    protected $cart;


    /**
     * @var Carbon | null
     */
    protected $checkin = null;
    protected $checkout = null;
    protected $gaeste = 1;

    /**
     * ProcessAddPaketToCart constructor.
     *
     * @param array $arrSelection
     */
    public function __construct( array $arrSelection ) {

        $this->checkin = $arrSelection['checkin'];
        $this->checkout = $arrSelection['checkout'];
        $this->gaeste  = $arrSelection['gaeste'];
    }

    /**
     * Execute the job.
     * initialize: we have
     *
     * @return void
     */
    public function handle() {

        $session = app( BookingSessionRouter::class )->setActiveSession( app( BookingSessionAppartement::class ) );
        $session->reset();
        $this->cart = $session->cart();

        $this->cart->update( [
            'gaeste'   => $this->gaeste,
            'checkin'  => $this->checkin,
            'checkout' => $this->checkout,
        ] );

    }

}
