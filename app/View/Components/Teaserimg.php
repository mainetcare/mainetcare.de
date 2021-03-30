<?php

namespace App\View\Components;

use App\Models\EntryModel;
use Illuminate\View\Component;

class Teaserimg extends Component {

    public $alt = '';
    public $url = '';

    /**
     * @var null | EntryModel
     */
    protected $model = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( EntryModel $model, $default = '' ) {
        $this->model = $model;
        if ( $image = $this->model->entry->col_img ) {
            $this->url = url( 'assets/' . $image );
//            $this->alt = data_get($image->meta(), 'data.alt');
        } else {
            if ( $default ) {
                $this->url = $default;
            } else {
                $this->url = url( 'assets/globals/default_angebote.jpg' ); // todo make this configurable
            }
        }
        $this->alt = 'Beispielbild für Angebot ' . $model->title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view( 'components.teaserimg' );
    }
}
