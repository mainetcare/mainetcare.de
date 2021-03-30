<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Checkbox extends Component {

    public $id = '';
    public $value;
    public $withwire = '';


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( $id, $value, $withwire = null ) {
        $this->id    = $id;
        $this->value = $value;
        if ( $withwire ) {
            $this->withwire = "wire:" . $withwire . '="' . $this->id . '"';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view( 'components.checkbox' );
    }
}
