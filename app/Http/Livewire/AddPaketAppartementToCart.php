<?php

namespace App\Http\Livewire;

use App\Factories\AngebotFactory;
use App\Factories\AppartementFactory;
use App\Factories\PaketFactory;
use App\Jobs\ProcessAddAngebotToCart;
use App\Jobs\ProcessAddPaketAppartementToCart;
use App\Models\Angebot;
use App\Models\Appartement;
use App\Models\Paket;
use App\Services\BulkPrices;
use App\Services\Pluralizer;
use Livewire\Component;
use Validator;

class AddPaketAppartementToCart extends Component {

    public $teilnehmer = 0;
    public $begleitperson = 0;
    public $appartementid;
    public $slug;
    public $max;  // Maximale Kapazität pro Appartement

    public $max_teilnehmer; // Die bereits festgelegte Teilnehmerzahl im Warenkorb
    public $max_begleitperson; // Die bereits ... Begleitperson im Warenkorb

    protected $appartement = null;
    protected $paket = null;
    protected $cart = null;


    public function mount( Paket $paket, Appartement $appartement ) {

        $this->cart              = cart();
        $this->appartementid     = $appartement->id;
        $this->paket             = $paket;
        $this->slug              = $paket->slug;
        $this->max               = $appartement->entry->gaeste_max;
        $this->max_teilnehmer    = $this->cart->teilnehmer;
        $this->max_begleitperson = $this->cart->gaeste;

    }

    protected function checkCapacity( $t, $b ) {
        if ( ( $t + $b ) > $this->max ) {
            $this->addError( 'capacity', 'Die Kapazität dieses Appartements beträgt ' . $this->max . ' Gäste' );

            return false;
        }
        if ( $t > $this->max_teilnehmer ) {
            return false;
        }
        if ( $b > $this->max_begleitperson ) {
            return false;
        }
        return true;
    }

    protected function incTeilnehmer() {
        $tn = $this->teilnehmer + 1;
        if ( ! $this->checkCapacity( $tn, $this->begleitperson ) ) {
            return;
        }
        $this->teilnehmer = $tn;
    }

    protected function decTeilnehmer() {
        $tn = $this->teilnehmer - 1;
        // Mindestens 1 Teilnehmer:
        if ( $tn < 1 ) {
            return;
        }
        $this->teilnehmer = $tn;
    }

    protected function incBegleitperson() {
        $bp = $this->begleitperson + 1;
        if ( ! $this->checkCapacity( $this->teilnehmer, $bp ) ) {
            return;
        }
        $this->begleitperson = $bp;
    }

    protected function decBegleitperson() {
        $bp = $this->begleitperson - 1;
        // Mindestens 1 Teilnehmer:
        if ( $bp < 0 ) {
            return;
        }
        $this->begleitperson = $bp;
    }


    public function inc( $fieldname ) {
        $this->routeMethod( 'inc' . ucfirst( $fieldname ) );
    }

    public function dec( $fieldname ) {
        $this->routeMethod( 'dec' . ucfirst( $fieldname ) );
    }

    public function submit() {

        $pass = Validator::make(
            [
                'teilnehmer'    => $this->teilnehmer,
                'begleitperson' => $this->begleitperson,
            ],
            [
                'begleitperson' => 'required|numeric|max:4',
                'teilnehmer'    => 'required|numeric',
            ],
            [
                'required' => 'Bitte :attribute wählen',
                'numeric'  => ':attribute ist keine Zahl'
            ]
        )->validate();


        $this->appartement = app( AppartementFactory::class )->initById( $this->appartementid );
        $this->paket       = app( PaketFactory::class )->initBySlug( $this->slug );
        $this->cart        = cart();

        if ( ! $this->appartement ) {
            $this->addError( 'fail', 'Appartement konnte nicht hinzugefügt werden.' );

            return;
        }

        if ( ! $this->paket ) {
            $this->addError( 'fail', 'Appartement konnte nicht hinzugefügt werden.' );

            return;
        }

        $this->addToCart();

        // rerender Cart:
        $this->emit( 'refreshCart' );

        $this->dispatchBrowserEvent( 'ltoast', [
            'type'    => 'success',
            'message' => $this->appartement->title . ' wurde hinzugefügt / aktualisiert',
        ] );

        $this->mount( $this->paket, $this->appartement );

    }

    protected function addToCart() {

        app( ProcessAddPaketAppartementToCart::class, [
            'arrSelection' => [
                'cart'          => $this->cart,
                'paket'         => $this->paket,
                'appartement'   => $this->appartement,
                'teilnehmer'    => $this->teilnehmer,
                'begleitperson' => $this->begleitperson,
            ]
        ] )->handle();

    }

    public function render() {
        $this->emit( 'initpopper' );
        return view( 'livewire.add-paketappartement-to-cart' );
    }

    private function routeMethod( $method ) {
        if ( method_exists( $this, $method ) ) {
            $this->$method();
        }

    }


}
