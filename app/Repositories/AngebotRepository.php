<?php


namespace App\Repositories;

use App\Factories\AngebotFactory;
use App\Models\Angebot;
use App\Models\AngebotBereich;
use App\Models\AngebotGruppe;
use Statamic\Facades\Entry;

class AngebotRepository {

    public function __construct() {

    }

    /**
     * @param $bereich
     * @param $gruppe
     *
     * @return \Statamic\Stache\Query\EntryQueryBuilder
     */
    protected function query( $bereich, $gruppe = null ) {
        $query = Entry::query()
                      ->where('published', true)
                      ->where( 'collection', app( AngebotFactory::class )->getCollection() )
                      ->whereTaxonomy( AngebotBereich::KEY_TAX . '::' . $bereich );
        if ( $gruppe ) {
            if ( ! is_array( $gruppe ) ) {
                $gruppe = [ $gruppe ];
            }
            $gruppe = collect( $gruppe )->map( function ( $item ) {
                return AngebotGruppe::KEY_TAX . '::' . $item;
            } )->toArray();
            $query->whereTaxonomyIn( $gruppe );
        }

        $query->orderBy( 'rf' )
              ->orderBy( 'title' );

        return $query;
    }

    public function getEntries( $bereich, $gruppe = null ) {
        return $this->query( $bereich, $gruppe )->get();
    }

    /**
     * @param $bereich
     * @param null $gruppe
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAngebote( $bereich, $gruppe = null ) {
        return $this->query( $bereich, $gruppe )->get()->map( function ( $item ) {
            return app( AngebotFactory::class )->initByEntry( $item );
        } );
    }


}
