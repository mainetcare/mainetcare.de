<?php


namespace App\Repositories;

use App\Factories\AngebotFactory;
use App\Factories\PaketFactory;
use App\Models\Angebot;
use App\Models\AngebotBereich;
use App\Models\AngebotGruppe;
use Statamic\Facades\Entry;

class PaketRepository {

    public function __construct() {

    }

    /**
     *
     * @return \Statamic\Stache\Query\EntryQueryBuilder
     */
    protected function query() {
        $query = Entry::query()
                      ->where( 'published', true )
                      ->where( 'collection', app( PaketFactory::class )->getCollection() );
        $query->orderBy( 'rf' )
              ->orderBy( 'title' );

        return $query;
    }

    public function getPakete() {
        return $this->query()->get()->map( function ( $item ) {
            return app( PaketFactory::class )->initByEntry( $item );
        } );
    }


}
