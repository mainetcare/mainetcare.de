<?php

namespace App\View\Components\Dropdown;

use Illuminate\View\Component;

class Modal extends Component {


    public $xdata = 'dropdown({ overlay:false })';
    public $label = 'Details';
    public $innerstyle = 'min-height:50vh;max-width:600px;';

    public function __construct( $xdata = null, $label = null, $innerstyle = null ) {

        if ( $xdata ) {
            $this->xdata = $xdata;
        }
        if ( $label ) {
            $this->label = $label;
        }
        if ( $innerstyle ) {
            $this->innerstyle = $innerstyle;
        }

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view( 'components.dropdown.modal' );
    }
}
