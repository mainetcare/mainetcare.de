<?php

namespace Tests\Unit;

use App\Factories\AngebotFactory;
use App\Models\Angebot;
use App\Services\AngebotPriceCalculator;
use App\Services\BulkPrices;
use Tests\CreatesModels;
use Tests\TestCase;

class AngebotPriceCalculatorTest extends TestCase {

    public $angebot = null;

    use CreatesModels;

    public function setUp(): void {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->angebot = $this->createTestangebot();
    }

    /**
     * @test
     * @dataProvider calcProvider
     *
     * @param $mengeneinheit
     * @param $amount
     * @param $multiplier
     * @param $expected
     */
    public function it_calculates_the_price_for_angebot( string $mengeneinheit, int $amount, int $multiplier, float $expected ) {
        $bulkprices = new BulkPrices($this->angebot, $mengeneinheit);
        $calc = new AngebotPriceCalculator($bulkprices, $amount, $multiplier);
        $this->assertEquals($expected, $calc->getTotal());
    }

    /**
     * @return array[]
     */
    public function calcProvider() {
        return [
            [ Angebot::ME_TAGE, 1, 1 , 15 ],
            [ Angebot::ME_TAGE, 15, 2 , 300 ],
            [ Angebot::ME_PAKET, 1, 1 , 100 ],
            [ Angebot::ME_PAKET, 10, 1 , 750 ],
        ];
    }




}
