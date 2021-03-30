<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Dropdown extends Component
{

    public $add = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($add = null)
    {
        $this->add = $add;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.dropdown');
    }
}
