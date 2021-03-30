@extends('layout', ['bgbody' => 'bg-gold-100'])
@section('header')@include('_layouts.header.header_booking')@endsection
@section('content')
    <div class="bg-red-300"></div>
    <x-container-narrow class="my-32">
        <div class="grid sm:grid-cols-6 gap-12 place-items-center">
            <div class="">
                <svg class="w-20 h-20 text-gold-500"xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="col-span-5 text-xlg content">
                <h1 class="heading1">Etwas ist schiefgelaufen…</h1>
                <p>
                    Bei Ihrer Anfrage ist ein technischer Fehler aufgetreten. Ihre Angaben konnten
                    nicht versendet werden. Wir bitten dies zu entschuldigen.
                </p>
                <p>Was können Sie tun?</p>
                <p><a href="{{ route('summary.store') }}">Es noch einmal versuchen...</a></p>
                <p>Wenn der Fehler wiederholt auftritt und Sie wieder hier landen: Keine Panik! Ihre bisherigen Angaben sind nicht verloren.
                    Nehmen Sie bitte mit uns telefonisch Kontakt auf unter <span class="whitespace-no-wrap">03 83 06 / 27 80-08</span> oder schicken
                    Sie uns eine E-Mail an <x-email>info@residenz-kubitzer-bodden.de</x-email> und wir führen die Anfrage für Sie manuell aus.
                </p>
            </div>

        </div>
    </x-container-narrow>
@endsection
