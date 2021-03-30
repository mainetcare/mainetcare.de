<?php

namespace App\Http\Livewire;

use App\Factories\AppartementFactory;
use App\Models\Appartement;
use Jenssegers\Agent\Facades\Agent;
use Livewire\Component;
use Statamic\Entries\Entry;
use View;

class Modal extends Component {

    public $modal_content = '';

    public $slug = '';
    public $collection = 'pages';

    public $label = 'Details';

    public $url = '';

    public $innerstyle="width:66.66667vw;max-height:90vh";

    /**
     * @var null | Entry
     */
    protected $entry = null;


    public function load() {
        $this->initEntry();
        if($this->entry !== null) {
            $this->url = $this->entry->url();
        }
    }

    protected function initEntry() {
        $this->entry =  \Statamic\Facades\Entry::findBySlug( $this->slug, $this->collection );
    }

    public function render() {
        if(Agent::isMobile() && !Agent::isTablet()) {
            $this->innerstyle='';
        }
        return view( 'livewire.modal', [ 'entry' => $this->entry ] );
    }

//    protected function renderModalContent() {
//        if ( $this->collection == 'appartements' ) {
//            return $this->getContentAppartement( $this->slug );
//        }
//
//        return '';
//    }
//
//    protected function getContentAppartement( $slug ) {
//        $appartement = app( AppartementFactory::class )->initBySlug( $slug );
//        if ( ! $appartement ) {
//            return 'Ein Fehler ist aufgetreten: Appartementdaten konnten nicht geladen werden.';
//        }
//
//        return 'something';
////        return ( new \Statamic\View\View )
////            ->template( 'modal' )
////            ->with( [
////                'appartement' => $appartement
////            ] )
////            ->cascadeContent( $appartement->entry )
////            ->render();
//    }


}
