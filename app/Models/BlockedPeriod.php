<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedPeriod extends MncModel {

    const STATUS_RESERVIERT = 'reserviert';
    const STATUS_GEBUCHT = 'gebucht';
    const STATUS_GESCHLOSSEN = 'geschlossen';


    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function blockable()
    {
        return $this->morphTo();
    }

}
