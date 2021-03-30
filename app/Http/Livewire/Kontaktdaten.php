<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Kontaktdaten extends Component {

    public $vorname = '';
    public $name = '';
    public $telefon = '';
    public $email = '';

    public $strasse = '';
    public $plz = '';
    public $ort = '';

    public $agb = '';
    public $hinweise = '';

    public function render() {
        return view( 'livewire.kontaktdaten' );
    }

    public function mount() {
        $this->agb = '';

        if ( $contact = cart()->contact ) {
            $this->vorname  = $contact->vorname;
            $this->name     = $contact->name;
            $this->telefon  = $contact->telefon;
            $this->email    = $contact->email;
            $this->strasse  = $contact->strasse;
            $this->plz      = $contact->plz;
            $this->ort      = $contact->ort;
            $this->hinweise = $contact->hinweise;
        }
    }


    public function submit( $formdata ) {

        /**
         * the checkbox gets updated by javascript so lets use the formdata to update the value
         */
        $this->agb = $formdata['agb'];

        // validate the formadata
        $pass = $this->validate( [
            'vorname'  => 'string|nullable',
            'name'     => 'required',
            'email'    => 'required|email',
            'strasse'  => 'required',
            'telefon'  => 'string|nullable',
            'plz'      => 'required',
            'ort'      => 'required',
            'agb'      => 'required',
            'hinweise' => 'string|nullable'
        ], [
            'agb.required' => 'Für die Buchungsanfrage ist es notwendig, dass Sie unsere AGB akzeptieren.'
        ] );

        $pass = array_merge( $pass, [ $this->hinweise, $this->vorname ] );

        // save it in the cart:
        cart()->addContactData( $pass );

        // goto zusammenfassung
        $this->emit( 'refreshCart' );

        $this->redirect( route( 'summary.index' ) );

    }

    public function updated( $field ) {
        $this->validateOnly( $field, [
            'email' => 'email',
        ] );
    }

}
