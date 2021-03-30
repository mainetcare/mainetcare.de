<?php


namespace App\Factories;


use App\Models\Paket;
use Statamic\Entries\Entry;

/**
 * @method Paket initByEntry( Entry $entry )
 * @method Paket initBySlug( string $slug )
 * @method Paket initById( string $id )
 */
class PaketFactory extends EntryFactory  {

    public $class = Paket::class;
    protected $collection = 'pakete';
    protected $model = null;

}
