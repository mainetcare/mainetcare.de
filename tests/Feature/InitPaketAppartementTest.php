<?php

namespace Tests\Feature;

use App\Http\Livewire\InitAppartement;
use App\Http\Livewire\InitPaket;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class InitPaketAppartementTest extends TestCase {

    use InteractsWithExceptionHandling;
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
    }

    /**
     * @test
     */
    function it_shows_the_ui_for_selecting_package() {
        $this->get( '/urlaubspakete/track-n-trail' )
             ->assertSuccessful();
    }

    /**
     * @test
     */
    function it_can_initialize_the_package_lsit() {
        $input = [
            'teilnehmer' => '1',
            'checkin'    => '1.6.2021',
            'checkout'   => '7.6.2021',
        ];

        Livewire::test( InitPaket::class )
                ->set( 'slug', 'testpaket' )
                ->call( 'submit', $input )
                ->assertHasNoErrors();
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

        Livewire::test( InitPaket::class )
                ->set( 'slug', 'testpaket' )
                ->call( 'submit', $input )
                ->assertHasErrors( [ 'checkin' ] );
    }


    /**
     * @test
     */
    function teilnehmer_are_required() {

        $input = [
            'teilnehmer' => '',
            'checkin'    => '10.10.2020',
            'checkout'   => '15.10.2020',
        ];

        Livewire::test( InitPaket::class )
                ->set( 'slug', 'testpaket' )
                ->set( 'teilnehmer', '' )
                ->call( 'submit', $input )
                ->assertHasErrors( [ 'teilnehmer' => 'required' ] );
    }

    /**
     * @test
     */
    function teilnehmer_at_least_one_person() {

        $input = [
            'teilnehmer' => 0,
            'checkin'    => '10.10.2020',
            'checkout'   => '15.10.2020',
        ];

        Livewire::test( InitPaket::class )
                ->set( 'slug', 'testpaket' )
                ->set( 'teilnehmer', '' )
                ->call( 'submit', $input )
                ->assertHasErrors( [ 'teilnehmer' => 'between' ] );
    }

    /**
     * @test
     */
    function gaeste_are_required() {

        $input = [
            'gaeste'   => '',
            'checkin'  => '10.10.2020',
            'checkout' => '15.10.2020',
        ];

        Livewire::test( InitPaket::class )
                ->set( 'slug', 'testpaket' )
                ->set( 'gaeste', '' )
                ->call( 'submit', $input )
                ->assertHasErrors( [ 'gaeste' => 'required' ] );
    }

    /**
     * @test
     */
    function gaeste_can_be_zero() {

        $input = [
            'gaeste'   => 0,
            'checkin'  => '10.10.2020',
            'checkout' => '15.10.2020',
        ];

        Livewire::test( InitPaket::class )
                ->set( 'slug', 'testpaket' )
                ->set( 'gaeste', '' )
                ->call( 'submit', $input )
                ->assertHasNoErrors( [ 'gaeste' ] );
    }


    /**
     * @test
     */
    function it_checks_the_max_number_of_bookable_persons() {

        $input = [
            'gaeste'     => 2,
            'teilnehmer' => 2,
            'checkin'    => '10.10.2021',
            'checkout'   => '15.10.2021',
        ];

        // Testpaket max is 3

        $test = Livewire::test( InitPaket::class )
                        ->set( 'slug', 'testpaket' )
                        ->set( 'gaeste', $input['gaeste'] )
                        ->set( 'teilnehmer', $input['teilnehmer'] )
                        ->call( 'submit', $input );
        $test->assertHasErrors( [ 'bookable_persons' ] );
    }


    /**
     * @test
     */
    function checkin_must_be_date() {

        $input = [
            'gaeste'   => '0',
            'checkin'  => 'foo',
            'checkout' => 'bar',
        ];

        Livewire::test( InitPaket::class )
                ->set( 'slug', 'testpaket' )
                ->call( 'submit', $input )
                ->assertHasErrors( [ 'checkin' ] );


    }


}
