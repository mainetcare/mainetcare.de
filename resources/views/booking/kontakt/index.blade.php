@extends('layout', ['bgbody' => 'bg-gold-100'])
@section('header')@include('_layouts.header.header_booking')@endsection
@section('content_booking')
    <div class="container sm:max-w-full sm:px-0">
        <x-bookingheader step="kontakt" title="Kontakt" />
        <livewire:kontaktdaten/>
    </div>
@endsection
