<?php

namespace App\Models;

use App\Exceptions\BookingException;
use App\Presenter\AppartementPresenter;
use App\Services\PackagePrices;
use Illuminate\Support\Collection;
use Laracasts\Presenter\PresentableTrait;
use Statamic\Facades\Term;
use Statamic\Taxonomies\LocalizedTerm;

class Appartement extends EntryModel implements AddToCartContract {

    use IsBlockableTrait, PresentableTrait, PriceDisplayTrait;

    const STATUS_NOT_AVAILABLE = 'na';

    const MESSAGE_NOT_ENOUGH_GUESTS = 'Verfügbar ab 2 Personen';

    protected $presenter = AppartementPresenter::class;

    /**
     * @var null | LocalizedTerm
     */
    protected $appartement_klasse = null;

    /**
     * Liefert die Preise für eine individuelle Buchung
     * @return Collection | mixed
     * @throws BookingException
     */
    public function getPrices() {
        /**
         * @var $entry \Statamic\Entries\Entry
         */
        $entry = $this->entry;
        if ( ! $this->entry ) {
            throw new BookingException( 'Appartment nicht initialisiert: ID=' . $this->id );
        }
        $taxonomie = $this->klasse();
        if ( ! $taxonomie ) {
            throw new BookingException( 'Für Appartement: "' . $this->entry->title . '" sind keine Preise festgelegt!' );
        }
        $prices = collect( $taxonomie->get( 'preise' ) );
        if ( $prices->count() == 0 ) {
            throw new BookingException( 'Für Appartement: "' . $this->entry->title . '" sind keine Preise festgelegt!' );
        }

        return $prices->map( function ( $item, $key ) {
            return get_price_as_float( $item );
        } );
    }

    /**
     * @return LocalizedTerm | null
     */
    public function klasse() {
        if ( $this->appartement_klasse === null ) {
            $this->appartement_klasse = Term::findBySlug( $this->entry->get( 'appartementklasse' ), 'appartementklasse' );
        }

        return $this->appartement_klasse;
    }

    /**
     * Liefert die Pauschalen (z.B. Endreinigung)
     * @return Collection | mixed
     * @throws BookingException
     */
    public function getPauschalen() {
        /**
         * @var $entry \Statamic\Entries\Entry
         */
        $entry = $this->entry;
        if ( ! $this->entry ) {
            throw new BookingException( 'Appartment nicht initialisiert: ID=' . $this->id );
        }
        $taxonomie = $this->klasse();
        if ( ! $taxonomie ) {
            throw new BookingException( 'Für Appartement: "' . $this->entry->title . '" sind keine Preise festgelegt!' );
        }
        $pauschalen = collect( $taxonomie->get( 'pauschalen' ) );
        if ( $pauschalen->count() == 0 ) {
            return $pauschalen;
        }

        return $pauschalen->map( function ( $item, $key ) {
            $item['preis_pauschale'] = get_price_as_float( $item['preis_pauschale'] );

            return collect( $item );
        } );
    }


    /**
     * @param float $price
     *
     * @deprecated
     */
    public function setCurrentPrice( float $price ) {
        $this->entry->set( 'current_price', $price );
    }

    /**
     * @return float
     * @deprecated
     */
    public function getCurrentPrice() {
        return (float) $this->entry->get( 'current_price' );
    }


    public function setAvailableByGuests( $gaeste ) {
        $max_gaeste = (int) $this->entry->get( 'gaeste_max' );
        if ( $gaeste < 2 && $max_gaeste > 2 ) {
            $this->setStatus( Appartement::STATUS_NOT_AVAILABLE, self::MESSAGE_NOT_ENOUGH_GUESTS );
        } else {
            $this->resetStatus();
        }
    }

    public function getZimmerAttribute() {
        return $this->entry->get( 'anzahl_schlafzimmer' );
    }

    public function getLageAttribute() {
        return strtoupper( $this->entry->get( 'lage' ) );
    }

    public function getAppartementklasseAttribute() {
        return $this->entry->appartementklasse;
    }

    public function inCart( Cart $cart ) {
        return $cart
                   ->items()
                   ->where( 'class', Appartement::class )
                   ->where( 'model_id', $this->id )
                   ->count() > 0;
    }

    public function isAvailable() {
        return ! ( $this->status == self::STATUS_NOT_AVAILABLE );
    }


    public function getCartCategoryAttribute() {
        return 'appartements';
    }
}
