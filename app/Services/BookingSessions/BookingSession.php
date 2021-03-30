<?php


namespace App\Services\BookingSessions;

use App\Models\Cart;
use Route;

abstract class BookingSession {


    public const KEY_STEP = 'step';
    public const KEY_CART = 'cart_id';

    public function next() {
        return $this->getRouteOfStep( $this->step() + 1 );
    }

    /**
     * @return array
     */
    abstract protected function getSteps();

    /**
     * @return int
     */
    public function decStep() {
        $step = $this->step();
        $this->setStep( $step - 1 );

        return $this->step();
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function reset() {
        session()->put( self::KEY_CART, null );
        session()->put( self::KEY_STEP, null );

        return $this;
    }


    /**
     * @param int $i
     *
     * @return BookingSession
     */
    public function setStep( int $i ) {
        if ( array_key_exists( $i, $this->getSteps() ) ) {
            session()->put( self::KEY_STEP, $i );
        }

        return $this;
    }

    public function getRouteOfStep( int $step ) {
        $steps = $this->getSteps();
        if ( isset( $steps[ $step ] ) ) {
            return $steps[ $step ];
        } else {
            return '';
        }
    }

    /**
     * saves the id of Cart in Session
     *
     * @param Cart $id
     */
    public function setCart( Cart $cart ) {
        session()->put( self::KEY_CART, $cart->id );
    }

    /**
     * @return int
     */
    public function step() {
        $i = session( self::KEY_STEP );
        if ( $i === null ) {
            $i = 1;
            session()->put( self::KEY_STEP, $i );
        }

        return $i;
    }

    public function back() {
        return $this->getRouteOfStep( $this->step() - 1 );
    }

    /**
     * @return Cart
     */
    public function cart() {
        $id   = session( self::KEY_CART );
        $cart = Cart::find( $id );
        if ( ! $cart ) {
            $cart = Cart::create()->refresh(); // create and hydrate
            $this->setCart( $cart );
        }

        return $cart;
    }

    /**
     * @return int
     */
    public function incStep() {
        $step = $this->step();
        $this->setStep( $step + 1 );

        return $this->step();
    }

    /**
     * @param Route|null $route
     *
     * @return $this
     */
    public function setStepByRoute( string $uri ) {
        $this->setStep( array_search( $uri, $this->getSteps() ) );

        return $this;
    }

    /**
     * checks if it is allowed to proceed to the next step
     *
     * @return bool
     */
    public function gateForStep() {
        $step = $this->step();
        $method = 'gateStep'.($step);
        if(method_exists($this, $method)) {
            return $this->$method();
        }
        return true;
    }


}


