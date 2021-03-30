<?php


namespace App\Http\Livewire;


use App\Factories\AppartementFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\MessageBag;
use Log;

trait EntryModelTrait {


    /**
     * @param $slug
     *
     * @return \App\Models\Appartement|null
     */
    protected function findAppartement( $slug ) {
        $appartement = app( AppartementFactory::class )->initBySlug( $slug );
        if ( ! $appartement ) {
            throw new ModelNotFoundException( 'Appartement mit Slug ' . $slug . ' konnte nicht initialisiert und in den Warenkorb gelegt werden.' );
        }

        return $appartement;
    }

    /**
     * @param $slug
     *
     * @return \App\Models\Appartement|null
     */
    protected function findAppartementOrDie( $slug ) {
        try {
            return $this->findAppartement( $slug );
        } catch ( ModelNotFoundException $e ) {
            $this->errors = new MessageBag();
            $this->dispatchBrowserEvent( 'ltoast', [
                'type'    => 'error',
                'message' => 'Appartement konnte nicht hinzugefügt werden.',
            ] );
        }
        return null;
    }


}
