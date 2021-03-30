@foreach(cart()->erlebniswelten() as $erlebniswelt)

    @if(count($erlebniswelt['list']) > 0)
        <div class="mt-12">
            <h5 class="label">{{ $erlebniswelt['title'] }}</h5>
            @foreach($erlebniswelt['list'] as $angebot)
                <div class="mt-2 flex items-end justify-between">
                    <span class="inline-block w-3/4">
                        {!! $angebot->cart_item->title !!}<br>
                        {!! nl2br($angebot->cart_item->content) !!}
                    </span>
                </div>
            @endforeach
        </div>
    @endif

@endforeach

