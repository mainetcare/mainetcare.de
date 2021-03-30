<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use Illuminate\Support\Collection;
use Livewire\Component;

class Warenkorb extends Component {

    public $refresh = false;

    /**
     * @var null | Cart
     */
    protected $cart = null;

    /**
     * @var null | Collection
     */
    protected $remaining = null;

//    public function mount() {
////        $this->cart      = cart();
//    }

    protected $listeners = [
        'refreshCart'
    ];

    public function refreshCart() {
        $this->refresh = true;
    }

    public function delete( $id ) {
        $item = booking_session()->cart()->items()->find( $id );
        if ( $item ) {
            $item->delete();
            $this->emit('refreshCart');
        }
    }

    public function render() {

        return view( 'livewire.warenkorb', [
            'cart'      => cart(),
            'remaining' => cart()->remaining()
        ] );
    }
}
