<?php

namespace App\Http\Middleware;

use App\Exceptions\BookingException;
use App\Services\BookingSessions\BookingSessionRouter;
use App\Services\BookingSessionValidator;
use Closure;

class ValidateBookingAngebot {
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle( $request, Closure $next ) {
        $session   = booking_session();
        $validator = app( BookingSessionValidator::class, [ 'session' => $session ] );
        if ( ! $validator->validateHasAppartements() ) {
            $route = $session->getRouteOfStep( 1 );
            return redirect( $route )->withErrors( [
                'type' => 'Bitte wählen Sie zunächst ein Appartement aus.'
            ] );
        }
        if ( ! $validator->validateCheckinCheckout() ) {
            throw new BookingException( 'Fehler. Der Warenkorb ist nicht mehr verfügbar. Bitte neu wählen.' );
        }

        return $next( $request );
    }
}
