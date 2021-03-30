<?php


namespace App\Repositories;


use Statamic\Globals\GlobalSet;

class GlobalRepository {


    public static function getStartBooking() {
        return GlobalSet::findByHandle( 'kalender' )->inCurrentSite()->get( 'start_booking');
    }


}
