<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SperrzeitenRoutesTest extends TestCase {

    use InteractsWithExceptionHandling;
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
    }

    /**
     * @test
     */
    public function only_logged_in_users_can_access_sperrzeiten() {
        $this->withoutExceptionHandling();
        $response = $this->get( '/sperrzeiten' );
        $response->assertStatus( 200 );
        $response->assertSeeText( 'Sperrzeiten' );
    }


}
