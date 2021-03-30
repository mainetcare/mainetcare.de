@extends('layout')
@section('content')
    @include('_layouts._default_content')

    <x-container-narrow class="mt-0">
        <div class="content">
            <h3 class="mt-0">Anfahrt:</h3>
            <x-dropdown.modal
                class="text-xlg cursor-pointer"
                label="Routenplaner"
                innerstyle="width:630px;max-height:90vh"
            >
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d147530.24632997863!2d13.031840246537374!3d54.35872168959013!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47ab66d85cd5627f%3A0xb0992c914d945598!2sResidenz%20Kubitzer%20Bodden!5e0!3m2!1sde!2sde!4v1607191281989!5m2!1sde!2sde"
                    width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </x-dropdown.modal>
            <span>(Google Maps)</span>
            <h3>Wir freuen uns von Ihnen zu lesen:</h3>
        </div>
        <livewire:kontaktform/>
        <div class="mt-24"></div>
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
