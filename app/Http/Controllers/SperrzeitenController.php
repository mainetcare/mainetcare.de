<?php

namespace App\Http\Controllers;

use App\Factories\AppartementFactory;
use App\Repositories\AppartementRepository;
use Illuminate\Http\Request;

class SperrzeitenController extends Controller {

    public function index() {
        return view( 'admin.sperrzeiten' )->with( [
            'appartements' => $this->getAppartements()
        ] );
    }

    public function edit( $id ) {
        $app = app( AppartementFactory::class )->initById( $id );
        if ( ! $app ) {
            throw new \Exception( 'Appartement mit Id ' . $id . ' konnte nicht geladen werden.' );
        }

        return view( 'admin.sperrzeiten_edit' )->with( [
            'appartement'  => $app,
            'appartements' => $this->getAppartements()
        ] );
    }

    protected function getAppartements() {
        return app( AppartementRepository::class )->getAdmin();
    }


}
