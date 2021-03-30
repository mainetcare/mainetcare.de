@php
    $sum_total = $cart->getSumTotal();
@endphp


<div x-data="{ open:false }" class="w-full top-0 bg-gold-200">

    <button @click.prevent.stop="open=true" x-show="!open" class="py-2 w-full container flex items-center justify-start">
        {{--  SVG PLUS Golden --}}
        <svg class="w-5 h-5 stroke-current text-gold-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 23 23">
            <path d="M1.5 11.5h20m-10-10v20" fill="none" stroke="#c69c40" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/>
        </svg>
        <span class="block ml-2 flex-1">
            <span class="flex items-center justify-between font-sans label">
                <span class="">
                    Ihr Aufenthalt
                </span>
                @if($sum_total > 0)
                    <span class="ml-2 text-right">
                        {{ euro($sum_total) }}
                    </span>
                @endif
            </span>
        </span>
    </button>

    <div x-show="open" x-cloak="" class="pt-4 z-40 h-full bg-gold-200 inset-0 fixed overflow-y-scroll">

        <button
            @click.prevent.stop="open=false"
            class="py-2 w-full container flex items-center justify-start"
        >
            {{--  SVG Close --}}
            <svg class="h-5 w-5 text-gold-500 stroke-current" viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg" style="">
                <path d="M2 2L20.5 20.5M20.5 2L2 20.5" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="block ml-4 flex-1">
                <span class="flex items-center justify-between font-sans label">
                <span class="">
                    Ihr Aufenthalt
                </span>
                    @if($sum_total > 0)
                        <span class="ml-2 text-right">
                        {{ euro($sum_total) }}
                    </span>
                    @endif
                </span>
            </span>
        </button>
        <div class="container">
            {{--   checkin checkout Uhrzeit --}}
            <div class="w-full flex justify-between">
                <div class="w-1/2">
                    <span class="label">Check-In</span><br>
                    <span class="">Ab 15:00 Uhr</span>
                </div>
                <div class="w-1/2 ml-1">
                    <span class="label">Check-Out</span><br>
                    <span class="">Vor 12:00 Uhr</span>
                </div>
            </div>
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
            <x-modalsimple>
                <x-slot name="trigger">
                    <button @click.prevent.stop="open=true" class="my-4 btn w-full">Suche anpassen</button>
                </x-slot>
                <h3 class="heading3 my-4">Suche anpassen:</h3>
                @if($paket)
                    <livewire:init-paket :slug="$paket->slug" size="small" />
                @else
                    <livewire:init-appartement :key="'neue_suche'"/>
                @endif
            </x-modalsimple>
            @include('cart.appartement')
            @include('cart.angebote')
        </div>
        <x-divider/>
        <div class="container">
            <div class="flex items-center justify-between font-sans font-medium">
                <span class="inline-block">Gesamtbetrag</span>
                <span class="text-right inline-block ml-2 whitespace-no-wrap">{{ euro($cart->getSumTotal()) }}</span>
            </div>
        </div>

        <div class="h-24"></div>
    </div>


</div>
