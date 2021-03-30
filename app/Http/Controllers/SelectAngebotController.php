<?php

namespace App\Http\Controllers;

use App\Exceptions\BookingException;
use App\Models\AngebotBereich;
use App\Models\AngebotGruppe;
use App\Repositories\AngebotRepository;
use App\Services\BookingSessionValidator;
use Statamic\Facades\Term;

class SelectAngebotController extends Controller {

    protected $list_angebote = [];

    public function __construct() {
        $this->middleware( 'bookingsession.validateangebot' );
    }

    public function fitness() {

        $sauna = app( AngebotRepository::class )->getAngebote( AngebotBereich::$bereich_fitness, AngebotGruppe::$gruppe_sauna );
        $kurse = app( AngebotRepository::class )->getAngebote( AngebotBereich::$bereich_fitness, AngebotGruppe::$gruppe_sportkurse );

        $this->addAngeboteToList( $sauna, 'Sauna' );
        $this->addAngeboteToList( $kurse, 'Sportkurse' );

        return $this->getAngebotsView( AngebotBereich::$bereich_fitness );
    }

    public function pferd() {

        $bereich = AngebotBereich::$bereich_pferd;
        $terms =
            Term::query()
                ->where( 'taxonomy', 'angebotsgruppe' )
                ->orderBy('title')
                ->get();
        foreach ( $terms as $term ) {
            if($term->get('angebotsbereich') == $bereich) {
                $list  = app( AngebotRepository::class )->getAngebote( $bereich, $term->slug() );
                $title = $term->get( 'title' );
                $this->addAngeboteToList( $list, $title );
            }
        }
        return $this->getAngebotsView( $bereich );

    }

    /**
     * Bei Paketen nur Pferdepension ohne Ausritte (vergleiche Methode pferd())
     */
    public function pferdepension() {
        $list = app( AngebotRepository::class )->getAngebote( AngebotBereich::$bereich_pferd, AngebotGruppe::$gruppe_pferdepension );
        $this->addAngeboteToList( $list );
        return view( 'booking.angebote.index', [
            'list'  => $this->list_angebote,
            'title' => 'Pferdepensionen'
        ] );
    }


    public function wellness() {
        $bereich = AngebotBereich::$bereich_wellness;

        return $this->getDefault( $bereich );
    }

    public function kunst() {
        $bereich = AngebotBereich::$bereich_kunst;

        return $this->getDefault( $bereich );
    }

    public function funpark() {
        $bereich = AngebotBereich::$bereich_funpark;

        return $this->getDefault( $bereich );
    }

    public function transferservice() {
        $bereich = AngebotBereich::$bereich_transferservice;

        return $this->getDefault( $bereich );
    }

    protected function getDefault( $bereich ) {
        $this->addAngeboteToList( app( AngebotRepository::class )->getAngebote( $bereich ) );

        return $this->getAngebotsView( $bereich );
    }

//    /**
//     * @throws BookingException
//     * @todo move to middleware
//     */
//    protected function validateStep() {
//        $session = booking_session();
//        $validator = app( BookingSessionValidator::class, [ 'session' => booking_session() ] );
//        if ( ! $validator->validateHasAppartements() ) {
//            $route = $session->getRouteOfStep(1 );
//            return redirect($route);
//        }
//        if ( ! $validator->validateCheckinCheckout() ) {
//            throw new BookingException( 'Fehler. Der Warenkorb ist nicht mehr verfügbar. Bitte neu wählen.' );
//        }
//    }

    protected function addAngeboteToList( $list, $title = null ) {
        $this->list_angebote[] = [
            'angebote' => $list,
            'subtitle' => $title,
        ];
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function getAngebotsView( $bereich ) {
        return view( 'booking.angebote.index', [
            'list'  => $this->list_angebote,
            'title' => AngebotBereich::getLabel( $bereich )
        ] );
    }


}
