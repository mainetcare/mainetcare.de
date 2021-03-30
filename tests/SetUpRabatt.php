<?php

namespace Tests;


use App\Models\Rabatt;
use Illuminate\Support\Carbon;
use Statamic\Facades\Entry;
use Statamic\Facades\Stache;

/**
 * Trait CreatesUsers
 * @package Tests
 */
trait SetUpRabatt {




    public function setUpRabatt() {
        // Shift all real Aktionen Start End so they dont interfere with the testing entries
        $entries = Entry::query()
                        ->where( 'collection', 'rabatte' )
                        ->where( 'published', '<>', false )
                        ->get();
        foreach ( $entries as $entry ) {
            /**
             * @var $entry \Statamic\Entries\Entry
             */
            $start = new Carbon( $entry->get( 'aktion_start' ) );
            $end   = new Carbon( $entry->get( 'aktion_end' ) );
            $entry->set( 'aktion_start', $start->clone()->subYears( 20 )->toDateString() );
            $entry->set( 'aktion_end', $end->clone()->subYears( 20 )->toDateString() );
            $entry->set( 'aktion_start_save', $start->toDateString() );
            $entry->set( 'aktion_end_save', $end->toDateString() );
            $entry->save();
        }
    }

    public function tearDownRabatt() {
        $entries = Entry::query()
                        ->where( 'collection', 'rabatte' )
                        ->where( 'published', '<>', false )
                        ->get();
        foreach ( $entries as $entry ) {
            /**
             * @var $entry \Statamic\Entries\Entry
             */
            $start = $entry->get( 'aktion_start_save' );
            $end   = $entry->get( 'aktion_end_save' );
            $entry->set( 'aktion_start', $start );
            $entry->set( 'aktion_end', $end );
            $entry->remove( 'aktion_start_save' );
            $entry->remove( 'aktion_end_save' );
            $entry->save();
        }
    }

    public function setRabattActive( Rabatt $rabatt ) {
        $rabatt->entry->set( 'aktion_start_save', $rabatt->entry->get( 'aktion_start' ) );
        $rabatt->entry->set( 'aktion_end_save', $rabatt->entry->get( 'aktion_end' ) );
        $rabatt->entry->set( 'aktion_start', Carbon::yesterday()->toDateString() );
        $rabatt->entry->set( 'aktion_end', Carbon::tomorrow()->toDateString() );
        $rabatt->entry->publish();
    }

    public function setRabattInactive( Rabatt $rabatt ) {
        $rabatt->entry->set( 'aktion_start', $rabatt->entry->get( 'aktion_start_save' ) );
        $rabatt->entry->set( 'aktion_end', $rabatt->entry->get( 'aktion_end_save' ) );
        $rabatt->entry->remove( 'aktion_start_save' );
        $rabatt->entry->remove( 'aktion_end_save' );
        $rabatt->entry->unpublish();
    }


}
