<?php

namespace App\Http\Livewire;

use App\Jobs\ProcessInitBookingAppartements;
use App\Repositories\GlobalRepository;
use App\Services\BookingSessions\BookingSessionRouter;
use App\Services\BookingSessionValidator;
use Carbon\Carbon;
use Livewire\Component;
use Route;

class InitAppartement extends Component {

    use InitializesBookingDatesTrait;

    public $gaeste = 1;


    public $checkout = '';
    public $end_date_picker = '';

    public $shouldredirect = true;
    public $size = '';

    protected $init = '';

    public function mount( $size = '', $init = false ) {

        $this->size = $size;
        if ( $init ) {
            return $this->initNew();
        }

        return $this->initByCart();
    }

    protected function initByCart() {

        if ( app( BookingSessionRouter::class )->isSessionRunning() && app( BookingSessionValidator::class )->validateCheckinCheckout() ) {
            $cart                    = cart();
            $this->gaeste            = $cart->gaeste;
            $this->checkin           = $cart->checkin->format( 'd.m.Y' );
            $this->start_date_picker = $this->checkin;
            $this->min_date          = $this->getFirstPossibleCheckinDate()->format( 'd.m.Y' );
            $this->checkout          = $cart->checkout->format( 'd.m.Y' );
            $this->end_date_picker   = $this->checkout;

            return null;
        }

        return $this->initNew();
    }

    /**
     * @throws \Exception
     */
    protected function initNew() {
        $this->gaeste            = '';
        $this->checkin           = '';
        $this->start_date_picker = $this->getFirstPossibleCheckinDate()->format( 'd.m.Y' );
        $this->end_date_picker   = $this->getFirstPossibleCheckinDate()->addDays( 3 )->format( 'd.m.Y' );
        $this->min_date          = $this->start_date_picker;
        $this->checkout          = '';

        return null;
    }

    public function inc() {
        $this->gaeste ++;
    }

    public function dec() {
        $this->gaeste --;
    }


    protected $rules = [
        'gaeste'   => 'required|integer|between:1,4',
        'checkin'  => 'required|date|after:2021-05-27',
        'checkout' => 'required|date|after:checkin'
    ];

    protected $messages = [
        'gaeste.required' => 'Bitte geben Sie die Anzahl an Gästen an',
        'gaeste.between'  => 'Bitte geben Sie zwischen 1 und 4 Gästen an',

        'checkin.after'    => 'Unsere Appartements sind ab dem 28.05.2021 buchbar',
        'checkin.required' => 'Bitte wählen Sie aus, ab wann Sie das Appartement buchen möchten',

        'checkout.required' => 'Bitte wählen Sie aus, bis wann Sie das Appartement buchen möchten',
        'checkout.date'     => 'Bitte wählen Sie aus, bis wann Sie das Appartement buchen möchten',
        'checkout.after'    => 'Bitte wählen das Checkout Datum nach dem Checkin',
    ];


    public function submit( $formdata ) {

        $this->gaeste   = $formdata['gaeste'];
        $this->checkin  = $formdata['checkin'];
        $this->checkout = $formdata['checkout'];

        $this->validate();

        // Everything set? Lets go:
        app( ProcessInitBookingAppartements::class, [
            'arrSelection' => [
                'gaeste'   => $this->gaeste,
                'checkin'  => new Carbon( $this->checkin ),
                'checkout' => new Carbon( $this->checkout ),
            ]
        ] )->handle();

        $this->emit( 'refreshCart' );

        if ( $this->shouldredirect ) {
            $this->redirect( route( 'appartement-select.index' ) );
        }


    }

    public function render() {
        return view( 'livewire.initappartement', [ 'size' => $this->size ] );
    }


}
