<?php


namespace App\Services;


use App\Factories\SaisonFactory;
use Carbon\CarbonPeriod;

class SaisonManager {


    /**
     * @param CarbonPeriod $period
     *
     * @return bool
     */
    public function isInHauptsaison(CarbonPeriod $period) {
        $hs = app(SaisonFactory::class)->getCachedHauptsaisons();
        foreach ( $hs as $hs_period ) {
            if ( $hs_period->overlaps( $period ) ) {
                return true;
            }
        }
        return false;
    }


}
