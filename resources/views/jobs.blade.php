@extends('layout')
@section('content')
    @include('_layouts._default_content_white')

    <x-container-narrow>
        <div class="my-24 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8 lg:gap-8 square-grid">
            @include('partials._jobs')
        </div>
    </x-container-narrow>

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
