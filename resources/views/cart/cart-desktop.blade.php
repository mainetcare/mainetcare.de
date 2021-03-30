@if(!$cart->isEmpty())
    <div class="z-50 flex flex-col bg-gold-200 text-lg h-screen-1/2 overflow-y-auto" style="min-height:200px;">
        <div class="flex-grow flex flex-col">
            {{--  Oberer Teil --}}
            <div class="flex-grow">
                <div class="p-6 rounded ">
                    <h5 class="heading4 mt-0">Ihre Anfrage</h5>
                    <div class="text-gray-900 mt-5">
                        {!! $cart->present()->vonbis() !!}
                    </div>
                    @if($paket = $cart->pakete()->first())
                        <div class="mt-2">
                            Urlaubspaket "{{ $paket->title }}"
                            <div class="mt-1 text-gray-900">
                                <span class="whitespace-no-wrap">{{ plural( $cart->nights, 'Übernachtung' ) }}</span> für <span
                                    class="whitespace-no-wrap"> {{ plural( $cart->teilnehmer, 'Teilnehmer' ) }}</span>
                                @if($cart->gaeste > 0)
                                    und <span class="whitespace-no-wrap">{{ plural( $cart->gaeste, 'Begleitperson' ) }}</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="mt-1 text-gray-900">
                            {{ $cart->present()->nights() }} für {{ $cart->present()->gaeste() }}
                        </div>
                    @endif
                    <div class="mt-10 w-full flex justify-between">
                        <div class="w-1/2">
                            <span class="label">Check-In</span><br>
                            <span class="">Ab 15:00 Uhr</span>
                        </div>
                        <div class="w-1/2 ml-1">
                            <span class="label">Check-Out</span><br>
                            <span class="">Vor 12:00 Uhr</span>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    @include('cart.appartement')
                    @include('cart.angebote')
                </div>
            </div>
            {{--  Unterer Teil --}}
            <div class="">
                <x-divider/>
                <div class="px-6 pb-5 flex items-center justify-between font-sans font-medium text-xlg">
                    <span class="inline-block">Gesamtbetrag</span>
                    <span class="text-right inline-block ml-3 whitespace-no-wrap">{{ euro($cart->getSumTotal()) }}</span>
                </div>
            </div>
        </div>
    </div>
    @if($remaining->get('all') > 0)
        @if(booking_session() instanceof \App\Services\BookingSessions\BookingSessionAppartement)
            <div class="pt-4 text-sm">
                Vor dem nächsten Schritt bitte erst ein <a class="underline text-gold-500" href="{{ route('appartement-select.index') }}">Appartement wählen</a>
            </div>
        @else
            <div class="pt-4 text-sm">
                <div class="p-3 text-xs">Vor dem nächsten Schritt bitte noch für {{ plural($remaining->get('all'),'Person') }} Appartement(s) wählen</div>
            </div>
        @endif
    @endif
@else
    <p>Der Warenkorb ist leer</p>
@endif

