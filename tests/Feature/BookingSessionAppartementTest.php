<?php

namespace Tests\Feature;

use App\Jobs\ProcessAddAppartementToCart;
use App\Jobs\ProcessAddPaketAppartementToCart;
use App\Services\BookingSessions\BookingSessionAppartement;
use App\Services\BookingSessions\BookingSessionRouter;
use App\Services\BookingSessionValidator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesModels;
use Tests\TestCase;

class BookingSessionAppartementTest extends TestCase {

    use CreatesModels, RefreshDatabase;

    public function setUp(): void {
        parent::setUp(); // TODO: Change the autogenerated stub
        // app(BookingSessionRouter::class)->setActiveSession(app(BookingSessionAppartement::class));
    }

    /**
     * @test
     */
    public function a_cart_is_unique_per_session() {
        $a = new BookingSessionAppartement();
        $b = new BookingSessionAppartement();
        $this->assertEquals( $a->cart()->id, $b->cart()->id );
    }


    /**
     * @test
     */
    public function a_booking_session_has_different_steps() {
        $a = new BookingSessionAppartement();
        $a->incStep();
        $this->assertEquals( 2, $a->step() );
        $a->decStep();
        $this->assertEquals( 1, $a->step() );
        $a->setStep( 3 );
        $this->assertEquals( 3, $a->step() );
    }

    /**
     * @test
     */
    public function each_step_has_a_assigned_route() {
        $a = new BookingSessionAppartement();
        $a->setStepByRoute( route( 'pferd-select.index' ) );
        $this->assertEquals( 4, $a->step() );
    }

    /**
     * @test
     */
    public function it_can_reset_the_session() {
        $a = new BookingSessionAppartement();
        $a->cart()->items()->create( [ 'cat' => 'foo', 'title' => 'bar' ] );
        $a->incStep();

        $a->reset();

        $this->assertEquals( 0, $a->cart()->items()->count() );
        $this->assertEquals( 1, $a->step() );
    }

    /**
     * @test
     */
    public function it_can_validate_if_the_state_in_step2_is_correct() {
        // Given Step 2
        $session = new BookingSessionAppartement();
        $app     = $this->createGoldfever();

        $validate_step = function () use ( &$session ) {
            return app( BookingSessionValidator::class, [ 'session' => $session ] )->validateHasCheckinData();
        };

        $this->assertFalse( $validate_step() );

        $session->cart()->addGaeste( 2 );

        $this->assertFalse( $validate_step() );

        $session->cart()->addBookingPeriod( '1.10.2020', '5.10.2020' );

        $this->assertFalse( $validate_step() );

        app( ProcessAddAppartementToCart::class, [
            'arrSelection' => [
                'appartement' => $app,
                'cart' => $session->cart(),
                'gaeste' => 1,
                'amount' => 1
            ]
        ] )->handle();

        $this->assertTrue( $validate_step() );


    }

    /**
     * @test
     * @dataProvider routesProvider
     */
    public function it_can_get_the_route_of_the_next_step( $act_route, $excpected_next_route ) {
        $session = new BookingSessionAppartement();

        $session->setStepByRoute( route( $act_route ) );
        $this->assertEquals( route( $excpected_next_route ), $session->next() );


    }

    /**
     * @test
     * @dataProvider routesProvider
     */
    public function it_can_get_the_route_of_theprev_step( $expected_prev_route, $current_route ) {
        $session = new BookingSessionAppartement();

        $session->setStepByRoute( route( $current_route ) );
        $this->assertEquals( route( $expected_prev_route ), $session->back() );

    }

    /**
     * @return array[]
     */
    public function routesProvider() {
        return [
            [ 'appartement-select.index', 'fitness-select.index' ],
            [ 'fitness-select.index', 'wellness-select.index' ]
        ];
    }


}