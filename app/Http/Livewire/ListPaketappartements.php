<?php

namespace App\Http\Livewire;

use App\Factories\AppartementFactory;
use App\Jobs\ProcessAddPaketAppartementToCart;
use App\Models\Appartement;
use App\Models\Cart;
use App\Models\Paket;
use App\Repositories\RabattRepository;
use App\Services\PackagePrices;
use App\Services\PaketPriceCalculator;
use App\Services\SaisonManager;
use Livewire\Component;
use Livewire\WithPagination;
use Statamic\Extensions\Pagination\LengthAwarePaginator;
use Statamic\Facades\Entry;

class ListPaketappartements extends Component {
    use WithPagination, EntryModelTrait;

    /**
     * @var Cart | null
     */
    protected $cart = null;
    protected $is_hs = true;
    /**
     * @var null | Paket
     */
    protected $paket = null;

    public $refresh = false;


    protected $listeners = [
        'refreshCart' => 'refresh'
    ];
    /**
     * @var \App\Models\Rabatt|mixed|null
     */
    protected $rabatt;

    public function mount() {
        $this->initObjects();
    }

    public function hydrate() {
        $this->initObjects();
    }

    protected function initObjects() {
        if ( $this->cart === null ) {
            $this->cart  = cart();
            $this->paket = $this->cart->pakete()->first();
            $this->is_hs = app( SaisonManager::class )->isInHauptsaison( $this->cart->getPeriod() );
        }
    }


    public function refresh() {
        $this->refresh = ! $this->refresh;
    }

    public function select( $slug ) {

        $this->initObjects();

        $appartement  = $this->findAppartementOrDie( $slug );
        $cart         = $this->cart;
        $this->rabatt = app( RabattRepository::class )->getActiveRabatt();

        $cart->items()->where( 'class', Appartement::class )->delete();

        app( ProcessAddPaketAppartementToCart::class, [
            'arrSelection' => [
                'cart'          => $cart,
                'teilnehmer'    => $cart->teilnehmer,
                'begleitperson' => $cart->gaeste,
                'paket'         => $this->paket,
                'appartement'   => $appartement,
                'rabatt'        => $this->rabatt
            ]
        ] )->handle();

        // rerender Cart:
        $this->emit( 'refreshCart' );
        $this->dispatchBrowserEvent( 'ltoast', [
            'type'    => 'success',
            'message' => $appartement->title . ' wurde hinzugefügt / aktualisiert',
        ] );


    }


    protected function getAppartements() {
        $this->rabatt = app( RabattRepository::class )->getActiveRabatt();
//        $gaeste = $this->cart->gaeste;
//        $this->mncnow = microtime();
        /**
         * @var $entries LengthAwarePaginator;
         */
        $entries = Entry::query()
                        ->where( 'collection', 'appartements' )
                        ->where( 'testapp', false )
                        ->where( 'collection', 'appartements' )
                        ->orderBy( 'order' )
//                        ->where( 'gaeste_max', '>=', $gaeste )
                        ->paginate( 30 );
        $entries->getCollection()->transform( function ( $item ) {


            $appartement     = app( AppartementFactory::class )->initByEntry( $item );
            $calculator      = app( PaketPriceCalculator::class )->input(
                $this->paket,
                $appartement->appartementklasse,
                $this->cart->teilnehmer,
                $this->cart->gaeste,
                $this->is_hs
            );
            $appartement->ez = $this->cart->persons() == 1 ?
                app( PackagePrices::class, [ 'model' => $this->paket ] )->getPriceEZ( $appartement->appartementklasse, $this->is_hs )
                : null;
            $appartement->initPricedisplay( $calculator, $this->rabatt );

            if ( $appartement->inCart( $this->cart ) ) {
                $appartement->setStatus( Appartement::STATUS_NOT_AVAILABLE, 'Ihr gewähltes Appartement' );
            }
            if ( ! $appartement->availableIn( $this->cart->checkin, $this->cart->checkout ) ) {
                $appartement->setStatus( Appartement::STATUS_NOT_AVAILABLE, 'Für den ausgewählten Zeitraum bereits reserviert.' );
            }

            return $appartement;
        } );

        return $entries;
    }

    public function paginationView() {
        return '_layouts._pagination';
    }


    public function render() {
        return view( 'livewire.list-paketappartements', [
            'appartements' => $this->getAppartements(),
            'paket'        => $this->paket
        ] );
    }
}
