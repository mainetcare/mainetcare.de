<?php

namespace Tests\Unit;

use App\Factories\SaisonFactory;
use App\Models\Saison;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class SaisonTest extends TestCase {


    /**
     * @test
     */
    public function it_has_a_start_and_an_end() {

        $saison = new Saison();
        $saison->von = '2020-10-01';
        $saison->bis = '2020-11-01';
        $saison->type = 'hs';

        $this->assertEquals(Carbon::class, get_class($saison->von));
        $this->assertEquals(Carbon::class, get_class($saison->bis));

    }

//    /**
//     * @test
//     */
//    public function it_can_be_created_by_globals_of_statamic() {
//        $this->assertEquals(2, app(SaisonFactory::class)->getCachedHauptsaisons()->count());
//    }




}
