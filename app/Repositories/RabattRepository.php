<?php


namespace App\Repositories;

use App\Factories\RabattFactory;
use App\Models\Rabatt;
use Illuminate\Support\Collection;
use Statamic\Facades\Entry;

class RabattRepository {

    /**
     *
     * @return \Statamic\Stache\Query\EntryQueryBuilder
     */
    protected function query() {
        return Entry::query()
                    ->where( 'published', true )
                    ->where( 'collection', 'rabatte' );
    }

    /**
     * @return Collection | null
     */
    public function all() {
        return Entry::query()
                    ->where( 'collection', 'rabatte' )
                    ->get()
                    ->map( function ( $item ) {
                        return app( RabattFactory::class )->initByEntry( $item );
                    } );
    }

    public function active() {
        return $this->all()->filter(function($item) {
            return $item->isActive();
        });
    }

    /**
     * @return Rabatt | null
     */
    public function getActiveRabatt() {
        return $this->active()->first();
    }


}
