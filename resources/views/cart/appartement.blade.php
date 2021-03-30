@if($cart->appartements()->count() > 0)
    <div class="">
        @if($cart->hasPakete())
            <h5 class="label">Urlaubspaket in Appartement</h5>
        @else
            <h5 class="label">Appartement</h5>
        @endif

        @foreach($cart->appartements() as $appartement)
            <div class="@if (! $loop->first) mt-4 @endif sm:flex items-end justify-between">
                <div class="sm:w-3/4">
                    {!! $appartement->title !!}<br>
                    {!! $appartement->zimmer !!} Zimmer, {!! $appartement->lage !!}
                    @if($appartement->cart_item->content)
                        <div>{!! $appartement->cart_item->content !!}</div>
                    @endif
                </div>
                <div class="sm:w-1/4 ml-3 text-right label whitespace-no-wrap">{{ euro($appartement->cart_item->total) }}</div>
            </div>
            @include('cart.change_item', ['cart_item' => $appartement->cart_item ])
        @endforeach
    </div>
@endif
@if($cart->pauschalen()->count() > 0)
    <div class="mt-4">
        @foreach($cart->pauschalen()->get() as $pauschale)
            <div class="@if (! $loop->first) mt-4 @endif flex items-end justify-between">
                <div class="w-3/4">
                    <h5 class="label">{{ $pauschale->title }}</h5>
                    @if($pauschale->content)
                        <div>{!! $pauschale->content !!}</div>
                    @endif
                </div>
                <div class="w-1/4 ml-3 text-right label whitespace-no-wrap">{{ euro($pauschale->total) }}</div>
            </div>
        @endforeach
    </div>
@endif
