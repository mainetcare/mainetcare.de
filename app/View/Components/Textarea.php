<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Textarea extends Component {

    public $id = '';
    /**
     * @var bool
     */
    public $defer;

    /**
     * Create a new component instance.
     *
     */
    public function __construct( $id, $defer = false ) {

        $this->id    = $id;
        $this->defer = $defer == true ? '.defer' : '';

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view( 'components.textarea' );
    }
}
