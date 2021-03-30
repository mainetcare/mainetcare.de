<div>

    {{ $appartements->links() }}
    @foreach($appartements as $appartement)

        {{--                --}}
        <x-cardbooking>

            <x-slot name="cardimage">
                @if($appartement->entry->col_img)
                    @include('partials._col_image', ['col_img' => $appartement->entry->augmentedValue('col_img')->value()])
                @else
                    <img src="/assets/appartements/placeholder_app.jpg" alt="Platzhalter Bild für Appartement">
                @endif
            </x-slot>

            <x-slot name="cardtitle">
                {{ $appartement->title }}
            </x-slot>
            {{--        --}}
            <x-cardbooking-content-appartement :appartement="$appartement" :paket="$paket"/>

        </x-cardbooking>

    @endforeach
    {{ $appartements->links() }}

</div>
