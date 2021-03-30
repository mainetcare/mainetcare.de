<div x-data="{ open:false }" {{ $attributes }} >

    {!! $trigger !!}

    <div x-show="open" x-cloak="" class="pt-4 z-50 h-full bg-gold-200 inset-0 fixed">

        <button
            @click.prevent.stop="open=false"
            class="py-2 w-full container flex items-center justify-end"
        >
            {{--  SVG Close --}}
            <svg class="h-5 w-5 text-gold-500 hover:text-gold-400 transition-all duration-300 stroke-current" viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg" style="">
                <path d="M2 2L20.5 20.5M20.5 2L2 20.5" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <div class="container">
            {{ $slot }}
        </div>

    </div>


</div>
