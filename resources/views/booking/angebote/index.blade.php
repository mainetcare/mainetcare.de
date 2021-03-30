@extends('layout', ['bgbody' => 'bg-gold-100'])
@section('header')@include('_layouts.header.header_booking')@endsection
@section('content_booking')
    <div class="container sm:max-w-full sm:px-0">
        <x-bookingheader step="erlebniswelten" :title="$title"/>
    </div>
    @foreach($list as $item)
        <h3 class="container heading4 mt-0 @if(!$loop->first) sm:mt-16 @endif">{{ $item['subtitle'] }}</h3>
        <div class="mt-5">
            @include('booking.angebote.list', ['angebote' => $item['angebote']])
        </div>
        <div class="sm:mb-20 mb-6"></div>
    @endforeach
@endsection
