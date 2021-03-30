@extends('layout')
@section('content')
    @include('partials._header_image')
    <div class="bg-gold-100 pt-8 sm:pt-20 bg-gold-100 sm:pb-24 pb-8">

        <div class="container">

            <h1 class="text-center heading1 text-gold-500">{{ $title }}</h1>

            <div class="mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-8 square-grid">
                @include('partials._erlebniswelten')
            </div>

        </div>
    </div>
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
