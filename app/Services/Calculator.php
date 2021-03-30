<?php


namespace App\Services;


use App\Models\Rabatt;

interface Calculator {

    public function getUnitPrice();

    public function getTotal();

}
