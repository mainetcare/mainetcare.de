@extends('layout', ['bgbody' => 'bg-gold-100'])
@section('header')@include('_layouts.header.header_booking')@endsection
@section('content')
    <div class="container my-24">
        <div class="flex">
            <div class="w-2/3">

                <h1 class="heading1 text-gold-600">{{ $title }}</h1>

                <div class="mt-6">
                    {!! $col_text !!}
                </div>
                <div class="mt-8">
                    @include('partials._col_image')
                </div>
                <div class="mt-6">
                    <x-list-horizontal :items="$appartement->present()->features()" class="font-semibold"/>
                </div>
                <div class="mt-6">
                    @include('partials._content')
                    @include('partials._gal-rowspan-right')
                </div>
            </div>
            <div class="ml-4 w-1/3">
                <livewire:warenkorb/>
                <div class="mt-10 text-center w-full">
                    @livewire(
                    'add-appartement-to-cart',
                    ['appartement' => $appartement ],
                    key($appartement->id)
                    )
                    <livewire:navigate-booking />
                    <a href="{{ route('appartement-select.index') }}" class="block mt-5 btn btn-out py-3 bg-transparent">Alle Appartements</a>
                </div>
            </div>



        </div>
    </div>
@endsection
