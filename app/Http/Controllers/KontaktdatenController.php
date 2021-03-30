<?php

namespace App\Http\Controllers;

use App\Exceptions\BookingException;
use App\Repositories\PferdepensionRepository;
use App\Services\BookingSessionValidator;
use Log;
use Route;

class KontaktdatenController extends Controller {

    public function index() {
        $this->validateStep();
        return view( 'booking.kontakt.index' );
    }

    /**
     * @todo move to middleware
     * @throws BookingException
     */
    protected function validateStep() {
        if(!$session = app(BookingSessionValidator::class)->validateHasCheckinData()) {
            Log::debug('validation Error for Cart: ' . cart()->toJson());
            throw new BookingException( 'Fehler. Der Warenkorb ist nicht mehr verfügbar. Bitte neu wählen' );
        }
    }

}
