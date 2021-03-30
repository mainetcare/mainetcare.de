<?php

namespace App\Http\Livewire;

use App\Jobs\ContactformRequest;
use Livewire\Component;

class Kontaktform extends Component {

    public $name = '';
    public $email = '';
    public $betreff = '';
    public $hinweise = '';
    public $sent = false;
    public $agb = '';


    public function mount() {
        $this->sent = false;
        $this->agb = '';
    }


    public function submit( $formdata ) {

        /**
         * the checkbox gets updated by javascript so lets use the formdata to update the value
         */
        $this->agb = $formdata['agb'];

        // validate the formadata
        $data = $this->validate( [
            'name'     => 'required',
            'email'    => 'required|email',
            'betreff'  => 'string|nullable',
            'hinweise' => 'required',
            'agb'      => 'required',
        ], [
            'agb.required'      => 'Für eine Anfrage ist Ihre Zustimmung notwendig, wie wir Ihre Angaben speichern.',
            'name.required'     => 'Bitte geben Sie Ihren Namen an',
            'hinweise.required' => 'Bitte teilen Sie uns Ihr Anliegen mit',
            'email.required'    => 'Bitte geben Sie uns eine E-Mail für Rückfragen an',
            'email.email'       => 'Bitte geben Sie eine gültige E-Mail Adresse an'
        ] );

        // save it in the cart:
        $this->sendMail( $data );
        $this->sent = true;
    }

    public function sendMail( array $data ) {
        try {
            app( ContactformRequest::class, [ 'data' => $data ] )->handle();
        } catch ( \Exception $e ) {
            $this->addError( 'unknown', 'Ein unbekannter Fehler ist aufgetreten. Ihre Anfrage konnte nicht versendet werden.' );
        }
    }

    public function updated( $field ) {
        $this->validateOnly( $field, [
            'email' => 'email',
        ] );
    }

    public function render() {
        return view( 'livewire.kontaktform' );
    }

}
