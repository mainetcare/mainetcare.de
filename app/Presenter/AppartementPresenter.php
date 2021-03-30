<?php

namespace App\Presenter;

use Carbon\Carbon;
use Laracasts\Presenter\Presenter;


class AppartementPresenter extends Presenter {


    public function features() {
        return [
            $this->entity->entry->gaeste_max . ' ' . __pl( $this->entity->entry->gaeste_max, 'Gast' ),
            $this->entity->entry->anzahl_schlafzimmer . ' Schlafzimmer',
            $this->entity->entry->aussenerweiterung,
            $this->entity->entry->flaeche . ' m²',
            strtoupper($this->entity->entry->lage),
        ];
    }


}
