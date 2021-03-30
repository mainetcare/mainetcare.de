<?php

namespace App\Http\Controllers;

use App\Exceptions\BookingException;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Statamic\Facades\Entry;
use Statamic\View\View;

class HomepageController extends Controller
{

    public function index() {

        // Zum Testen für das Design von allgemeinen Fehlermeldungen außerhalb von Livewire:
//        $errors = new MessageBag([
//            ['cust_error' => 'Some Custom Error']
//        ]);

        $entry = Entry::findBySlug('home', 'pages');
        return ( new View )
            ->template( $entry->template() )
//            ->with(['errors' => $errors])
            ->cascadeContent( $entry );

    }



}
