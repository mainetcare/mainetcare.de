<?php

namespace App\Http\Middleware;

use App\Services\BookingSessions\BookingSessionAppartement;
use App\Services\BookingSessions\BookingSessionRouter;
use Closure;

class InitBookingSessionAppartement
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        app(BookingSessionRouter::class)->setActiveSession(app(BookingSessionAppartement::class));
        booking_session()->setStepByRoute(route($request->route()->getName()));
        return $next($request);
    }
}
