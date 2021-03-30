<form class="" wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))" method="GET" action="">
    <x-bookingselector>
        {{--   EL1     --}}
        <x-slot name="selector1">
            <div class="flex items-center" data-droptrig x-data="{...dropdown( {overlay : false }), ...initappartement()}">

                <x-svg url="assets/svg/person.svg" class="h-8 w-8 block sm:hidden lg:block text-gray-900"></x-svg>

                <div class="lg:ml-3">

                    <h5 class="block label whitespace-no-wrap">Gäste</h5>
                    <input @click="open" x-model="gaeste" type="text" name="gaeste" wire:model.defer="gaeste" readonly="readonly"
                           placeholder="Gäste hinzufügen"
                           class="cursor-pointer w-full focus:outline-none placeholder-gray-500">

                    <x-dropdown.panel style="max-width:350px;">
                        <x-stepper bindto="gaeste"><span>Wie viele Gäste?</span></x-stepper>
                        <x-dropdown.confirm/>
                        <span x-show="error" class="text-xs text-gray-400 font-sans text-gray-500">
                            Unsere Appartements haben eine Kapazität von bis zu 4 Personen. Wenn Sie mit mehr Personen anreisen möchten,
                            nehmen Sie bitte individuell <a class="underline" href="/kontakt/">Kontakt</a> zu uns auf.
                        </span>
                    </x-dropdown.panel>

                </div>

            </div>
        </x-slot>
        {{--   EL2     --}}
        <x-slot name="selector2">
            <div class="flex items-center">
                <x-svg url="assets/svg/calendar.svg" class="h-8 w-8 block sm:hidden lg:block text-gray-900"></x-svg>
                <div class="lg:ml-3">
                    <h5 class="block label whitespace-no-wrap">Check-In</h5>
                    <input id="checkin" readonly="readonly" wire:model.defer="checkin" name="checkin" placeholder="Reisedaten hinzufügen"
                           class="cursor-pointer w-full focus:outline-none focus:border-gold-400 placeholder-gray-500"
                    />
                </div>
            </div>
        </x-slot>
        {{--   EL3     --}}
        <x-slot name="selector3">
            <div class="flex items-center">

                <x-svg url="assets/svg/calendar.svg" class="h-8 w-8 block sm:hidden lg:block text-gray-900"></x-svg>

                <div class="lg:ml-3">
                    <h5 class="block label whitespace-no-wrap">Check-Out</h5>
                    <input id="checkout" readonly="readonly" wire:model.defer="checkout" placeholder="Reisedaten hinzufügen" name="checkout"
                           class="cursor-pointer w-full focus:outline-none focus:border-gold-400 placeholder-gray-500"
                    />
                </div>
            </div>
        </x-slot>
        <x-slot name="action">
            <button class="w-full block rounded-none sm:rounded btn btn-flat @if($size == 'small') lg:px-8 @else lg:px-16 @endif">Suchen</button>
        </x-slot>
    </x-bookingselector>

    @error('checkin')
    <div class="bg-gold-200 w-full pt-4 px-4">
        <x-errormessage>{{ $message }}</x-errormessage>
    </div>
    @enderror
    @error('checkout')
    <div class="bg-gold-200 w-full pt-4 px-4">
        <x-errormessage>{{ $message }}</x-errormessage>
    </div>
    @enderror
    @error('gaeste')
    <div class="bg-gold-200 w-full py-4 px-4">
        <x-errormessage>{{ $message }}</x-errormessage>
    </div>
    @enderror


</form>



@push('scripts')
    <script>
        window.initappartement = function () {
            return {
                showpicker: false,
                gaeste: '{{ $gaeste }}',
                error: false,
                max: 4,
                inc() {
                    this.error = false;
                    if (typeof this.gaeste === 'string' || this.gaeste instanceof String) {
                        this.gaeste = 0;
                    }
                    if (this.gaeste >= this.max) {
                        this.gaeste = this.max;
                        this.error = true;
                    } else {
                        this.gaeste += 1;
                    }
                },
                dec() {
                    this.error = false;
                    if (typeof this.gaeste === 'string' || this.gaeste instanceof String) {
                        this.gaeste = 0;
                    }
                    this.gaeste <= 0 ? 1 : this.gaeste -= 1
                },
                reset() {
                    this.error = false;
                    this.showpicker = false;
                }
            }
        }
        @if(! $is_mobile)
        let el = document.getElementById('checkin');
        if (el) {
            let picker = new Litepicker({
                element: document.getElementById('checkin'),
                elementEnd: document.getElementById('checkout'),
                minDate: '{{ $min_date }}',
                minDays: 2,
                singleMode: false,
                lang: 'de-DE',
                format: 'DD.MM.YYYY',
                lockDaysFormat: 'DD.MM.YYYY',
                lockDays: [['01.01.2020', '28.05.2021']],
                startDate: '{{ $start_date_picker }}',
                endDate: '{{ $end_date_picker }}',
                mobileFriendly: true,
                numberOfMonths: 2,
                numberOfColumns: 2
            });
        }
            @else
            let checkin = document.getElementById('checkin');
            let checkout = document.getElementById('checkin');
            if (checkin) {
                let picker_checkin = new Litepicker({
                    element: document.getElementById('checkin'),
                    minDate: '{{ $min_date }}',
                    minDays: 2,
                    singleMode: true,
                    lang: 'de-DE',
                    format: 'DD.MM.YYYY',
                    lockDaysFormat: 'DD.MM.YYYY',
                    lockDays: [['01.01.2020', '27.05.2021']],
                    startDate: '{{ $start_date_picker }}',
                    endDate: '{{ $end_date_picker }}',
                    mobileFriendly: true,
                    numberOfMonths: 1,
                    numberOfColumns: 1
                });
            }
            if (checkout) {
                let picker_checkout = new Litepicker({
                    element: document.getElementById('checkout'),
                    minDate: '{{ $min_date }}',
                    minDays: 2,
                    singleMode: true,
                    lang: 'de-DE',
                    format: 'DD.MM.YYYY',
                    lockDaysFormat: 'DD.MM.YYYY',
                    lockDays: [['01.01.2020', '27.05.2021']],
                    startDate: '{{ $start_date_picker }}',
                    endDate: '{{ $end_date_picker }}',
                    mobileFriendly: true,
                    numberOfMonths: 1,
                    numberOfColumns: 1
                });
            }
        @endif

    </script>
@endpush

