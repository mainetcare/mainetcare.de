<?php

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\SelectAngebotController;
use App\Http\Controllers\TestpageController;
use Illuminate\Support\Facades\Route;
use Statamic\Facades\OAuth;
use Statamic\Statamic;

// I like having a named route for the homepage
// Route::get( '/', '\Statamic\Http\Controllers\FrontendController@index' )->name( 'home' );
Route::get( '/', [ HomepageController::class, 'index' ] )->name( 'home' );
Route::get( '/testpage', [ TestpageController::class, 'index' ] )->name( 'testpage' );
//
Route::prefix( 'appartement-buchen' )
     ->middleware( 'bookingsession.appartement' )
     ->group( function () {
         Route::get( 'appartementwahl', 'SelectAppartementController@index' )->name( 'appartement-select.index' );
         Route::post( 'appartementwahl', 'SelectAppartementController@store' )->name( 'appartement-select.store' );

         Route::get( 'erlebniswelt-pferd', 'SelectAngebotController@pferd' )->name( 'pferd-select.index' );
         Route::get( 'erlebniswelt-fitness', 'SelectAngebotController@fitness' )->name( 'fitness-select.index' );
         Route::get( 'erlebniswelt-wellness', 'SelectAngebotController@wellness' )->name( 'wellness-select.index' );
         Route::get( 'erlebniswelt-kunst', 'SelectAngebotController@kunst' )->name( 'kunst-select.index' );
         Route::get( 'erlebniswelt-funpark', 'SelectAngebotController@funpark' )->name( 'funpark-select.index' );
         Route::get( 'transferservice', 'SelectAngebotController@transferservice' )->name( 'transferservice-select.index' );

         Route::get( 'kontaktdaten', 'KontaktdatenController@index' )->name( 'kontaktdaten.index' );
         Route::get( 'zusammenfassung', 'SummaryController@index' )->name( 'summary.index' );
         Route::get( 'vielen-dank', 'SummaryController@store' )->name( 'summary.store' );

     } );

Route::prefix( 'urlaubspaket-buchen' )
     ->middleware( 'bookingsession.paket' )
     ->group( function () {
         Route::get( 'appartements-fuer-paket', 'SelectPaketController@index' )->name( 'paket-select.index' );
         Route::get( 'pferdepension', [ SelectAngebotController::class, 'pferdepension' ] )->name( 'paket-pferdepension-select.index' );
         Route::get( 'transferservice', 'SelectAngebotController@transferservice' )->name( 'paket-transferservice-select.index' );

         Route::get( 'kontaktdaten', 'KontaktdatenController@index' )->name( 'paket-kontaktdaten.index' );
         Route::get( 'zusammenfassung', 'SummaryController@index' )->name( 'paket-summary.index' );
         Route::get( 'vielen-dank', 'SummaryController@store' )->name( 'paket-summary.store' );

     } );

Route::middleware( 'auth' )->group( function () {
    Route::get( 'sperrzeiten', [ \App\Http\Controllers\SperrzeitenController::class, 'index' ] )->name( 'statamic.cp.sperrzeiten' );
    Route::get( 'sperrzeiten/{id}', [ \App\Http\Controllers\SperrzeitenController::class, 'edit' ] )->name( 'sperrzeiten.edit' );
} );
