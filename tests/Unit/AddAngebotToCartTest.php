<?php

namespace Tests\Unit;

use App\Jobs\ProcessAddAngebotToCart;
use App\Models\Angebot;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesModels;
use Tests\TestCase;

class AddAngebotToCartTest extends TestCase {

    use CreatesModels, RefreshDatabase;

    /**
     * @var Angebot|null
     */
    public $model = null;


    public function setUp(): void {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->model = $this->createTestangebot();
    }

    /**
     * @test
     */
    public function it_can_add_the_angebot_with_given_amount_and_multiplier_with_correct_label() {
        $angebot    = $this->model;
        $cart       = Cart::create();
        $unit       = 'tag';
        $amount     = 7;
        $multiplier = 2;
        app( ProcessAddAngebotToCart::class, [
            'arrSelection' => [
                'angebot'    => $angebot,
                'cart'       => $cart,
                'unit'       => $unit,
                'amount'     => $amount,
                'multiplier' => $multiplier
            ]
        ] )->handle();
        $this->assertEquals( '7 Tage für 2 Personen', $cart->items()->first()->content );
    }

    /**
     * @test
     */
    public function it_can_add_the_angebot_with_a_variant() {
        $angebot    = $this->model;
        $cart       = Cart::create();
        $unit       = 'tag';
        $amount     = 1;
        $multiplier = 1;
        app( ProcessAddAngebotToCart::class, [
            'arrSelection' => [
                'angebot'    => $angebot,
                'cart'       => $cart,
                'unit'       => $unit,
                'variant'    => 'Variante1',
                'amount'     => $amount,
                'multiplier' => $multiplier
            ]
        ] )->handle();
        $this->assertEquals( 10, $cart->items()->first()->total );
    }

    /**
     * @test
     */
    public function if_the_unit_is_invalid_it_uses_the_default_unit() {
        $angebot    = $this->model;
        $cart       = Cart::create();
        $unit       = 'some_invalid_unit';
        $amount     = 7;
        $multiplier = 2;
        app( ProcessAddAngebotToCart::class, [
            'arrSelection' => [
                'angebot'    => $angebot,
                'cart'       => $cart,
                'unit'       => $unit,
                'amount'     => $amount,
                'multiplier' => $multiplier
            ]
        ] )->handle();
        $this->assertEquals( '7 Tage für 2 Personen', $cart->items()->first()->content );
    }


}