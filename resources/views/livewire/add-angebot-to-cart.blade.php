<div class="lg:ml-3" x-data="{...dropdown(), ...addangebot()}" data-droptrig>
    <form wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))" method="GET" action="">
        <input type="hidden" name="entry_id" value="{{ $entry_id }}">
        <input x-model="multiplier" type="hidden" name="multiplier">
        <input x-model="amount" type="hidden" name="amount">
        <input type="hidden" name="unit" value="{{ $unit }}">
        <input type="hidden" name="variant" value="{{ $variant }}">

        <x-dropdown.trigger class="w-full sm:w-auto">Auswählen</x-dropdown.trigger>
        <x-dropdown.panel>

            @if($has_multiplier)
                <x-stepper inc="incmultiplier" dec="decmultiplier" bindto="multiplier"><span class="">{{ $multiplier_label }}</span></x-stepper>
                <x-divider/>
            @endif

            <x-stepper inc="incamount" dec="decamount" bindto="amount"><span class="">{{ $angebot->present()->selectunit($unit) }}?</span></x-stepper>

            <div class="mt-4 flex items-center justify-between">
                <button x-on:click.prevent="close" class="btn btn-out btn-flat">Abbrechen</button>
                <button @click="close" type="submit" class="ml-4 btn btn-flat">Bestätigen</button>
            </div>

        </x-dropdown.panel>
    </form>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <span class="inline-block px-2 bg-transparent text-xs font-sans text-error-color">{{ $error }}</span>
        @endforeach
    @endif
</div>
@once
    @push('scripts')
        <script>
            window.addangebot = function () {
                return {
                    max_multiplier: {{ $max_multiplier }},
                    multiplier: {{ $default_multiplier }},
                    amount: {{ $default_amount }},
                    max_amount: {{ $max_amount }},
                    incmultiplier() {
                        this.multiplier >= this.max_multiplier ? this.max_multiplier : this.multiplier += 1;
                    },
                    decmultiplier() {
                        this.multiplier <= 1 ? 1 : this.multiplier -= 1
                    },
                    incamount() {
                        this.amount >= this.max_amount ? this.max_amount : this.amount += 1
                    },
                    decamount() {
                        this.amount <= 1 ? 1 : this.amount -= 1
                    }
                }
            }
        </script>
    @endpush
@endonce
