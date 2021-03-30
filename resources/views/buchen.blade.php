@extends('layout')
@section('content')
    <div class="w-full lg:h-screen flex justify-center items-center sm:h-2/3 bg-cover" style="background-image:url('/assets/startseite/herrlicher-gibt-es-nicht.jpg')">
        <div class="container relative">
            <div class="lg:mb-64 sm:mb-32 sm:mt-20 flex flex-col items-center">
                <h1 class="my-8 sm:my-0 text-center heading1 text-gray-900">Jetzt Verfügbarkeit prüfen und buchen</h1>
                <div class="my-10 mx-16">
                    <livewire:init-appartement />
                </div>
            </div>
        </div>
    </div>
@endsection
