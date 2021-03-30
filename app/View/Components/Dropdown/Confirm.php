<?php

namespace App\View\Components\Dropdown;

use Illuminate\View\Component;

class Confirm extends Component {

    public $wire = false;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( $wire = false ) {
        $this->wire = $wire;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view( 'components.dropdown.confirm' );
    }
}
