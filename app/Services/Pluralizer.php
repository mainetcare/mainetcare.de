<?php


namespace App\Services;


class Pluralizer {

    protected static $table_komplex = [
        'Gast'                      => 'Gäste',
        'Tour'                      => 'Touren',
        'Nacht'                     => 'Nächte',
        'Saison'                    => 'Saisons',
        'Übernachtung'              => 'Übernachtungen',
        'Person'                    => 'Personen',
        'Beifahrer'                 => 'Beifahrer',
        'Stück'                     => 'Stück',
        'Stk'                       => 'Stück',
        'Stunde'                    => 'Stunde',
        'Std'                       => 'Stunden',
        'Anzahl'                    => 'Anzahl',
        'Einheit'                   => 'Einheiten',
        'Fahrrad'                   => 'Fahrräder',
        'Fahrt'                     => 'Fahrten',
        'Fahrt (Rostock Bahnhof)'   => 'Fahrten (Rostock Bahnhof)',
        'Fahrt (Stralsund Bahnhof)' => 'Fahrten (Stralsund Bahnhof)',
        'Fahrt (Rostock Airport)'   => 'Fahrten (Rostock Airport)',
        'Teilnehmer'                => 'Teilnehmer',
        'Begleitperson'             => 'Begleitpersonen',
        'Karte'                     => 'Karten',
        'Appartement'               => 'Appartements',
        'restliche'                 => 'restlichen'
    ];

    public static function get( $singular ) {
        $s = self::norm( $singular );
        if ( array_key_exists( $s, self::$table_komplex ) ) {
            return self::$table_komplex[ $s ];
        }

        return $s . 'e';
    }

    public static function norm( $s ) {
        return trim( ucfirst( $s ) );
    }


}
