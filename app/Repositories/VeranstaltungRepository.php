<?php


namespace App\Repositories;

use App\Factories\PaketFactory;
use App\Factories\VeranstaltungFactory;
use Statamic\Facades\Entry;

class VeranstaltungRepository {

    public function __construct() {

    }

    /**
     *
     * @return \Statamic\Stache\Query\EntryQueryBuilder
     */
    protected function query() {
        $query = Entry::query()
                      ->where( 'published', true )
                      ->where( 'collection', app( VeranstaltungFactory::class )->getCollection() );
        $query->orderBy( 'startdate' , 'desc')
              ->orderBy( 'title' );

        return $query;
    }

    public function getVeranstaltungen() {
        return $this->query()->get()->map( function ( $item ) {
            return app( VeranstaltungFactory::class )->initByEntry( $item );
        } );
    }


}
