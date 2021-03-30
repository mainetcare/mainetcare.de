<?php


namespace App\Factories;


use App\Models\Angebot;
use Statamic\Entries\Entry;

/**
 * @method Angebot initByEntry( Entry $entry )
 * @method Angebot initBySlug( string $slug )
 * @method Angebot initById( string $id )
 */
class AngebotFactory extends EntryFactory  {

    public $class = Angebot::class;
    protected $collection = 'angebote';
    protected $model = null;

}
