@extends('layout')
@section('content')
    <div class="bg-gold-100 sm:pt-20 bg-gold-100 sm:pb-24 pb-8">
        <div class="container">
            <div class="flex">
                <div class="">
                    <div class="px-5 mt-8 flex justify-center">
                        <x-bookingprogress step="versendet"/>
                    </div>
                    <div class="mt-8 mx-auto sm:w-2/3 sm:text-lg">
                        <h1 class="text-center heading1 leading-tight text-gray-900">Vielen Dank für Ihre Anfrage!</h1>
                        <p class="mt-6 text-center">Ihre Anfrage wurde per E-Mail an unser Service-Team
                            weitergeleitet, dass in Kürze mit Ihnen Kontakt aufnehmen wird.
                            Sie erhalten eine verbindliche Buchungsbestätigung mit den Bezahlmöglichkeiten.</p>
                        <p class="mt-6 text-center">In der Zwischenzeit können Sie ein paar Eindrücke aus der Residenz Kubitzer Bodden genießen.</p>
                        <img class="mt-10" src="/assets/misc/videothumb.png" alt="Vorschau Promofilm Residenz Kubitzer Bodden">
                        <a class="mt-8 block btn text-center btn-flat w-full" href="/">Zur Startseite</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
