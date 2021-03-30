@if($rabatt)
    <div
        x-data="dropdown({showpicker : true})"
    >
        <div class="w-100 py-2 bg-gold-900" x-show="showpicker">
            <div class="leading-none sm:text-lg text-sm text-gold-500 container flex items-center justify-between">
                <x-dropdown.modal>
                    <x-slot name="label">
                            <span class="inline-block cursor-pointer">{{ $rabatt->title }}: {{ $rabatt->entry->get('subtitle') }}
                                <svg class="hidden inline-block w-8 h-8 mr-4 text-gold-700 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                 d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                    </x-slot>
                    <div class="p-4">
                        <h3 class="heading4 mt-0 font-semibold text-gold-500">{{ $rabatt->title }}</h3>
                        <div class="text-gray-900 leading-normal">
                            @include('partials._teaser', ['teaser' => $rabatt->entry->augmentedValue('teaser')->value()])
                        </div>
                    </div>
                </x-dropdown.modal>
                <button
                    @click.prevent.stop="close(); $nextTick( () => { window.calcHeader() } )"
                    type="button"
                    class="px-1 inline-block text-gold-500 hover:text-gold-400 transition-all duration-300 focus:text-gold-400 focus:outline-none"
                >
                    <svg class="h-5 w-5 stroke-current" viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg" style="">
                        <path d="M2 2L20.5 20.5M20.5 2L2 20.5" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif
@push('styles')
    <style type="text/css">
        .rabatt {

        }
    </style>
@endpush
{{--
 <x-dropdown.modal
                    class="underline inline cursor-pointer hover:text-gold-600 transition-all ease-in-out duration-300"
                    label="AGB"
                >
                        <iframe src="/agb?modal=1" height="600" width="100%"></iframe>
                    </x-dropdown.modal>
                und der <x-dropdown.modal
                    class="underline inline cursor-pointer hover:text-gold-600 transition-all ease-in-out duration-300"
                    label="Datenschutzerklärung"
                >
                        <iframe src="/datenschutz?modal=1" height="600" width="100%"></iframe>
                    </x-dropdown.modal>

--}}
