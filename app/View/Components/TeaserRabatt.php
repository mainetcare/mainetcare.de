<?php

namespace App\View\Components;

use App\Repositories\RabattRepository;
use Illuminate\View\Component;

class TeaserRabatt extends Component {

    protected $rabatt = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct() {
        $rabatt = app( RabattRepository::class )->getActiveRabatt();
        if ( $rabatt && $rabatt->entry->get( 'homepage' ) ) {
            $this->rabatt = $rabatt;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view( 'components.teaser-rabatt', [ 'rabatt' => $this->rabatt ] );
    }
}
