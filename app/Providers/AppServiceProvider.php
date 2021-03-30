<?php

namespace App\Providers;

use App\Services\BookingSessions\BookingSessionRouter;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Agent\Agent;
use Statamic\Facades\CP\Nav;
use View;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {

        $this->app->singleton( BookingSessionRouter::class, function ( $app ) {
            return new BookingSessionRouter();
        } );

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        // Statamic Backend
        Nav::extend( function ( $nav ) {
            $nav->content( 'Sperrzeiten' )
                ->route( 'sperrzeiten' );
        } );
        $agent = new Agent();
        View::share( 'agent', $agent );
        View::share( 'is_mobile', $agent->isMobile() && ! $agent->isTablet() );

    }
}
