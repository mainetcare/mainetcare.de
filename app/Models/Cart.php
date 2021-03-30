<?php

namespace App\Models;

use App\Factories\AngebotFactory;
use App\Factories\AppartementFactory;
use App\Factories\PaketFactory;
use App\Presenter\CartPresenter;
use App\Repositories\CartItemRepository;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Laracasts\Presenter\PresentableTrait;

/**
 * Class Cart
 * @package App\Models
 */
class Cart extends MncModel {

    use PresentableTrait;

    protected $presenter = CartPresenter::class;

    /**
     * We use MEMORY Connection for Cart and CartItems
     * @var string
     */
//    protected $connection = 'cart';


    protected $dates = [
        'checkin',
        'checkout',
        'sent_at'
    ];

    public const KAT_APPARTEMENT = 'Appartement';
    public const KAT_PENSION = 'Pensionsstall für das eigene Pferd';
    public const KAT_ERLEBNIS = 'Erlebniswelten';
    public const KAT_SONSTIGES = 'Sonstiges';
    public const KAT_PAUSCHALEN = 'Pauschalen';

    const STATUS_SENT = 'sent';
    const STATUS_SENDING = 'sending';

//    protected static function booted() {
//        static::saved( function ( $cart ) {
//            booking_session()->setCart($cart);
//        } );
//    }

    /**
     * @return \Carbon\CarbonPeriod
     */
    public function getPeriod() {
        return CarbonPeriod::create( $this->checkin, $this->checkout );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items() {
        return $this->hasMany( CartItem::class );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pauschalen() {
        return $this->items()->where('cat', self::KAT_PAUSCHALEN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|Collection
     */
    public function appartements() {
        return $this->items()->where( 'class', Appartement::class )->orderBy( 'title' )->get()->map( function ( $item ) {
            $app            = app( AppartementFactory::class )->initById( $item->model_id );
            $app->cart_item = $item;

            return $app;
        } );
    }

    public function hasPakete() {
        return $this->items()->where('class', Paket::class)->count() > 0;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|Collection
     */
    public function pakete() {
        return $this->items()->where( 'class', Paket::class )->orderBy( 'title' )->get()->map( function ( $item ) {
            $app            = app( PaketFactory::class )->initById( $item->model_id );
            $app->cart_item = $item;

            return $app;
        } );
    }

    /**
     * @return Paket
     */
    public function getPaket() {
        return $this->pakete()->first();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Collection|Collection
     */
//    public function pensionen() {
//        return $this->items()->where( 'class', Pferdepension::class )->orderBy( 'title' )->get()->map( function ( $item ) {
//            $model            = app( PferdepensionFactory::class )->initById( $item->model_id );
//            $model->cart_item = $item;
//
//            return $model;
//        } );
//    }

    public function angebote( $bereich = '' ) {
        return $this->items()->where( 'class', Angebot::class )
                    ->where( 'cat', $bereich )
                    ->orderBy( 'title' )->get()->map( function ( $item ) {
                $model            = app( AngebotFactory::class )->initById( $item->model_id );
                $model->cart_item = $item;

                return $model;
            } );
    }

    public function erlebniswelten() {
        $list        = [];
        $arrBereiche = AngebotBereich::getBereiche();
        foreach ( $arrBereiche as $key => $title ) {
            $row          = [];
            $row['title'] = $title;
            $row['list']  = $this->angebote( $key );
            $list[]       = $row;
        }

        return $list;
    }


    /**
     * @return int|mixed
     */
    public function getNightsAttribute( $value ) {
        if ( $value === null ) {
            if ( ! $this->checkin ) {
                return 0;
            }

            return $this->checkin->diffInDays( $this->checkout );
        }

        return $value;
    }

//    /**
//     * @param $value
//     *
//     * @return string
//     * @throws \App\Exceptions\PriceException
//     * @todo wrong class for this calculation
//     */
//    public function getSaisonAttribute( $value ) {
//        $is_hs = app( AppartementPriceCalculator::class )
//            ->whereHauptsaison( app( SaisonFactory::class )->getCachedHauptsaisons() )
//            ->whereBookingPeriod( $this->getPeriod() )
//            ->isHauptsaison();
//        $value = $is_hs ? 'hs' : 'ns';
//        return $value;
//    }

    /**
     * @param Appartement $app
     * @param int $amount
     * @param float $price
     *
     * @return CartItem
     * @deprecated
     *
     */
    public function addAppartement( Appartement $app, int $amount, float $price ) {
        /**
         * @var $item CartItem
         */
        $item = $this->items()->updateOrCreate( [
            'cat'      => $app->cart_category, // deprecated
            'title'    => $app->title,
            'class'    => get_class( $app ),
            'model_id' => $app->id,
        ] );
        $item->update( [
            'amount' => $amount,
            'total'  => $price
        ] );

        return $item;
    }

    public function addGaeste( int $gaeste ) {
        $this->update( [
            'gaeste' => $gaeste
        ] );
    }

    public function addBookingPeriod( $checkin, $checkout ) {
        $this->checkin  = $checkin;
        $this->checkout = $checkout;
        $this->save();
    }

//    public function addPferdepension( Pferdepension $model, int $amount, float $price ) {
//        /**
//         * @var $item CartItem
//         */
//        $item = $this->items()->updateOrCreate( [
//            'cat'      => $model->cart_category,
//            'title'    => $model->title,
//            'class'    => get_class( $model ),
//            'model_id' => $model->id,
//        ] );
//        $item->update( [
//            'amount' => $amount,
//            'total'  => $price
//        ] );
//
//        return $item;
//    }

    /**
     * @param array $cartinfo
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|object
     */
    public function updateOrCreateItem( array $cartinfo ) {


        // check if the necessary entries exits in arrData:

        $model = $cartinfo['model'];

        $attributes = [
            'model_id'  => $model->id,
            'title'     => $cartinfo['title'] ?? $model->title,
            'unit'      => $cartinfo['unit'],
            'cat'       => $model->cart_category,
            'class'     => get_class( $model ),
            'content'   => $cartinfo['content'],
            'amount'    => $cartinfo['amount'],
            'editroute' => $cartinfo['editroute'] ?? '',
            'total'     => $cartinfo['total'],
            'data'      => $cartinfo['data'] ?? null
        ];

        $item = $this->items()->where( [
            'model_id' => $attributes['model_id'],
            'unit'     => $attributes['unit'],
            'class'    => $attributes['class']
        ] )->first();

        if ( ! $item ) {
            $item = $this->items()->create( $attributes );
        } else {
            $item->update( $attributes );
        }

        return $item;
    }

    public function getSumTotal() {
        return $this->items()->sum( 'total' );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact() {
        return $this->belongsTo( Contact::class );
    }

    /**
     * @param $data
     *
     * @return Contact|\Illuminate\Database\Eloquent\Model
     */
    public function addContactData( $data ) {
        $contact = Contact::create( $data );
        $this->contact()->associate( $contact );
        $this->save();

        return $contact;
    }

    /**
     * @return Collection
     */
    public function remaining() {
        $persons   = $this->persons();
        $allocated = app( CartItemRepository::class, [ 'cart' => $this ] )->getSumAllocatedPersons();

        return collect( [
            'all'           => $persons - $allocated->get( 'all' ),
            'teilnehmer'    => $this->teilnehmer - $allocated->get( 'teilnehmer' ),
            'begleitperson' => $this->gaeste - $allocated->get( 'begleitperson' ),
        ] );
    }

    /**
     * returns all persons, teilnehmer with gaeste, only relevant for pakete
     * otherwise gaeste = persons
     * @return int
     */
    public function persons() {
        return (int) $this->teilnehmer + (int) $this->gaeste;
    }

    public function allPersonsAssigned() {
        return ! $this->remaining()->get( 'all' ) > 0;
    }

    public function isEmpty() {

        foreach ( [ 'checkin', 'checkout', 'teilnehmer', 'gaeste', 'contact_id' ] as $attribute ) {
            if ( $this->$attribute ) {
                return false;
            }
        }

        if ( $this->items()->count() > 0 ) {
            return false;
        }

        return true;
    }

    public function setSent() {
        $this->update( [
                'status'  => self::STATUS_SENT,
                'sent_at' => now()
            ]
        );
    }

    public function isSent() {
        return ! is_null( $this->sent_at );
    }


}
