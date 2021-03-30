<?php

namespace Tests\Unit;

use App\Models\Angebot;
use App\Models\AngebotBereich;
use App\Models\AngebotGruppe;
use App\Repositories\AngebotRepository;
use Statamic\Facades\Entry;
use Statamic\Facades\Taxonomy;
use Statamic\Facades\Term;
use Tests\TestCase;

class AngebotRepositoryTest extends TestCase {


    public function setUp(): void {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    /**
     * @test
     */
    function it_retrieves_a_list_of_angebote() {
        $bereich = AngebotBereich::$bereich_fitness;
        $this->assertEquals( Angebot::class, get_class( app( AngebotRepository::class )->getAngebote( $bereich )->first() ) );
    }

    /**
     * @test
     */
    function it_retrieves_a_list_of_angebote_by_group() {
        $bereich = AngebotBereich::$bereich_fitness;
        $gruppe = AngebotGruppe::$gruppe_sauna;
        $this->assertCount( 1,  app( AngebotRepository::class )->getAngebote( $bereich , $gruppe ) );
    }

}
