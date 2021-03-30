<?php


namespace App\Services\BookingSessions;

class BookingSessionRouter {


    /**
     * set the active booking session
     *
     * @param BookingSession $session
     *
     * @return BookingSession
     */
    public function setActiveSession( BookingSession  $session ) {
        session()->put( 'active_booking_session', get_class( $session ) );
        return $session;
    }

    /**
     * @return bool
     */
    public function isSessionRunning() {
        return $this->getActiveSession() !== null;
    }

    /**
     * @return BookingSession |null
     */
    public function getActiveSession() {

        $class = session()->get( 'active_booking_session' );

        if ( ! class_exists( $class ) ) {
            return null;
        }

        $object =  app( $class );

        if(! $object instanceof BookingSession) {
            return null;
        }

        return $object;
    }

}
