<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NavigateBooking extends Component {

    public $refresh = false;

    public $next = '';
    public $prev = '';

    protected $listeners = [
        'refreshCart'
    ];

    public function refreshCart() {
        $this->refresh = true;
    }

    public function render() {

        $session = booking_session();
        $this->next = $session->gateForStep() ? $session->next() : null;
        $this->prev = $session->back();

        return view( 'livewire.navigate-booking' );
    }
}
