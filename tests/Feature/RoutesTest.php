<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoutesTest extends TestCase {

    use InteractsWithExceptionHandling;
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
    }


    /**
     * @test
     */
    public function the_homepage_is_up() {
        $response = $this->get( '/' );
        $response->assertStatus( 200 );
    }

    /**
     * @test
     */
    public function it_has_page_urlaubspakete() {
        $response = $this->get( 'urlaubspakete/' );
        $response->assertStatus( 200 );
    }

    /**
     * @test
     */
    public function it_has_page_residenz() {
        $response = $this->get( 'residenz/' );
        $response->assertStatus( 200 );
    }

    /**
     * @test
     */
    public function it_has_page_naturheilpraxis() {
        $response = $this->get( 'naturheilpraxis/' );
        $response->assertStatus( 200 );
    }

    /**
     * @test
     */
    public function it_has_page_erlebniswelten() {
        $response = $this->get( 'erlebniswelten/' );
        $response->assertStatus( 200 );
    }

    /**
     * @test
     */
    public function it_has_page_veranstaltungen() {
        $response = $this->get( 'veranstaltungen/' );
        $response->assertStatus( 200 );
    }

    /**
     * @test
     */
    public function it_has_detailed_page_for_appartement() {

        $response = $this->get( 'appartements/appartement-1-goldfever' );
        $response->assertStatus( 200 );

    }

    /**
     * @test
     */
    public function it_has_page_for_erlebniswelten() {
        $response = $this->get( 'erlebniswelten' );
        $response->assertStatus( 200 );

    }

    public function it_shows_list_of_appartements() {

    }


}
