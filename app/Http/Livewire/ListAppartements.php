<?php

namespace App\Http\Livewire;

use App\Factories\AppartementFactory;
use App\Jobs\ProcessAddAppartementToCart;
use App\Models\Appartement;
use App\Models\Cart;
use App\Models\Rabatt;
use App\Repositories\RabattRepository;
use App\Services\AppartementPriceCalculator;
use App\Services\DiscountCalculator;
use App\Services\PriceDisplay;
use App\Services\SaisonManager;
use Livewire\Component;
use Livewire\WithPagination;
use Statamic\Extensions\Pagination\LengthAwarePaginator;
use Statamic\Facades\Entry;

class ListAppartements extends Component {

    use WithPagination, EntryModelTrait;

    /**
     * @var Cart | null
     */
    protected $cart = null;
    protected $is_hs = true;
    public $refresh = false;

    /**
     * @var null | Rabatt
     */
    protected $rabatt = null;


    protected $listeners = [
        'refreshCart' => 'refresh'
    ];


    public $mncnow = null;

    public function mount( Cart $cart ) {
        $this->cart  = $cart;
        $this->is_hs = app( SaisonManager::class )->isInHauptsaison( $cart->getPeriod() );
    }

    public function hydrate() {
        if ( $this->cart === null ) {
            $this->cart  = cart();
            $this->is_hs = app( SaisonManager::class )->isInHauptsaison( $this->cart->getPeriod() );
        }
    }


    public function refresh() {
        $this->refresh = ! $this->refresh;
    }

    public function select( $slug ) {

        $appartement  = $this->findAppartementOrDie( $slug );
        $cart         = cart();
        $this->rabatt = app( RabattRepository::class )->getActiveRabatt();

        $cart->items()->where( 'class', Appartement::class )->delete();
        $this->rabatt = app( RabattRepository::class )->getActiveRabatt();

        app( ProcessAddAppartementToCart::class, [
            'arrSelection' => [
                'cart'        => $cart,
                'appartement' => $appartement,
                'gaeste'      => $cart->gaeste,
                'rabatt'      => $this->rabatt,
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
        $gaeste       = $this->cart->gaeste;
        $this->mncnow = microtime();
        /**
         * @var
         */
        $this->rabatt = app( RabattRepository::class )->getActiveRabatt();
        /**
         * @var $entries LengthAwarePaginator;
         */
        $entries = Entry::query()
                        ->where( 'published', true )
                        ->where( 'testapp', false )
                        ->where( 'collection', 'appartements' )
                        ->orderBy( 'order' )
                        ->where( 'gaeste_max', '>=', $gaeste )
                        ->paginate( 30 );
        $entries->getCollection()->transform( function ( $item, $key ) {
            $appartement = app( AppartementFactory::class )->initByEntry( $item );
            $calculator  = app( AppartementPriceCalculator::class )->input( $appartement, $this->cart->nights, $this->is_hs );

            $appartement->initPricedisplay( $calculator, $this->rabatt );

            $appartement->setAvailableByGuests( $this->cart->gaeste );
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

        return view( 'livewire.list-appartements', [
            'appartements' => $this->getAppartements()
        ] );
    }
}
