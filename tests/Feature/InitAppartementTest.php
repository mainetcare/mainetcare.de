<?php

namespace Tests\Feature;

use App\Http\Livewire\InitAppartement;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class InitAppartementTest extends TestCase {

    use InteractsWithExceptionHandling;
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
    }

    /**
     * @test
     */
    function gaeste_are_required() {

        $input = [
            'gaeste'   => '',
            'checkin'  => '10.10.2021',
            'checkout' => '15.10.2021',
        ];

        Livewire::test( InitAppartement::class )
                ->set( 'gaeste', '' )
                ->call( 'submit', $input )
                ->assertHasErrors( [ 'gaeste' => 'required' ] );
    }

    function it_can_initialize_the_session() {
        Livewire::test( InitAppartement::class )
                ->set( 'init', true )
                ->call( 'mount')
                ->assertHasErrors( [ 'gaeste' => 'required' ] );
    }

    /**
     * @test
     */
    function gaeste_number_and_greater_zero() {

        $input = [
            'gaeste'   => '0',
            'checkin'  => '10.10.2021',
            'checkout' => '15.10.2021',
        ];

        Livewire::test( InitAppartement::class )
                ->set( 'gaeste', '' )
                ->call( 'submit', $input )
                ->assertHasErrors( [ 'gaeste' ] );
    }

    /**
     * @test
     */
    function checkin_must_be_after_2021_05_28() {
        $input = [
            'gaeste'   => '1',
            'checkin'  => '1.5.2020',
            'checkout' => '29.5.2020',
        ];

        Livewire::test( InitAppartement::class )
                ->set( 'gaeste', 2 )
                ->call( 'submit', $input )
                ->assertHasErrors( [ 'checkin' ] );
    }


    /**
     * @test
     */
    function checkin_checkout_must_be_dates() {

        $input = [
            'gaeste'   => '0',
            'checkin'  => 'foo',
            'checkout' => 'bar',
        ];

        Livewire::test( InitAppartement::class )
                ->call( 'submit', $input )
                ->assertHasErrors( [ 'checkin' ] );

        $input = [
            'gaeste'   => '2',
            'checkin'  => '10.10.2021',
            'checkout' => '15.10.2021',
        ];

        Livewire::test( InitAppartement::class )
                ->call( 'submit', $input )
                ->assertHasNoErrors();


    }

    /**
     * @test
     */
    function checkin_must_be_before_checkout() {

        $input = [
            'gaeste'   => '2',
            'checkin'  => '10.10.2020',
            'checkout' => '08.10.2020',
        ];

        Livewire::test( InitAppartement::class )
                ->call( 'submit', $input )
                ->assertHasErrors( [ 'checkout' ] );


    }


}
