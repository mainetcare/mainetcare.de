<?php

namespace App\Http\Controllers;

use App\Exceptions\BookingException;
use Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Statamic\Facades\Entry;
use Statamic\View\View;

/**
 * for testing purposes only
 * Class TestpageController
 * @package App\Http\Controllers
 */
class TestpageController extends Controller
{

    public function index() {

        if (!Auth::check()) {
            return redirect()->home();
        }

        return view('booking.sent.index');

    }



}
