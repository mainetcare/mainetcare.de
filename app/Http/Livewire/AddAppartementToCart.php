<?php

namespace App\Http\Livewire;

use App\Factories\AngebotFactory;
use App\Factories\AppartementFactory;
use App\Factories\PaketFactory;
use App\Jobs\ProcessAddAngebotToCart;
use App\Jobs\ProcessAddAppartementToCart;
use App\Jobs\ProcessAddPaketAppartementToCart;
use App\Models\Angebot;
use App\Models\Appartement;
use App\Models\Paket;
use App\Services\BulkPrices;
use App\Services\Pluralizer;
use Illuminate\Support\MessageBag;
use Livewire\Component;
use Validator;

class AddAppartementToCart extends Component {

    protected $cart = null;
    protected $appartement = null;

    public $appartement_id;
    public $slug;
    public $appartement_status = '';
    public $appartement_statusmessage = '';
    public $action_render = true;


    public $gaeste = 0;
    public $max;  // Maximale Kapazität pro Appartement

    public function mount( Appartement $appartement ) {

        $this->cart                      = cart();
        $this->appartement_id            = $appartement->id;
        $this->appartement_status        = $appartement->entry->app_status;
        $this->appartement_statusmessage = $appartement->entry->app_statusmessage;
        $this->max                       = $appartement->entry->gaeste_max;

    }

    protected $rules = [
        'gaeste' => 'required|integer|min:1',
    ];

    protected $messages = [
        'gaeste.required' => 'Bitte geben Sie die Anzahl Personen für dieses Appartement an',
        'gaeste.integer'  => 'Bitte geben Sie mindestens 1 Person an',
        'gaeste.min'      => 'Bitte geben Sie mindestens 1 Person an',
    ];

    protected $listeners = [ 'refreshCart' => 'refresh' ];

    public function refresh() {
        $appartement = app( AppartementFactory::class )->initById( $this->appartement_id );
        $cart        = cart();
        if ( $appartement->inCart($cart) ) {
            $this->appartement_status        = Appartement::STATUS_NOT_AVAILABLE;
            $this->appartement_statusmessage = 'Bereits in Warenkorb';
        } else {
            $this->appartement_status        = '';
            $this->appartement_statusmessage = '';
        }
    }


    protected function checkCapacity( $gaeste ) {
        if ( ( $gaeste ) > $this->max ) {
            $this->addError( 'capacity', 'Die Kapazität dieses Appartements beträgt ' . $this->max . ' Gäste' );

            return false;
        }
        if ( $gaeste > ( $remaining = cart()->remaining()->get( 'all' ) ) ) {
            $this->addError( 'capacity', 'Sie können nur noch  ' . plural( $remaining, 'Person' ) . ' wählen' );

            return false;
        }

        return true;
    }

    protected function incGaeste() {
        $tn = $this->gaeste + 1;
        if ( ! $this->checkCapacity( $tn ) ) {
            return;
        }
        $this->gaeste = $tn;
    }

    protected function decGaeste() {
        $tn = $this->gaeste - 1;
        if ( $tn < 0 ) {
            return;
        }
        $this->gaeste = $tn;
    }

    public function submit() {

        $this->validate();

        $this->appartement = app( AppartementFactory::class )->initById( $this->appartement_id );
        $this->cart        = cart();

        if ( ! $this->appartement ) {
            $this->errors = new MessageBag();
            $this->addError( 'fail', 'Appartement konnte nicht hinzugefügt werden.' );

            return;
        }

//        if ( $this->cart->allPersonsAssigned() ) {
//            $this->errors = new MessageBag();
//            $this->addError( 'fail', 'Alle Personen sind auf Appartements verteilt.' );
//
//            return;
//        }

        app( ProcessAddAppartementToCart::class, [
            'arrSelection' => [
                'cart'        => $this->cart,
                'appartement' => $this->appartement,
                'gaeste'      => $this->gaeste,
            ]
        ] )->handle();

        // rerender Cart:
        $this->emit( 'refreshCart' );

        $this->dispatchBrowserEvent( 'ltoast', [
            'type'    => 'success',
            'message' => $this->appartement->title . ' wurde hinzugefügt / aktualisiert',
        ] );


    }


    public function inc( $fieldname ) {
        return $this->routeMethod( 'inc' . ucfirst( $fieldname ) );
    }

    public function dec( $fieldname ) {
        return $this->routeMethod( 'dec' . ucfirst( $fieldname ) );
    }

    private function routeMethod( $method ) {
        if ( method_exists( $this, $method ) ) {
            return $this->$method();
        }

        return false;
    }

    public function hydrate() {
        $this->resetValidation();
    }

    public function render() {
        $this->emit( 'initpopper' );

        return view( 'livewire.add-appartement-to-cart' );
    }


}
