<?php

namespace App\Models;

use App\Presenter\VeranstaltungPresenter;
use Carbon\Carbon;
use Laracasts\Presenter\PresentableTrait;

class Veranstaltung extends EntryModel {

    use PresentableTrait, IsBlockableTrait, HasBulkPricesTrait;

    protected $presenter = VeranstaltungPresenter::class;

    public function getStartdateAttribute() {
        return new Carbon( $this->entry->get( 'startdate' ) );
    }

    public function getEnddateAttribute() {
        if ( ! $date = $this->entry->get( 'enddate' ) ) {
            return null;
        }

        return new Carbon( $date );
    }

}
