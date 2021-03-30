<?php

namespace App\Http\Controllers;

use App\Exceptions\BookingException;
use App\Factories\AppartementFactory;
use App\Repositories\AppartementRepository;
use App\Services\BookingSessionValidator;
use Illuminate\Http\Request;
use Statamic\View\View;

class SelectAppartementController extends Controller {


    public function __construct() {
        $this->middleware('bookingsession.validateappartement');
    }

    /**
     * We come usually from the homepage
     */
    public function index() {
        return view( 'booking.appartement.index' );
    }


}
