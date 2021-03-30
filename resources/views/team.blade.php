@extends('layout')
@section('content')
    @include('_layouts._default_content_white')

    <x-container-narrow>
            @include('partials._team')
    </x-container-narrow>
    <div class="mb-24"></div>

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
