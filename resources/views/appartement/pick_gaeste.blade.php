<div class="lg:ml-3" x-data="{
    showpicker : false,
    gaeste: '{{ $gaeste }}',
    max : 10,
    inc() {
    if (typeof this.gaeste === 'string' || this.gaeste instanceof String) {
        this.gaeste = 0;
    }
        this.gaeste >= this.max ? this.max : this.gaeste += 1
    },
    dec() {
    if (typeof this.gaeste === 'string' || this.gaeste instanceof String) {
        this.gaeste = 0;
    }
        this.gaeste <=0 ? 1 : this.gaeste -= 1
    },
    reset() {
    this.gaeste = 1;
    this.showpicker = false;
    }
    }">
    <h5 class="label whitespace-no-wrap">Gäste</h5>
    <input @click="showpicker=true" x-model="gaeste" type="text" name="gaeste" wire:model.defer="gaeste" readonly="readonly" placeholder="Gäste hinzufügen"
           class="cursor-pointer w-full text-base focus:outline-none placeholder-gray-500">
    <div x-cloak="" x-show="showpicker" @click.away="showpicker = false" class="p-6 mt-5 bg-white border border-gold-100 absolute">

        <x-stepper inc="inc" dec="dec" bindto="gaeste"><span>Wie viele Gäste?</span></x-stepper>

        <div class="mt-5 flex items-center justify-between">
            <button x-on:click.prevent="reset" class="btn-out">Abbrechen</button>
            <button x-on:click.prevent="showpicker=false" class="ml-4 btn">Bestätigen</button>
        </div>
    </div>
</div>
