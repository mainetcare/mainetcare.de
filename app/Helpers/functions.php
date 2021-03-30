<?php

use App\Helpers\Obfuscator;
use App\Services\BookingSessions\BookingSessionRouter;
use App\Services\Pluralizer;

function refslink() {
    return url()->full();
}

/**
 * get the previous url
 * if the previous url is the current get the url of homepage
 * @return string
 */
function prev_or_home() {
    $url  = url()->full();
    $prev = url()->previous();
    if ( $url == $prev ) {
        return route( 'home' );
    }

    return $prev;
}

/**
 * @param string $quickname
 *
 * @return \Spatie\MediaLibrary\MediaCollections\Models\Media |null
 */
function media_of( string $quickname ) {
    /**
     * @var $image \App\Models\Image
     */
    $image = \App\Models\Image::where( 'quickname', $quickname )->first();
    if ( $image ) {
        return $image->getMediaImage();
    }

    return null;
}

/**
 * obfuscates a string so bots get it harder to interprete it
 *
 * @param $value
 *
 * @return mixed|string
 */
function obfuscate( $value ) {
    return Obfuscator::getString( $value );
}

/**
 * make sure string or number is return in array form
 *
 * @param $string_or_number
 *
 * @return array
 */
function as_array( $string_or_number ) {
    if ( is_string( $string_or_number ) || is_numeric( $string_or_number ) ) {
        return [ $string_or_number ];
    }

    return $string_or_number;
}

/**
 * helper for getting a Statamic Menu
 */
if ( ! function_exists( 'get_menu' ) ) {
    function get_menu( $slug, $locale = null ) {
        $nav = \Statamic\Structures\Nav::find( $slug );
        if ( ! $nav ) {
            return collect( [] );
        }

        return $nav->trees()->first()->tree();
    }
}


/**
 * returns the shopping cart
 * @return \App\Models\Cart
 */
function cart() {
    return booking_session()->cart();
}

/**
 * @return \App\Services\BookingSessions\BookingSession
 * @throws \App\Exceptions\BookingException
 */
function booking_session() {

    if ( ! $session = app( BookingSessionRouter::class )->getActiveSession() ) {
        throw new \App\Exceptions\BookingException( 'Ihre Buchungs-Sitzung ist abgelaufen und aus Sicherheitsgründen nicht mehr gültig. Bitte wählen Sie erneut aus.' );
    }

    return $session;
}

/**
 * Helper to convert something like 12,50 to 12.50
 *
 * @param $price
 *
 * @return float
 */
function get_price_as_float( $price ) {
    return floatval( str_replace( ',', '.', $price ) );
}

function money( $price ) {
    return number_format( get_price_as_float( $price ), 2, ',', '.' );
}

function euro( $price ) {
    return str_replace( ",00", ",-", money( $price ) ) . ' €';
}

function nbsp( $x ) {
    return str_replace( ' ', '&nbsp;', $x );
}

/**
 * @param $amount
 * @param $einheit
 *
 * @return string
 */
function plural( $amount, $einheit ) {
    $einheit = __pl($amount, $einheit);
    return $amount . ' ' . $einheit;
}

function __pl($amount, $einheit) {

    if($amount == 1) {
        return $einheit;
    }
    return Pluralizer::get( $einheit );
}

/**
 * checks if the given email is a syntactical valid email address
 *
 * @param $email
 *
 * @return bool
 */
function checkmail( $email ) {
    $validator = Validator::make(
        [ 'email' => $email ],
        [ 'email' => 'required|email' ] );

    return ! $validator->fails();
}

