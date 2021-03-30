@extends('layout')
@section('content')
    @include('partials._header_image')
    <div class="bg-gold-200 island-p">
        <div class="container relative">
            <div class="w-2/3 mx-auto">
                <h1 class="heading1 leading-tight text-gold-600">{{ $title }}</h1>
                <div class="mt-4">
                    @include('partials._teaser')
                </div>
            </div>
        </div>
    </div>
    @if(! empty($content->value()) )
        <div class="container my-24">
            <div class="w-2/3 mx-auto">
                @include('partials._content')
            </div>
        </div>
    @endif
    @include('partials._newsletter')
@endsection
