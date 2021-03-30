<?php

namespace Tests\Unit;

use App\Services\PaketPriceCalculator;
use Tests\CreatesModels;
use Tests\TestCase;

class PaketPricesTest extends TestCase {


    use CreatesModels;

    public function setUp(): void {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    /**
     * @test
     * @dataProvider calcProvider
     */
    public function it_calculates_the_correct_prices( $preisklasse, $is_hauptsaison, $teilnehmer, $gaeste, $expected ) {

        $paket = $this->createTestpaket();

        $price = app( PaketPriceCalculator::class )
            ->input( $paket, $preisklasse, $teilnehmer, $gaeste, $is_hauptsaison )
            ->getTotal();

        $this->assertEquals( $expected, $price );

    }

    /**
     * @test
     */
    public function it_can_display_the_discount_price() {
        $rabatt = $this->createTestRabatt();
        $paket = $this->createTestpaket();
        $calculator = app( PaketPriceCalculator::class )->input( $paket, 'klasse-1' , 1, 1, true );
        $paket->initPricedisplay($calculator, $rabatt);
        $this->assertEquals(595 , $paket->pricedisplay()->getCurrentPrice());
    }



    /**
     * @return array[]
     */
    public function calcProvider() {
        return [
            [ 'klasse-1', true, 1, 1, 700 ],
            [ 'klasse-1', true, 1, 0, 575 ],
            [ 'klasse-1', false, 1, 1, 400 ],
            [ 'klasse-1', false, 1, 0, 345 ],
        ];
    }


}