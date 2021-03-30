<?php


namespace App\Factories;


use App\Models\EntryModel;
use Statamic\Entries\Entry;

abstract class EntryFactory {

    protected $class;
    protected $collection;


    /**
     * @return EntryModel
     */
    private function getInstance() {
        $class = $this->class;

        return new $class();
    }

    /**
     * @param Entry $entry
     *
     * @return EntryModel|null
     */
    public function initByEntry( Entry $entry ) {
        if ( ! $entry->id() ) {
            return null;
        }
        $model         = $this->getInstance();
        $model->id     = $entry->id();
        $model->slug   = $entry->slug();
        $model->entry  = $entry;
        $model->exists = true;

        return $model;
    }


    /**
     * @param $id
     *
     * @return EntryModel|null
     */
    public function initById( $id ) {
        /**
         * @var $entry Entry
         */
        $entry = \Statamic\Facades\Entry::find( $id );
        if ( ! $entry ) {
            return null;
        }

        return $this->initByEntry( $entry );
    }

    /**
     * @param string $slug
     *
     * @return EntryModel|null
     */
    public function initBySlug( string $slug ) {
        /**
         * @var $entry Entry
         */
        $entry = \Statamic\Facades\Entry::findBySlug( $slug, $this->collection );
        if ( ! $entry ) {
            return null;
        }

        return $this->initByEntry( $entry );
    }

    /**
     * @return mixed
     */
    public function getCollection() {
        return $this->collection;
    }

}
