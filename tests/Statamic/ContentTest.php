<?php

namespace Tests\Statamic;

use Arr;
use Statamic\Assets\Asset;
use Statamic\Facades\Collection;
use Statamic\Facades\Entry;
use Statamic\Facades\Fieldset;
use Statamic\Facades\GlobalSet;
use Statamic\Facades\Nav;
use Statamic\Facades\Structure;
use Statamic\Facades\Taxonomy;
use Statamic\Facades\Term;
use Statamic\Fields\Field;
use Statamic\Fields\Value;
use Statamic\Stache\Query\Builder;
use Statamic\Stache\Query\EntryQueryBuilder;
use Statamic\Structures\CollectionStructure;
use Statamic\Structures\Tree;
use Statamic\Tags\Collection\Entries;
use Statamic\Taxonomies\TermCollection;
use Tests\TestCase;

/**
 *
 * Diese Testklasse dient nicht wirklich dem Testen, sondern für mich als Test, wie die Content-Schnittstellen funktionieren.
 * Class ContentTest
 * @package Tests\Statamic
 */
class ContentTest extends TestCase {

    /**
     * @var \Statamic\Entries\Entry
     */
    protected $entry = null;

    /**
     * @test
     */
    public function an_entry_can_fetch_an_asset() {
        $this->entry = Entry::findBySlug( 'appartement-1-goldfever', 'appartements' );
        $entry       = $this->entry;
        /**
         * @var $image Asset
         */
        $image = $entry->augmentedValue( 'col_img' )->value();
//        dd(data_get($image->meta(), 'data.alt'));
//        dd(Arr::get($image->meta(), 'alt', ''));
        $this->assertTrue( true );
    }

    /**
     * @test
     */
    public function get_data_of_repeater_field() {
        /**
         * @var $entry \Statamic\Entries\Entry
         */
        $this->entry = Entry::findBySlug( 'gym-und-sauna', 'angebote' );
        $repeater    = Arr::pluck( $this->entry->get( 'preisliste' ), 'preis' );
//        dd($repeater);
        $this->assertTrue( true );
    }


    /**
     * @test
     */
    public function it_gets_the_fitness_articles_in_correct_order() {

        /**
         * @var $terms TermCollection
         */
        // $bereich = Term::whereTaxonomy('angebotsbereich')->first()->slug(); > TermCollecion > LocalizedTerm
//        $terms = Term::whereTaxonomy('angebotsbereich'); // Erlebniswelt Fitness
        // dd($terms);

        $bereich = 'erlebniswelt-fitness-und-sauna';

        $entries = Entry::query()
                        ->where( 'collection', 'angebote' )
                        ->whereTaxonomy( 'angebotsbereich::' . $bereich ) // 1
                        ->whereTaxonomyIn( [ 'angebotsgruppe::sauna', 'angebotsgruppe::sportkurse' ] ) // multiple
                        ->orderBy( 'rf' )->get();
        $this->assertEquals( 'Gym und Sauna', $entries->first()->title );
    }

    /**
     * @test
     */
    public function it_can_get_title_of_taxonomy() {
        $tax = Term::findBySlug( 'pferdepension', 'angebotsgruppe' );
        $this->assertEquals( 'Pferdepension', $tax->get( 'title' ) );
    }

    /**
     * @test
     */
    public function it_can_get_all_terms_of_taxonomy() {
        $terms =
            Term::query()
                ->where( 'taxonomy', 'angebotsgruppe' )
                ->where( 'angebotsbereich', 'erlebniswelt-pferd' )
                ->get()
                ->map( function ( $term ) {
                    return $term->slug();
            } );
        $this->assertCount(2, $terms);
    }

    /**
     * @test
     */
    public function get_options_of_fieldset_select() {

        /**
         * @var $fieldset \Statamic\Fields\Fieldset
         */
        $fieldset = Fieldset::find( 'staffelpreise' );

        /**
         * @var $field Field
         */
        $field = $fieldset->field( 'unit' );

//        dd(collect($field->get('options'))->get('Tag'));

        $this->assertTrue( true );
    }

    /**
     * @test
     */
    public function it_can_get_and_set_global_variables() {

        /**
         * @var $companyset \Statamic\Globals\GlobalSet
         */
        $companyset = GlobalSet::findByHandle( 'company' );
        /**
         * @var $variables \Statamic\Globals\Variables
         */
        $variables = $companyset->inCurrentSite();
        // GlobalSet::findByHandle('company')->inCurrentSite()->set('foo', 'Testing12')->save();
        GlobalSet::findByHandle( 'company' )->inCurrentSite()->set( 'foo', 'Testing12' );
        // $variables->save();
        $this->assertEquals( 'Testing12', GlobalSet::findByHandle( 'company' )->inCurrentSite()->get( 'foo' ) );

    }

    /**
     *
     */
    public function it_gets_the_navi() {

        /**
         * @var $nav \Statamic\Structures\Nav
         */
        $nav = Nav::findByHandle( 'footer_ueber_uns' );
        /**
         * @var $tree Tree
         */
        $tree = $nav->trees()->first();

    }

    /**
     * @test
     */
    public function it_can_get_the_augmented_value_of_veranstaltung() {
        $entry = Entry::findBySlug( 'trailritt', 'veranstaltungen' );
        $value = $entry->augmentedValue( 'teaser' )->value();
        $this->assertTrue( true );
    }

    /**
     * @test
     */
    public function it_can_get_the_url_of_an_entry() {
        /**
         * @var $entry \Statamic\Entries\Entry
         */
        $entry = Entry::findBySlug( 'trailritt', 'veranstaltungen' );
        $url   = $entry->url();
        $this->assertEquals( '/veranstaltung/trailritt', $url );
    }

    /**
     * @test
     */
    public function it_gets_the_appartement_collection() {
        $entries = Entry::query()
                        ->where( 'collection', 'appartements' )
                        ->orderBy( 'rf' )
                        ->paginate( 4 );
        $this->assertTrue( true );
    }


    /**
     * @test
     */
    public function it_can_check_if_bard_is_empty() {
        $this->entry = Entry::findBySlug( 'appartement-21-testappartement', 'appartements' );
        $entry       = $this->entry;
        /**
         * @var $content Value
         */
        $content = $entry->augmentedValue( 'content' );
        $this->assertEquals( 0, count( $content->value() ) );
    }

    /**
     * @test
     */
    public function it_can_get_pakete_with_individual_order() {

        /**
         * @var $structure \Statamic\Entries\Collection
         */

        /**
         * @var $query EntryQueryBuilder
         */
        $query   = Entry::query();
        $entries = $query->where( 'collection', 'pakete' )->orderBy( 'order' )->get()->map( function ( $item ) {
            return $item->slug();
        } );
        $this->assertEquals( [ 'track-n-trail', 'pferd-und-fitness' ], [ $entries->get( 0 ), $entries->get( 1 ) ] );

    }


}
