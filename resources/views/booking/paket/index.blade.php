@extends('layout', ['bgbody' => 'bg-gold-100'])
@section('header')@include('_layouts.header.header_booking')@endsection
@section('content_booking')
    @if(!$is_mobile)
        <div class="">
            <livewire:init-paket :slug="$paket->slug" size="small" />
        </div>
        <div class="mt-16"></div>
        <div class="px-5">
            <x-bookingprogress step="appartements"/>
        </div>
    @endif

    <div class="sm:mt-16">
        @livewire('list-paketappartements')
    </div>

@endsection


