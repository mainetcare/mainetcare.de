<?php

namespace Tests\Unit;

use App\Exceptions\BookingException;
use App\Factories\AppartementFactory;
use App\Models\Appartement;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Statamic\Taxonomies\LocalizedTerm;
use Tests\CreatesModels;
use Tests\TestCase;
use Tests\DBSwitcher;

class AppartementTest extends TestCase {

    use DBSwitcher, CreatesModels, DatabaseMigrations, InteractsWithDatabase;

    /**
     * @var Appartement|null
     */
    public $goldfever = null;
    /**
     * @var null | Appartement
     */
    public $hickstead = null;

    public function setUp(): void {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->goldfever = app( AppartementFactory::class )->initBySlug( 'appartement-1-goldfever' );
        $this->hickstead = app( AppartementFactory::class )->initBySlug( 'appartement-16-hickstead' );
    }

    /**
     * @test
     */
    public function it_can_be_initialized_by_id() {
        $app = app( AppartementFactory::class )->initById( 'd1a48a96-1475-4e7e-a970-5c51e6891b4a' );
        $this->assertEquals( 'Goldfever', $app->entry->get( 'nickname' ) );
    }

    /**
     * @test
     */
    public function the_corresponding_entry_must_exist() {
        $app = app( AppartementFactory::class )->initByEntry( new \Statamic\Entries\Entry() );
        $this->assertEquals( null, $app );
    }

    /**
     * @test
     */
    public function it_gets_the_cart_category() {
        $app = $this->createGoldfever();
        $this->assertEquals( 'appartements', $app->cart_category );
    }

    /**
     * @test
     */
    public function it_gets_the_appartementklasse() {
        $app = $this->createTestappartement();
        $this->assertEquals( 'klasse-test', $app->appartementklasse );
    }


    /**
     * @test
     */
    function an_appartement_may_be_not_available() {
        // Given an Appartement
        $appartement = $this->goldfever;

        // Given a daterange
        $start = new Carbon( '2020-08-01' );
        $end   = new Carbon( '2020-08-10' );

        // Appartment ist available
        $this->assertTrue( $appartement->availableIn( $start, $end ) );

        // if we block a period that intersects:

        $appartement->block( new Carbon( '2020-07-25' ), new Carbon( '2020-08-03' ), 'some_ref_id' );

        // it is not available anymore:
        $this->assertFalse( $appartement->availableIn( $start, $end ) );

    }

    /**
     * @test
     */
    function an_appartment_has_prices_depending_on_its_klasse() {
        $appartement = $this->createTestappartement();
        // Klasse 4:
        $prices = $appartement->getPrices();
        $this->assertEquals( collect( [
            'hs' => 200.00,
            'ns' => 100.00,
        ] ), $prices );
    }

    /**
     * @test
     * @throws \App\Exceptions\BookingException
     */
    function if_no_prices_are_available_it_throws_booking_error() {

        $appartement = $this->hickstead;
        $this->expectException( BookingException::class );
        $appartement->entry->set( 'appartementklasse', 'something-off' );
        $appartement->getPrices();
        $this->assertTrue( true );
    }

    /**
     * @test
     */
    function it_can_check_if_its_available_by_number_of_guests() {

        $appartement = $this->hickstead;
        $appartement->setAvailableByGuests( 1 );
        $this->assertEquals( Appartement::STATUS_NOT_AVAILABLE, $appartement->entry->app_status );
        $this->assertEquals( Appartement::MESSAGE_NOT_ENOUGH_GUESTS, $appartement->entry->app_statusmessage );

        $appartement->setAvailableByGuests( 2 ); // Now its ok
        $this->assertEquals( '', $appartement->entry->app_status );
    }

    /**
     * @test
     */
    function it_can_load_its_appartementklasse() {
        $appartement = $this->createTestappartement();
        /**
         * @var $tax LocalizedTerm
         */
        $tax = $appartement->klasse();
        $this->assertEquals( 'klasse-test', $tax->slug() );
    }

    /**
     * @test
     */
    function it_can_check_if_it_is_already_in_the_cart() {
        $app  = $this->createGoldfever();
        $cart = $this->createCartForUrlaubInAppartementGoldfever(); // just laziness ;-)
        $this->assertEquals( true, $app->inCart( $cart ) );
        $app = $this->createAppartementMeteor();
        $this->assertEquals( false, $app->inCart( $cart ) );
    }


}
