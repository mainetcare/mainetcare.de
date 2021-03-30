<?php

namespace App\Models;

use App\Exceptions\BookingException;
use App\Presenter\PaketPresenter;
use Laracasts\Presenter\PresentableTrait;
use Statamic\Facades\Term;

class Paket extends EntryModel implements AddToCartContract {

    use PresentableTrait, IsBlockableTrait, HasBulkPricesTrait, PriceDisplayTrait;

    protected $presenter = PaketPresenter::class;

    public function getCartCategoryAttribute() {
        return $this->getBereich();
    }

    /**
     * @return string mixed
     */
    public function getBereich() {
        $bereich = collect( $this->entry->get( 'angebotsbereich' ) )->first();
        if ( ! $bereich ) {
            return 'urlaubspaket';
        }

        return $bereich;
    }

    public function getNightsAttribute() {
        return $this->entry->get( 'nights' );
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getGruppe() {
        return collect( $this->entry->get( 'angebotsgruppe' ) );
    }

    public function getPrices() {
        /**
         * @var $entry \Statamic\Entries\Entry
         */
        $entry = $this->entry;
        if ( ! $this->entry ) {
            return collect( [] );
        }
        $taxonomie = Term::findBySlug( $entry->get( 'appartementklasse' ), 'appartementklasse' );
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
//
//    public function getMaxTeilnehmer() {
//        return 2;
//    }
//
//    public function getMaxBegleitpersonen() {
//        return 2;
//    }

    public function getMaxBookablePersons() {
        return $this->entry->get( 'bookable_persons' ) ?? 2;
    }

}
