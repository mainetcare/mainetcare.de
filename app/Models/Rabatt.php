<?php

namespace App\Models;

use App\Exceptions\BookingException;
use App\Http\Livewire\EntryModelTrait;
use App\Presenter\AppartementPresenter;
use App\Services\PackagePrices;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Laracasts\Presenter\PresentableTrait;
use Statamic\Facades\Term;
use Statamic\Taxonomies\LocalizedTerm;

class Rabatt extends EntryModel implements AddToCartContract {


    public function getCartCategoryAttribute() {
        return '';
    }

    public function isActive() {
        if ( ! $this->entry->published() ) {
            return false;
        }

        $today = new Carbon( 'today' );
        $start = $this->entry->get( 'aktion_start' );
        $end   = $this->entry->get( 'aktion_end' );

        if ( CarbonPeriod::create( $start, $end )->overlaps( CarbonPeriod::create( $today, $today ) ) ) {
            return true;
        }

        return false;
    }

    public function getDiscountPercent() {
        return $this->entry->get('rabatt_prozent');
    }

    public function showTeaser() {
        return $this->entry->get('homepage');
    }

    public function effects( EntryModel $model ) {
        $collection = $model->entry->collection()->handle();
        $effects = $this->entry->get( 'effects_' . $collection );
        if( ! $effects) {
            return false;
        }
        $list = $this->entry->get($collection);
        if(is_array($list) && count($list) > 0) {
            return in_array($model->id, $list);
        }
        // there is no whitelist, so it effects every model of collection:
        return true;
    }


}
