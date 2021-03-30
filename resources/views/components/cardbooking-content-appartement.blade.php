<x-list-horizontal :items="$appartement->present()->features()" class="text-sm sm:text-base font-semibold mt-2"/>
<div class="my-4">
    {{ $appartement->entry->col_text }}
</div>

<livewire:modal label="Details" collection="appartements" :slug="$appartement->slug" :key="$appartement->id"/>

<x-divider/>

<div class="grid grid-cols-1 sm:grid-cols-3 sm:gap-8 gap-4">
    <div class="text-sm sm:text-base text-gray-500 col-span-2">
        @isset($paket)
            <div>Urlaubspaket {{ $paket->title }}</div>
        @endif
        {{ $appartement->klasse()->get('preistext') }}
        @foreach($appartement->getPauschalen() as $pauschale)
            <span class="whitespace-no-wrap">Zzgl. {{ $pauschale['beschreibung'] ?? '' }} {{ euro($pauschale['preis_pauschale']) }}</span>
        @endforeach
    </div>
    <div class="text-right">
        @php
            $pricedisplay = $appartement->pricedisplay();
        @endphp
        @if($pricedisplay->hasStreichpreis())
            <div class="text-xlg font-sans font-semibold leading-tight whitespace-no-wrap">
                <span class="block text-gray-500 line-through">{{ euro($pricedisplay->getRegularPrice()) }}</span>
                <span class="block mt-2 flex justify-end items-center">
                                <span class="block px-2 py-1 leading-none bg-gold-900 text-gold-400 rounded text-sm">–{{ $pricedisplay->getDiscountPercent() }}%</span>
                                <span class="block ml-2">{{ euro($pricedisplay->getCurrentPrice()) }}</span>
                            </span>
                <span class="block font-normal text-sm text-gray-500">
                    @isset($paket)

                    @else
                        pro Nacht
                    @endif
                </span>
            </div>
        @else
            <span class="font-sans whitespace-no-wrap text-xlg font-semibold leading-tight">{{ euro($pricedisplay->getCurrentPrice()) }}</span>
            <span class="block text-base text-gray-500">pro Nacht</span>
        @endif
        <div class="mt-6 z-30 flex justify-end">
            @if($appartement->isAvailable())
                <button wire:click="select('{{ $appartement->slug }}')" class="w-full btn btn-flat">Auswählen</button>
            @else
                <button title="{{ $appartement->statusmessage }}"
                        class="w-full btn btn-flat bg-gold-200 border-gold-200 text-gray-500 hover:text-gray-500 hover:bg-gold-200 hover:border-gold-200 cursor-auto">
                    Auswählen
                </button>
            @endif
        </div>
    </div>
</div>
