<?php

namespace App\Models;

use App\Presenter\AngebotPresenter;
use App\Services\BulkPrices;
use Illuminate\Support\Collection;
use Laracasts\Presenter\PresentableTrait;

class Angebot extends EntryModel implements AddToCartContract {

    const ME_STD = 'std';
    const ME_STUECK = 'stk';
    const ME_PAKET = 'paket';
    const ME_KURSE = 'kurs';
    const ME_TAGE = 'tag';

    use PresentableTrait, IsBlockableTrait, HasBulkPricesTrait;

    protected $presenter = AngebotPresenter::class;

    protected $units = null; // Temp Store for PriceUnits


    public static function getListME() {
        return [
            self::ME_STD    => 'Stunden',
            self::ME_STUECK => 'Stück',
            self::ME_PAKET  => 'Paket',
            self::ME_KURSE  => 'Kurse',
            self::ME_TAGE   => 'Tage',
        ];
    }

    /**
     * @return string
     */
    public function getCartCategoryAttribute() {
        return $this->getBereich();
    }

    /**
     * @return string mixed
     */
    public function getBereich() {
        return collect( $this->entry->get( 'angebotsbereich' ) )->first();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getGruppe() {
        return collect( $this->entry->get( 'angebotsgruppe' ) );
    }



}
