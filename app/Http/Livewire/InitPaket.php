<?php

namespace App\Http\Livewire;

use App\Exceptions\BookingException;
use App\Factories\PaketFactory;
use App\Jobs\ProcessInitPaketInCart;
use App\Models\Paket;
use App\Services\BookingSessions\BookingSessionPaket;
use App\Services\BookingSessions\BookingSessionRouter;
use App\Services\BookingSessionValidator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Validator;

class InitPaket extends Component {

    use InitializesBookingDatesTrait;

    public $teilnehmer = 0;
    public $gaeste = 1;

    public $slug = '';
    public $size = null;

    /**
     * @var null | Paket
     */
    protected $paket = null;


    public function mount( $size = null, $force_new_init = false ) {

        $this->size = $size;

        if ( $force_new_init || ! $this->isCartAvailableViaSession() ) {
            return $this->initNew();
        }

        return $this->initByCart();

    }

    protected function initByCart() {

        $cart                    = cart();
        $this->teilnehmer        = $cart->teilnehmer;
        $this->gaeste            = $cart->gaeste;
        $this->checkin           = $cart->checkin->format( 'd.m.Y' );
        $this->start_date_picker = $this->checkin;
        $this->min_date          = $this->getFirstPossibleCheckinDate()->format( 'd.m.Y' );

        return null;
    }

    /**
     * @throws \Exception
     */
    protected function initNew() {
        $this->teilnehmer        = '';
        $this->gaeste            = '';
        $this->checkin           = '';
        $this->start_date_picker = $this->getFirstPossibleCheckinDate()->format( 'd.m.Y' );
        $this->min_date          = $this->start_date_picker;

        return null;
    }


    public function submit( $formdata ) {

        $this->paket = app( PaketFactory::class )->initBySlug( $this->slug );
        if ( ! $this->paket ) {
            throw new ModelNotFoundException();
        }
        $max = $this->paket->getMaxBookablePersons();

        $this->teilnehmer = $formdata['teilnehmer'] ?? 0;
        $this->gaeste     = $formdata['gaeste'] ?? 0;
        $this->checkin    = $formdata['checkin'] ?? '';
        $this->validate( [
            'teilnehmer' => [
                'required',
                'integer',
                'between:1,' . $max,
            ],
            'gaeste'     => [
                'required',
                'integer',
                'between:0,' . $max,
            ],
            'checkin'    => [
                'required',
                'date',
                'after:2021-05-28',
            ]
        ], [
            'teilnehmer.required' => 'Bitte geben Sie die Anzahl an Teilnehmern an',
            'teilnehmer.between'  => 'Bitte geben Sie die Anzahl an Teilnehmern (maximal ' . $max . ') an',
            'gaeste.required'     => 'Bitte geben Sie die Anzahl an Begleitpersonen an',
            'gaeste.between'      => 'Bitte geben Sie die Anzahl an Begleitpersonen (maximal ' . $max . ') an',
            'checkin.after'       => 'Unsere Pakete sind buchbar ab dem 28.05.2021',
            'checkin.date'        => 'Bitte geben Sie ein korrektes Datum an',
            'checkin.required'    => 'Bitte wählen Sie aus, ab wann Sie das Paket buchen möchten',
        ] );

        // add special "rule":
        if ( $this->teilnehmer + $this->gaeste > $max ) {
            $this->addError( 'bookable_persons', 'Für mehr als ' . $max . ' Teilnehmer nehmen Sie bitte direkt Kontakt zu uns auf.' );

            return;
        }

        try {
            $this->initBookingSession();

        } catch ( \Throwable $e ) {
            $this->addError( 'unknown', 'Ein unbekannter Fehler ist aufgetreten.' );

            return;
        }

        $this->emit( 'refreshCart' );
        $this->redirect( route( 'paket-select.index' ) );

    }

    public function render() {
        return view( 'livewire.initpaket' );
    }

    protected function initBookingSession() {
        $this->paket = app( PaketFactory::class )->initBySlug( $this->slug );
        if ( ! $this->paket ) {
            throw new ModelNotFoundException();
        }
        app( BookingSessionRouter::class )->setActiveSession( app( BookingSessionPaket::class ) );
        booking_session()->reset();
        $cart = booking_session()->cart();
        // init the Cart:
        app( ProcessInitPaketInCart::class, [
            'arrSelection' => [
                'cart'       => $cart,
                'paket'      => $this->paket,
                'teilnehmer' => $this->teilnehmer,
                'gaeste'     => $this->gaeste,
                'checkin'    => new Carbon( $this->checkin ),
            ]
        ] )->handle();
    }

    protected function isCartAvailableViaSession() {
        return app( BookingSessionRouter::class )->isSessionRunning()
               &&
               app( BookingSessionValidator::class )->validatePaketSelected();
    }

}
