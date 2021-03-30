@extends('layout')
@section('content')

    @include('_layouts._default_content_white')

    <x-container-narrow>
        <div class="mb-24">
            <div class="w-full pb-4 flex justify-start items-end font-sans heading3 border-b border-gray-100">
                <div class="w-1/5 text-center">Datum</div>
                <div class="w-4/5">Veranstaltung</div>
            </div>
            @include('partials._veranstaltungen')
        </div>
    </x-container-narrow>


@endsection
