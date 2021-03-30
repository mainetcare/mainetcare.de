<form class="" wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))" method="GET" action="">

    <x-bookingselector>

        <!-- EL1  -->
        <x-slot name="selector1">
            <div class="flex items-center" data-droptrig x-data="{...dropdown( {overlay : false }), ...teilnehmer()}">

                <x-svg url="assets/svg/person.svg" class="h-8 w-8 hidden lg:block text-gray-900"></x-svg>

                <div class="lg:ml-3 cursor-pointer" @click="open">
                    <h5 class="block label whitespace-no-wrap">Teilnehmer</h5>
                    <input x-model="teilnehmer" type="text" name="teilnehmer" wire:model.defer="teilnehmer" readonly="readonly"
                           placeholder="Teilnehmer hinzufügen"
                           @click="open"
                           class="w-full cursor-pointer focus:outline-none placeholder-gray-500">

                    <x-dropdown.panel style="max-width:350px;">
                        <x-stepper bindto="teilnehmer"><span>Wie viele Teilnehmer?</span></x-stepper>
                        <x-dropdown.confirm/>
                        <span x-show="error" class="text-xs text-gray-400 font-sans text-gray-500">
                                Wenn Sie mit mehr Personen anreisen möchten nehmen Sie bitte individuell <a class="underline" href="/kontakt/">Kontakt</a> zu uns auf.
                            </span>
                    </x-dropdown.panel>
                </div>
            </div>
        </x-slot>
        <!-- EL2  -->
        <x-slot name="selector2">
            <div class="flex items-center" data-droptrig x-data="{...dropdown( {overlay : false }), ...begleitperson()}">
                <x-svg url="assets/svg/person.svg" class="h-8 w-8 hidden lg:block text-gray-900"></x-svg>

                <div class="lg:ml-3 cursor-pointer" @click="open">
                    <h5 class="block label whitespace-no-wrap">Begleitpersonen</h5>
                    <input x-model="gaeste" type="text" name="gaeste" wire:model.defer="gaeste" readonly="readonly"
                           placeholder="Begleitperson hinzufügen"
                           @click="open"
                           class="w-full cursor-pointer focus:outline-none placeholder-gray-500">

                    <x-dropdown.panel style="max-width:350px;">
                        <x-stepper bindto="gaeste"><span>Wie viele Begleitpersonen?</span></x-stepper>
                        <x-dropdown.confirm/>
                        <span x-show="error" class="text-xs text-gray-400 font-sans text-gray-500">
                                Wenn Sie mit mehr Personen anreisen möchten nehmen Sie bitte individuell <a class="underline" href="/kontakt/">Kontakt</a> zu uns auf.
                            </span>
                    </x-dropdown.panel>
                </div>
            </div>
        </x-slot>
        <!-- EL3  -->
        <x-slot name="selector3">
            <div class="flex items-center">
                <x-svg url="assets/svg/calendar.svg" class="h-8 w-8 hidden lg:block text-gray-900"></x-svg>

                <div class="lg:ml-3">
                    <h5 class="block label whitespace-no-wrap">Check-In</h5>
                    <input id="checkin" readonly="readonly" wire:model.defer="checkin" name="checkin" placeholder="Reisedaten hinzufügen"
                           class="w-full cursor-pointer focus:outline-none focus:border-gold-400 placeholder-gray-500"
                    />
                </div>
            </div>
        </x-slot>

        <!-- EL4  -->
        <x-slot name="action">
            <button class="w-full rounded-none sm:rounded block btn btn-flat @if($size == 'small') lg:px-8 @else lg:px-16 @endif">Suchen</button>
        </x-slot>


    </x-bookingselector>

    <!-- EL 4 -->

    {{--  FORM END               --}}
    @error('checkin')
    <x-errormessage>{{ $message }}</x-errormessage>@enderror
    @error('teilnehmer')
    <x-errormessage>{{ $message }}</x-errormessage>@enderror
    @error('bookable_persons')
    <x-errormessage>Wenn Sie mit mehr als 2 Personen anreisen möchten nehmen Sie bitte individuell <a class="underline" href="/kontakt/">Kontakt</a> zu uns auf.
    </x-errormessage>@enderror
</form>
@push('scripts')
    <script>
        window.teilnehmer = function () {
            return {
                showpicker: false,
                teilnehmer: '{{ $teilnehmer }}',
                max: 2,
                error: false,
                inc() {
                    if (typeof this.teilnehmer === 'string' || this.gaeste instanceof String) {
                        this.teilnehmer = 0;
                    }
                    if (this.teilnehmer >= this.max) {
                        this.teilnehmer = this.max;
                        this.error = true;
                    } else {
                        this.teilnehmer += 1;
                    }
                },
                dec() {
                    this.error = false;
                    if (typeof this.teilnehmer === 'string' || this.gaeste instanceof String) {
                        this.teilnehmer = 0;
                    }
                    this.teilnehmer <= 0 ? 1 : this.teilnehmer -= 1
                },
                reset() {
                    this.showpicker = false;
                }
            }
        };
        window.begleitperson = function () {
            return {
                showpicker: false,
                gaeste: '{{ $gaeste }}',
                max: 2,
                error: false,
                inc() {
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
                    this.showpicker = false;
                }
            }
        }

        let el = document.getElementById('checkin');
        if (el) {
            let picker = new Litepicker({
                element: document.getElementById('checkin'),
                format: 'DD.MM.YYYY',
                singleMode: true,
                lang: 'de-DE',
                minDate: '{{ $min_date }}',
                lockDaysFormat: 'DD.MM.YYYY',
                lockDays: [['01.12.2020', '27.05.2021']],
                startDate: '{{ $start_date_picker }}',
                mobileFriendly: true,
                numberOfMonths: 1,
                numberOfColumns: 1
            });
        }
    </script>
@endpush
