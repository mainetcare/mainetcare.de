<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Svg extends Component {
    /**
     * @var string the filename (without path and suffix) of the icon
     */
    public $url;


    /**
     * Create a new component instance.
     *
     * @param $url
     * @param $class
     */
    public function __construct( $url ) {
        $this->url  = $url;
        if ( is_file( $file = public_path() . '/' .  $this->url ) ) {
            $this->url = file_get_contents( $file );
        } else {
            $this->url = $file;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return function (array $data) {
            // @todo this is a veeery simple way of injecting the attributes :-)
            if($data['attributes']) {
                $this->url = trim(str_replace('<svg ', '<svg '.$data['attributes'], $this->url));
            }
            return $this->url;
        };
    }

}
