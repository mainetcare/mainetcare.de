@foreach(cart()->erlebniswelten() as $erlebniswelt)

    @if(count($erlebniswelt['list']) > 0)
        <div class="">
            <h5 class="label mt-10">{{ $erlebniswelt['title'] }}</h5>
            @foreach($erlebniswelt['list'] as $angebot)
                <div class="sm:flex items-end justify-between">
                    <span class="inline-block sm:w-3/4">
                        {!! $angebot->cart_item->title !!}<br>
                        {!! nl2br($angebot->cart_item->content) !!}
                    </span>
                    <div class="sm:w-1/4 ml-3 text-right label whitespace-no-wrap">{{ euro($angebot->cart_item->total) }}</div>
                </div>
                @include('cart.change_item', ['cart_item' => $angebot->cart_item ])
            @endforeach
        </div>
    @endif

@endforeach
