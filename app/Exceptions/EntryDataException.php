<?php

namespace App\Exceptions;

use Exception;

class EntryDataException extends Exception {

	protected $message = 'Die Datenstruktur des Statamic Entrys ist fehlerhaft';


}
