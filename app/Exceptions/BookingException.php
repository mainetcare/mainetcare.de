<?php

namespace App\Exceptions;

use Exception;

class BookingException extends Exception {

	protected $message = 'Bei der Anfrage ist ein Fehler aufgetreten';

    /**
     * @param $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
	public function render( $request ) {

		return redirect()->home()->withErrors( [
			'type' =>   $this->getMessage()
		] );

	}
}
