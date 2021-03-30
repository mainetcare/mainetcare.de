<?php


namespace App\Models;


use App\Services\BulkPrices;

trait HasBulkPricesTrait {

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getBulkPrices() {
        return collect( $this->entry->get( 'preisliste' ) );
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getUnits() {
        return $this->getBulkPrices()->pluck('unit');
    }

    public function hasUnit($unit) {
        return in_array($unit, $this->getUnits()->toArray());
    }

    public function getPricesByUnit( string $unit ) {
        return app(BulkPrices::class, ['model' => $this, 'unit' => $unit])->getPrices();
    }




}
