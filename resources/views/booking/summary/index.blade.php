@extends('layout', ['bgbody' => 'bg-gold-100'])
@section('header')@include('_layouts.header.header_booking')@endsection
@section('content_booking')
    <div class="container sm:max-w-full sm:px-0">


        <x-bookingheader step="zusammenfassung" title="Übersicht"/>
        <div class="text-lg">
            <p class="mt-8">Sind alle Daten korrekt? Wenn ja klicken Sie unten auf den Button "Buchungsanfrage senden".
                Haben Sie Änderungswünsche folgen Sie den entsprechenden "Ändern"-Link.
            </p>
            <h3 class="mt-8 heading4">Ihr Aufenthalt</h3>

            <div class="text-gray-900 mt-5">
                {!! $cart->present()->vonbis() !!}
            </div>
            @if($paket = $cart->pakete()->first())
                <div class="mt-2">
                    Urlaubspaket "{{ $paket->title }}"
                    <div class="mt-1 text-gray-900">
                        <span class="whitespace-no-wrap">{{ plural( $cart->nights, 'Übernachtung' ) }}</span> für <span
                            class="whitespace-no-wrap"> {{ plural( $cart->teilnehmer, 'Teilnehmer' ) }}</span>
                        @if($cart->gaeste > 0)
                            und <span class="whitespace-no-wrap">{{ plural( $cart->gaeste, 'Begleitperson' ) }}</span>
                        @endif
                    </div>
                </div>
            @else
                <div class="mt-1 text-gray-900">
                    {{ $cart->present()->nights() }} für {{ $cart->present()->gaeste() }}
                </div>
            @endif
            <div class="mt-10 w-full flex justify-between">
                <div class="w-1/2">
                    <span class="label">Check-In</span><br>
                    <span class="">Ab 15:00 Uhr</span>
                </div>
                <div class="w-1/2 ml-1">
                    <span class="label">Check-Out</span><br>
                    <span class="">Vor 12:00 Uhr</span>
                </div>
            </div>

            @include('booking.summary.appartement')
            @include('booking.summary.erlebniswelten')
            <h3 class="mt-12 heading3">Ihre Kontaktdaten</h3>
            @include('booking.summary.kontakt')

            <a class="my-8 block btn w-full text-center" role="button" href="{{ route('summary.store') }}">Buchungsanfrage senden</a>
        </div>
    </div>
@endsection
