@extends('layout')
@section('content')
    @include('_layouts._default_content')

    <x-container-narrow>
            @include('partials._pferde')
    </x-container-narrow>
    <div class="mb-16"></div>
    <x-cta-booking>
        <livewire:init-appartement />
    </x-cta-booking>
@endsection
@push('styles')
    <style type="text/css">
        .square-grid a::before {
            content: "";
            padding-bottom: 75%;
            display: inline-block;
            vertical-align: top;
        }
    </style>
@endpush
