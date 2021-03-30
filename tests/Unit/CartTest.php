<?php

namespace Tests\Unit;

use App\Http\Livewire\AddPaketAppartementToCart;
use App\Jobs\ProcessAddPaketAppartementToCart;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Contact;
use App\Models\Pferdepension;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesModels;
use Tests\TestCase;
use function Stringy\create;

class CartTest extends TestCase {

    use RefreshDatabase, CreatesModels, InteractsWithDatabase;

    /**
     * @test
     */
    public function it_saves_checkin_and_checkout_as_carbon() {
        $cart           = new Cart();
        $cart->checkin  = '01.01.2015';
        $cart->checkout = '01.04.2019';
        $this->assertEquals( 2015, $cart->checkin->year );
        $this->assertEquals( 4, $cart->checkout->month );
    }

    /**
     * @test
     */
    public function it_presents_the_von_bis_range_in_pretty() {
        $cart           = new Cart();
        $cart->checkin  = '10.11.2020';
        $cart->checkout = '15.11.2020';
        $this->assertEquals( 'Di, 10.11.2020 – So, 15.11.2020', $cart->present()->vonbis() );
    }

    /**
     * @test
     */
    public function it_has_items() {
        $cart = Cart::create();
        $cart->items()->create( [
            'cat'       => 'Pferdepensionen',
            'title'     => 'Nice Pension with straw',
            'class'     => Pferdepension::class,
            'model_id'  => null,
            'amount'    => 3,
            'editroute' => 'https://some-edit-route/',
            'total'     => 200,
        ] );
        $this->assertEquals( 1, $cart->items()->count() );

        // Delete Cascade:
        $cart->delete();
        $this->assertDatabaseCount( 'cart_items', 0 );

    }

    /**
     * @test
     */
    public function it_can_load_added_appartements() {
        $cart = Cart::create();
        $cart->addAppartement( $this->createGoldfever(), 1, 200 );
        $app = $cart->appartements()->first();
        $this->assertEquals( 'Goldfever', $app->entry->get( 'nickname' ) );
    }


    /**
     * @test
     */
    public function it_can_load_added_angebote() {
        $model = $this->createTestangebot();
        $cart  = Cart::create();
        $cart->updateOrCreateItem( [
            'model'   => $model,
            'amount'  => 10,
            'total'   => 10,
            'unit'    => 'tag',
            'content' => ''
        ] );
        $added_item = $cart->angebote( 'erlebniswelt-fitness-und-sauna' )->first();
        $this->assertEquals( $model->title, $added_item->title );
    }

    /**
     * @test
     */
    public function an_item_is_unique_per_model_id_and_unit() {
        $model   = $this->createTestangebot();
        $cart    = Cart::create();
        $arrData = [
            'model'   => $model,
            'unit'    => 'tag',
            'variant' => 'tag',
            'amount'  => 10,
            'total'   => 100,
            'content' => '',
        ];
        $cart->updateOrCreateItem( $arrData );
        $arrData['amount'] = 11;
        $cart->updateOrCreateItem( $arrData );
        $this->assertEquals( 1, $cart->items()->count() );
        $arrData['unit'] = 'paket';
        $cart->updateOrCreateItem( $arrData );
        $this->assertEquals( 2, $cart->items()->count() );
    }


    /**
     * @test
     */
    public function it_calculates_the_count_of_nights() {
        $cart           = new Cart();
        $cart->checkin  = '5.9.2020';
        $cart->checkout = '12.9.2020';
        $cart->nights   = null;
        $this->assertEquals( 7, $cart->nights );
    }

    /**
     * @test
     */
    public function it_calculates_the_total_price() {
        $cart = new Cart();
        $cart->save();
        $cart->items()->create( [
            'cat'   => 'A',
            'title' => 'A',
            'total' => 1.1
        ] );
        $cart->items()->create( [
            'cat'   => 'A',
            'title' => 'B',
            'total' => 1.1
        ] );
        $cart->items()->create( [
            'cat'   => 'A',
            'title' => 'C',
            'total' => 1.1
        ] );
        $this->assertEquals( 3.3, $cart->getSumTotal() );
    }

    /**
     * @test
     */
    public function it_has_data_of_contact_form() {
        $cart = Cart::create( [] );
        $data = $this->getValidContactData();
        $cart->addContactData( $data );
        $this->assertDatabaseHas( 'contacts', $data );
    }

    /**
     * @test
     */
    public function it_only_updates_model_fields_from_user_input() {
        $cart  = Cart::create( [] );
        $valid = $this->getValidContactData();
        $data  = array_merge( $valid, [ 'agb' => 'agb' ] );
        $cart->addContactData( $data );
        $this->assertDatabaseHas( 'contacts', $valid );
    }


    protected function getValidContactData() {
        return [
            'vorname'  => 'Some Vorname',
            'name'     => 'Some name',
            'email'    => 'info@example.com',
            'telefon'  => '1234567',
            'strasse'  => 'Some Street',
            'plz'      => '666',
            'ort'      => 'Some Ort',
            'hinweise' => 'Lorem Ipsum usw'
        ];
    }

    /**
     * @test
     */
    public function a_cart_item_has_an_extra_data_field_for_calculations() {
        $data = [
            'x' => 1,
            'y' => 2,
        ];
        $cart = Cart::create( [] );
        $cart->items()->create( [
            'cat'   => 'A',
            'title' => 'C',
            'data'  => $data
        ] );
        $this->assertEquals( $data, CartItem::find( 1 )->data );
    }

    /**
     * @test
     */
    public function it_can_check_if_the_cart_is_empty() {
        $cart = Cart::create( [] );

        $this->assertEquals( true, $cart->isEmpty() );

        $cart = Cart::create( [
            'checkin'  => now(),
            'checkout' => now(),
        ] );

        $this->assertEquals( false, $cart->isEmpty() );

        $cart->items()->create( [
            'cat'   => 'A',
            'title' => 'C'
        ] );

        $this->assertEquals( false, $cart->isEmpty() );

    }

    /**
     * @test
     */
    public function it_can_check_if_a_cart_was_sent() {
        $cart = Cart::create( [] );
        $this->assertEquals( false, $cart->isSent() );
        $cart->setSent();
        $this->assertEquals( true, $cart->isSent() );

    }


}
