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

class CartItemTest extends TestCase {

    use RefreshDatabase, CreatesModels, InteractsWithDatabase;


    /**
     * @test
     */
    public function an_item_can_have_children() {
        $cart  = Cart::create();

        $parent = $cart->items()->create( [
            'model_id' => 1,
            'cat'      => 'test',
            'title'    => 'Parent',
        ] );

        $child = $cart->items()->create( [
            'model_id'  => 1,
            'parent_id' => $parent->id,
            'cat'       => 'test',
            'title'     => 'Child',
        ] );

        $this->assertEquals( 'Child', $parent->children()->first()->title );

    }

    /**
     * @test
     */
    public function if_item_is_deleted_its_children_are_deleted() {

        $cart  = Cart::create();

        $parent = $cart->items()->create( [
            'model_id' => 1,
            'cat'      => 'test',
            'title'    => 'Parent',
        ] );

        $child = $cart->items()->create( [
            'model_id'  => 1,
            'parent_id' => $parent->id,
            'cat'       => 'test',
            'title'     => 'Child',
        ] );

        $parent->delete();

        $this->assertDatabaseCount('cart_items', 0);

    }


}
