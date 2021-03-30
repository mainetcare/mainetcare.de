<ul {{ $attributes->merge(['class' => 'leading-none list-none p-0 flex-1 flex flex-wrap justify-start']) }}>
    @foreach($items as $item)
        <li class="mt-2 inline-block border-gray-700">{{ $item }}
        @if (!$loop->last)
            <span aria-hidden="true" class="mx-1 inline-block px-1">|</span>
        @endif
        </li>
    @endforeach
</ul>
