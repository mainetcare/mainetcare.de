@foreach($items as $item)
    <div class="mt-2 flex items-end justify-between text-sm">
        <span class="inline-block w-3/4">
            {!! $item->title !!}<br>
            {!! $item->text !!}
        </span>
        <span class="text-right inline-block w-1/4 ml-3 whitespace-no-wrap">{{ $item->price }} €</span>
    </div>
    <div class="mt-2"></div>
@endforeach

