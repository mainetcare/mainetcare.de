<?php


namespace App\Models;


use Carbon\Carbon;
use Carbon\CarbonPeriod;

trait IsBlockableTrait {

    public function availableIn( Carbon $start, Carbon $end ): bool {
        if ( ! $this->exists ) {
            return false;
        }
        $blocked_periods = $this->blockedPeriods()->get();
        $p1              = CarbonPeriod::create( $start, $end );
        foreach ( $blocked_periods as $dateperiod ) {
            $p2 = CarbonPeriod::create( $dateperiod->start, $dateperiod->end );
            if ( $p1->overlaps( $p2 ) ) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string | Carbon $start
     * @param string | Carbon $end
     * @param string $ref_id
     *
     * @throws \Exception
     */
    public function block( $start, $end, $ref_id ) {
        if ( ! $start instanceof Carbon ) {
            $start = new Carbon( $start );
        }
        if ( ! $end instanceof Carbon ) {
            $end = new Carbon( $end );
        }
        if ( $start > $end ) {
            $dummy = $start;
            $start = $end;
            $end   = $dummy;
        }
        $this->blockedPeriods()->create( [
            'start'  => $start,
            'end'    => $end,
            'reason' => $ref_id
        ] );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blockedPeriods() {
        return $this->morphMany( BlockedPeriod::class, 'blockable' );
    }


}
