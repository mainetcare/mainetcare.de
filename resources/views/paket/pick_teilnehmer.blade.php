<div class="lg:ml-3" x-data="{
    showpicker : false,
    teilnehmer: {{ $teilnehmer }},
    max : 10,
    inc() {
        this.teilnehmer >= this.max ? this.max : this.teilnehmer += 1
    },
    dec() {
        this.teilnehmer <=0 ? 0 : this.teilnehmer -= 1
    },
    reset() {
    this.teilnehmer = 1;
    this.showpicker = false;
    }
    }">
    <h5 class="text-xs block font-semibold uppercase tracking-widest whitespace-no-wrap @error( 'teilnehmer' ) text-error-color @enderror">Teilnehmer</h5>
    <input @click="showpicker=true" x-model="teilnehmer" type="text" name="teilnehmer" wire:model.defer="teilnehmer" placeholder="Gäste hinzufügen"
           class="w-full px-2 text-base border border-white focus:border-gold-400 focus:outline-none">
    <div x-cloak="" x-show="showpicker" @click.away="showpicker = false" class="p-3 bg-white border border-gray-300 absolute">

        <x-stepper inc="inc" dec="dec" bindto="teilnehmer"><span>Wie viele Teilnehmer?</span></x-stepper>

        <div class="mt-4 flex items-center justify-between">
            <button x-on:click.prevent="reset" class="btn btn-2 py-2">Abbrechen</button>
            <button x-on:click.prevent="showpicker=false" class="ml-5 btn">Bestätigen</button>
        </div>
    </div>
</div>
