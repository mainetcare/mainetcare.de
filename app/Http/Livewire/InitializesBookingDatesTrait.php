<?php


namespace App\Http\Livewire;


use App\Repositories\GlobalRepository;
use Carbon\Carbon;

trait InitializesBookingDatesTrait {


    public $checkin = '';
    public $min_date = '';
    public $start_date_picker = '';

    /**
     * @return Carbon
     */
    protected function getFirstPossibleCheckinDate() {
        $tomorrow = Carbon::now()->addDays( 1 );
        try {
            $allowed_booking = new Carbon( GlobalRepository::getStartBooking() );
            if ( $allowed_booking->isPast() ) {
                return $tomorrow;
            }
            return $allowed_booking;
        } catch ( \Exception $e ) {
            return $tomorrow;
        }
    }

}


