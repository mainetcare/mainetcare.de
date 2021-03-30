@extends('layout')
@section('content')
    @include('_layouts._default_content')
    <div class="bg-gold-300 pt-8 sm:pt-20 pb-8 sm:pb-24">
        <div class="container flex flex-col items-center">
                <h2 class="heading1 text-center">Jetzt Verfügbarkeit prüfen und buchen</h2>
                <div class="my-10 lg:mx-10 bg-white rounded lg:text-sm sm:text-xs">
                    <livewire:init-appartement />
                </div>
        </div>
    </div>
@endsection

