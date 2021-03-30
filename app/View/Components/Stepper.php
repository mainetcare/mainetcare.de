<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Stepper extends Component {


    public $inc = 'inc()';
    public $dec = 'dec()';
    public $bindto = 'default';
    protected $framework = 'alpine';

    /**
     * Create a new component instance.
     *
     * @param $bindto
     * @param string $inc
     * @param string $dec
     */
    public function __construct( $bindto, $inc = '', $dec = '' ) {

        if(strpos($inc, 'wire:') !== false) {
            $this->framework = 'livewire';
        }

        if ( $inc ) {
            $this->inc = $inc;
        }
        if ( $dec ) {
            $this->dec = $dec;
        }
        $this->bindto = $bindto;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view( 'components.stepper', ['framework' => $this->framework] );
    }
}
