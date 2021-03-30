<?php

namespace App\Http\Controllers;

use App\Factories\PaketFactory;
use App\Jobs\ProcessInitPaketInCart;
use App\Models\Paket;
use App\Repositories\PaketRepository;
use Carbon\Carbon;
use Statamic\View\View;

class PaketController extends Controller {


    /**
     * We come usually from the homepage
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {

        $pakete = app( PaketRepository::class )->getPakete();

        return view( 'paket.index' )
            ->with( 'pakete', $pakete );
    }

    public function show( $slug ) {

        $paket = app( PaketFactory::class )->initBySlug( $slug );

        if ( $paket === null ) {
            redirect( route( 'paket.index' ) );
        }

        return $paket->entry;

//        return ( new View )
//            ->template( $data->template() )
//            ->layout( $data->layout() )
//            ->with( [
//                'checkin' => Carbon::now()->addDays( 1 )->format( 'd.m.Y' ) // Default Datum morgen für Datepicker
//            ] )
//            ->cascadeContent( $data );
    }

//    public function store( $request ) {
//
//        $data = $request->validate( [
//            'paketid' => 'required|string',
//            'checkin' => 'required|date',
//        ] );
//
//
//        booking_session()->reset();
//        $cart = booking_session()->cart();
//
//        // init the Cart:
//        app( ProcessInitPaketInCart::class, [
//            'arrSelection' => [
//                'cart'       => $cart,
//                'paket'      => $this->paket,
//                'teilnehmer' => $this->teilnehmer,
//                'gaeste'     => $this->gaeste,
//                'checkin'    => new Carbon( $this->checkin ),
//            ]
//        ] )->handle();
//
//        redirect( route( 'paket-select.index' ) );
//
//
//    }


}
