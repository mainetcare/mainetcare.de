<?php

namespace App\Http\Controllers;

use App\Factories\PaketFactory;
use App\Factories\VeranstaltungFactory;
use App\Jobs\ProcessInitPaketInCart;
use App\Models\Paket;
use App\Repositories\PaketRepository;
use App\Repositories\VeranstaltungRepository;
use Carbon\Carbon;
use Statamic\View\View;

class VeranstaltungController extends Controller {


    /**
     * We come usually from the homepage
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {

        $veranstaltungen = app( VeranstaltungRepository::class )->getVeranstaltungen();

        return view( 'veranstaltungen.index' )
            ->with( 'veranstaltungen', $veranstaltungen );
    }

    public function show( $slug ) {

        $veranstaltung = app( VeranstaltungFactory::class )->initBySlug( $slug );

        if ( $veranstaltung === null ) {
            redirect( route( 'veranstaltung.index' ) );
        }

        $data = $veranstaltung->entry;

        return ( new View )
            ->template( $veranstaltung->entry->template() )
            ->with( [
                'veranstaltung' => $veranstaltung
            ] )
            ->cascadeContent( $veranstaltung->entry );
    }

}
