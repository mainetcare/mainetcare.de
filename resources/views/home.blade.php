@extends('layout')
@section('content')
    <div class="hero w-full lg:h-screen-2/3 flex justify-center items-center  bg-no-repeat bg-cover"
         style="background-image:url('/assets/home/willkommen_bei_mainetcare.jpg')">
        <div class="container relative">
            <div class="w-2/3">
                <div class="text-white">
                    <h1 class="font-serif text-5xl tracking-wide leading-tight font-bold">
                        Das Wachstum Ihrer Website<br>
                        liegt uns am Herzen
                    </h1>
                    <p class="mt-12 text-xlg leading-tight">Wir kümmern uns um Ihren Online-Auftritt – <br>
                        mit Fachwissen und Fürsorge
                    </p>
                </div>
            </div>
        </div>
    </div>

    @include('pages.home.home_sections')



    {{--    @include('home_newsletter')--}}
@endsection
@push('styles')
    <style>
        .hero {
            background-position-y: -0px;
        }
    </style>
@endpush
