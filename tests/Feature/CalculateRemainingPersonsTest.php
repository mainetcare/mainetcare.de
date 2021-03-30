<?php

namespace Tests\Feature;

use App\Jobs\ProcessAddAppartementToCart;
use App\Jobs\ProcessAddPaketAppartementToCart;
use App\Jobs\ProcessInitBookingAppartements;
use App\Models\Cart;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesModels;
use Tests\TestCase;

class CalculateRemainingPersonsTest extends TestCase {

    use InteractsWithExceptionHandling;
    use RefreshDatabase;
    use CreatesModels;
    use InteractsWithSession;

    public function setUp(): void {
        parent::setUp();
    }

    /**
     * @test
     */
    public function it_calculates_how_many_teilnehmer_and_begleitpersonen_needs_allocated_to_appartements() {

        // Given a Cart with 5 Teilnehmer and 4 Begleitpersonen

        $cart = Cart::create( [
            'teilnehmer' => 5,
            'gaeste'     => 4,
            'checkin'    => now(),
            'checkout'   => now(),
        ] );

        // When I allocate an appartement for 1 Teilnehmer and 1 Begleitperson

        app( ProcessAddPaketAppartementToCart::class, [
            'arrSelection' => [
                'cart'          => $cart,
                'paket'         => $this->createTestpaket(),
                'appartement'   => $this->createGoldfever(),
                'teilnehmer'    => 1,
                'begleitperson' => 1,
            ]
        ] )->handle();

        // And another one:

        app( ProcessAddPaketAppartementToCart::class, [
            'arrSelection' => [
                'cart'          => $cart,
                'paket'         => $this->createTestpaket(),
                'appartement'   => $this->createAppartementMeteor(),
                'teilnehmer'    => 1,
                'begleitperson' => 1,
            ]
        ] )->handle();

        // There are 3 Teilnehmer left, 2 Begleitpersonen and 5 total

        $this->assertEquals( 5, $cart->remaining()->get( 'all' ) );
        $this->assertEquals( 3, $cart->remaining()->get( 'teilnehmer' ) );
        $this->assertEquals( 2, $cart->remaining()->get( 'begleitperson' ) );

    }

    /**
     * @test
     */
    public function it_calculates_how_many_guests_needs_allocated_to_appartements() {
        app( ProcessInitBookingAppartements::class, [
            'arrSelection' => [
                'checkin'  => '9.10.2020',
                'checkout' => '11.10.2020',
                'gaeste'   => 2
            ]
        ] )->handle();

        app( ProcessAddAppartementToCart::class, [
            'arrSelection' => [
                'cart'          => cart(),
                'appartement'   => $this->createGoldfever(),
                'gaeste' => 1,
            ]
        ] )->handle();


        $this->assertEquals( 1, cart()->remaining()->get( 'all' ) );
    }


}
