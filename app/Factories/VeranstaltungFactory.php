<?php


namespace App\Factories;


use App\Models\Veranstaltung;
use Statamic\Entries\Entry;

/**
 * @method Veranstaltung initByEntry( Entry $entry )
 * @method Veranstaltung initBySlug( string $slug )
 * @method Veranstaltung initById( string $id )
 */
class VeranstaltungFactory extends EntryFactory  {

    public $class = Veranstaltung::class;
    protected $collection = 'veranstaltungen';
    protected $model = null;

}
