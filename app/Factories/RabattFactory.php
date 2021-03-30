<?php


namespace App\Factories;

use App\Models\Rabatt;
use Statamic\Entries\Entry;

/**
 * @method Rabatt initByEntry( Entry $entry )
 * @method Rabatt initBySlug( string $slug )
 * @method Rabatt initById( string $id )
 */
class RabattFactory extends EntryFactory {

    public $class = Rabatt::class;
    protected $collection = 'rabatte';
    protected $model = null;

}
