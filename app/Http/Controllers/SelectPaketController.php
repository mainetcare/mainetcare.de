<?php

namespace App\Http\Controllers;

use App\Exceptions\BookingException;
use App\Factories\AppartementFactory;
use App\Models\AngebotBereich;
use App\Repositories\AppartementRepository;
use App\Services\BookingSessionValidator;
use App\Services\SaisonManager;
use Illuminate\Http\Request;

class SelectPaketController extends Controller {


    /**
     * We come usually from the homepage
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $cart = cart();
        $this->validateStep();
        $paket = $cart->pakete()->first();
        $apps  = app( AppartementRepository::class )->get();
        $is_hs = app( SaisonManager::class )->isInHauptsaison( $cart->getPeriod() );

        return view( 'booking.paket.index' )
            ->with( 'appartements', $apps )
            ->with( 'paket', $paket )
            ->with( 'cart', $cart )
            ->with( 'is_hs', $is_hs );
    }

    /**
     * @throws BookingException
     * @todo move to middleware
     */
    protected function validateStep() {
        if ( ! app( BookingSessionValidator::class )->validatePaketSelected() ) {
            throw new BookingException( 'Fehler. Der Warenkorb ist nicht mehr verfügbar. Bitte neu wählen.' );
        }
    }



}
