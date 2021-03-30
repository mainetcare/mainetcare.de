<?php

namespace App\Http\Controllers;

use App\Exceptions\BookingException;
use App\Jobs\BookingRequest;
use App\Repositories\PferdepensionRepository;
use App\Services\BookingSessionValidator;
use Request;
use Route;

class SummaryController extends Controller {

    public function index() {
        $this->validateStep();

        return view( 'booking.summary.index', [
            'cart'    => cart(),
            'contact' => cart()->contact()->first()
        ] );
    }

    public function store() {
        $this->validateStep();
        $cart = cart();
        // send the Request:
        try {
            app(BookingRequest::class, ['cart' => $cart])->handle();
        } catch (\Exception $e) {
            return view( 'booking.summary.fail', [
                'cart'    => $cart,
            ] );
        }
        // Delete Booking Session
        booking_session()->reset();
        return view('booking.sent.index');
    }

    /**
     * @throws BookingException
     * @todo move to middleware
     */
    protected function validateStep() {
        if ( ! $session = app( BookingSessionValidator::class )->validateHasContact() ) {
            throw new BookingException( 'Fehler. Der Warenkorb ist nicht mehr verfügbar. Bitte neu wählen' );
        }
    }

}
