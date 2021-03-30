@extends('admin.layout')
@section('title')
    Sperrzeiten verwalten
@endsection
@section('content')
    <div class="m-16">
        <div class="grid grid-cols-6 gap-6">
            <div class="mt-8 col-span-2">
                @include('admin._sperrzeiten_app_list')
            </div>
            <div class="mt-8 col-span-4">
                Bitte Appartement wählen...
            </div>
        </div>
    </div>
@endsection
