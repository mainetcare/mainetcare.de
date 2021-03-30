<div class="inline" x-data="{{ $xdata }}">
    <a
        {{ $attributes }}
        title="Klick, um Informationen in Popup anzuzeigen"
        @click.stop.prevent="open"
        x-on:keydown.escape.window="close"
        x-on:click.away="close"
    >
        {{ $label }}
    </a>

    <div
        x-cloak=""
        x-show="showpicker"
        class="z-50 fixed top-0 pointer-events-none left-0 w-full h-full items-center flex"
        style="background-color:rgba(41,47,50,0.72);"
    >

        <div class="pointer-events-auto h-full w-full sm:w-auto sm:mx-auto" style="{{ $innerstyle }}">
            <div class="bg-white border border-gray-100 overflow-y-auto">
                {{-- Header --}}
                <div class="container py-2 sm:mt-3 px-3 flex justify-between">
                    <x-svg url="/assets/layout/Logo RKB.svg" class="w-24"></x-svg>
                    <button
                        @click.prevent.stop="close()"
                        type="button"
                        class="inline-block text-gold-500 hover:text-gold-400 focus:text-gold-400 focus:outline-none"
                    >
                        <svg class="h-5 w-5 stroke-current" viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg" style="">
                            <path d="M2 2L20.5 20.5M20.5 2L2 20.5" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
                {{-- Body --}}
                <div class="sm:p-4 w-full sm:w-auto">
                    <div class="relative bg-white rounded">
                        {{ $slot }}
                    </div>
                </div>
                @if(isset($footer))
                    <div class="flex items-center justify-between p-3">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
