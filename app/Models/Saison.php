<?php

namespace App\Models;

use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Saison extends Model {

    protected $dates = [
        'von',
        'bis'
    ];


//    public function getVonAttribute($value) {
//        if(!$value) {
//            $value = Carbon::now();
//        }
//        return $value;
//    }
//
//    public function getBisAttribute($value) {
//        if(!$value) {
//            $value = Carbon::now();
//        }
//        return $value;
//    }


    /**
     * @return CarbonPeriod
     */
    public function getPeriod() {
        return CarbonPeriod::create( $this->von, $this->bis );
    }

    /**
     * checks if a given date is in the saison period
     *
     * @param CarbonPeriod $period
     *
     * @return bool
     */
    public function overlaps( CarbonPeriod $period ) {
        return $this->getPeriod()->overlaps( $period );
    }


}
