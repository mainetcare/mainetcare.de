<div class="text-gray-900 mt-3">
    {!! $cart->present()->vonbis() !!}
</div>
<div class="mt-1 text-gray-900">
    {{ $cart->present()->nights() }} für {{ $cart->present()->gaeste() }}
</div>
<div class="mt-4 w-full flex justify-between text-xs">
    <div class="w-1/2">
        <span class="label">Check-In</span><br>
        <span class="font-serif">Ab 15:00 Uhr</span>
    </div>
    <div class="w-1/2 ml-1">
        <span class="label whitespace-no-wrap">Check-Out</span><br>
        <span class="font-serif">Vor 12:00 Uhr</span>
    </div>
</div>
