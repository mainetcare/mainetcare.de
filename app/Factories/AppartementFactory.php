<?php


namespace App\Factories;

use App\Models\Appartement;
use Statamic\Entries\Entry;

/**
 * @method Appartement initByEntry( Entry $entry )
 * @method Appartement initBySlug( string $slug )
 * @method Appartement initById( string $id )
 */
class AppartementFactory extends EntryFactory  {

    public $class = Appartement::class;
    protected $collection = 'appartements';
    protected $model = null;

}
