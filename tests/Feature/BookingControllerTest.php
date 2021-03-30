<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingControllerTest extends TestCase {

    use InteractsWithExceptionHandling;
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
    }


    /**
     * @test
     */
    public function it_can_load_the_list_for_appartements() {

        $response = $this->get(route('appartement-select.index'));
        $response->assertStatus(302);

    }

    /**
     * @test
     */
    public function the_route_for_pferdepension_redirects_without_cart() {
        $response = $this->get(route('pferd-select.index'));
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function the_route_for_fitness_redirects_without_cart() {
        $response = $this->get(route('fitness-select.index'));
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function the_route_for_wellness_redirects_without_cart() {
        // $this->withoutExceptionHandling();
        $response = $this->get(route('wellness-select.index'));
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function the_route_for_kunst_redirects_without_cart() {
        // $this->withoutExceptionHandling();
        $response = $this->get(route('kunst-select.index'));
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function the_route_for_funpark_redirects_without_cart() {
//         $this->withoutExceptionHandling();
        $response = $this->get(route('funpark-select.index'));
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function the_route_for_kontakt_redirects_without_cart() {
//         $this->withoutExceptionHandling();
        $response = $this->get(route('kontaktdaten.index'));
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function the_route_for_zusammenfassung_redirects_without_cart() {
//         $this->withoutExceptionHandling();
        $response = $this->get(route('summary.index'));
        $response->assertStatus(302);
    }



}
