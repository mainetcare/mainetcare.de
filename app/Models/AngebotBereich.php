<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AngebotBereich extends Model {

    const KEY_TAX = 'angebotsbereich';

    public static $bereich_pferd = 'erlebniswelt-pferd';
    public static $bereich_fitness = 'erlebniswelt-fitness-und-sauna';
    public static $bereich_wellness = 'erlebniswelt-wellness';
    public static $bereich_kunst = 'erlebniswelt-kunst';
    public static $bereich_funpark = 'erlebniswelt-funpark';
    public static $bereich_transferservice = 'transferservice';

    public static function getBereiche() {
        return [
            self::$bereich_pferd           => 'Erlebniswelt Pferd',
            self::$bereich_fitness         => 'Erlebniswelt Fitness',
            self::$bereich_wellness        => 'Erlebniswelt Wellness',
            self::$bereich_kunst           => 'Erlebniswelt Kunst',
            self::$bereich_funpark         => 'Erlebniswelt Fun Park – Verleih',
            self::$bereich_transferservice => 'Transferservice',
        ];
    }

    public static function getLabel( $key ) {
        return self::getBereiche()[ $key ];
    }

}
