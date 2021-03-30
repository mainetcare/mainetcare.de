@inject('modify', 'Statamic\Modifiers\Modify')
@foreach($angebote as $angebot)


    <x-cardbooking>

        <x-slot name="cardimage">
            @if($angebot->entry->col_img)
                @include('partials._col_image', ['w' => 900, 'h' => 600, 'col_img' => $angebot->entry->augmentedValue('col_img')->value()])
            @else
                <img src="/assets/appartements/placeholder_app.jpg" alt="Platzhalter Bild für Elebeniswelt">
            @endif
        </x-slot>

        <x-slot name="cardtitle">
            {{ $angebot->title }}
        </x-slot>

        <div class="my-3">
            {!! $modify($angebot->entry->augmentedValue('col_text')->value())->widont() !!}
        </div>

        <x-divider/>

        @foreach($angebot->getBulkPrices() as $priceset)

            <div class="mt-3 sm:flex items-center justify-between">

                <div class="w-full text-gray-600">

                    @foreach($priceset['preise'] as $bulkprice)
                        <div class="w-full mt-1 flex items-center">

                            <div class="text-gray-600">{{ $bulkprice['label_liste'] ?? '' }}</div>
                            <div
                                class="font-sans flex-1 text-right whitespace-no-wrap text-xlg text-gray-900 font-medium leading-tight">{{ euro( $bulkprice['preis'] ?? 0 ) }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="sm:ml-4 mt-6 sm:mt-0">
                    @livewire(
                    'add-angebot-to-cart', [ 'angebot' => $angebot, 'unit' => $priceset['unit'], 'variant' => $priceset['variant'] ],
                    key($angebot->id)
                    )
                </div>
            </div>


            @if (!$loop->last)
                <x-divider/>
            @endif

        @endforeach

    </x-cardbooking>



@endforeach
