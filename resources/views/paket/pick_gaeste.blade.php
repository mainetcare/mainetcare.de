<div class="lg:ml-3" x-data="{
    showpicker : false,
    gaeste: {{ $gaeste }},
    max : 10,
    inc() {
        this.gaeste >= this.max ? this.max : this.gaeste += 1
    },
    dec() {
        this.gaeste <=0 ? 0 : this.gaeste -= 1
    },
    reset() {
    this.gaeste = 1;
    this.showpicker = false;
    }
    }">
    <h5 class="text-xs block font-semibold uppercase tracking-widest whitespace-no-wrap">Begleitpersonen</h5>
    <input @click="showpicker=true" x-model="gaeste" type="text" name="gaeste" wire:model.defer="gaeste" placeholder="Gäste hinzufügen"
           class="w-full px-2 text-base border border-white focus:border-gold-400 focus:outline-none">
    <div x-cloak="" x-show="showpicker" @click.away="showpicker = false" class="p-3 bg-white border border-gray-300 absolute">

        <x-stepper inc="inc" dec="dec" bindto="gaeste"><span>Wie viele Begleitpersonen?</span></x-stepper>

        <div class="mt-4 flex items-center justify-between">
            <button x-on:click.prevent="reset" class="btn btn-2 py-2">Abbrechen</button>
            <button x-on:click.prevent="showpicker=false" class="ml-5 btn">Bestätigen</button>
        </div>
    </div>
</div>
