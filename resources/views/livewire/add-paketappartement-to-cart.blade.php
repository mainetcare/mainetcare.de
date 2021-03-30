<div class="" x-data="dropdown()" x-init="listen()" data-droptrig>
    <x-dropdown.trigger class="w-full">Auswählen</x-dropdown.trigger>

    <x-dropdown.panel class="text-base">

        <form wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))" method="GET" action="">

            <input type="hidden" name="appartementid" value="{{ $appartementid }}">
            <input wire:model="teilnehmer" type="hidden" name="teilnehmer">
            <input wire:model="begleitperson" type="hidden" name="begleitperson">
            <input type="hidden" name="slug" value="{{ $slug }}">

            <x-stepper dec="wire:click.prevent=dec('teilnehmer')" inc="wire:click.prevent=inc('teilnehmer')" :bindto="$teilnehmer">Wie viele Teilnehmer?</x-stepper>

            <x-stepper class="mt-6" dec="wire:click.prevent=dec('begleitperson')" inc="wire:click.prevent=inc('begleitperson')" :bindto="$begleitperson">Wie viele Begleitpersonen?</x-stepper>

            @error('capacity') <span class="inline-block px-2 bg-transparent text-xs font-sans text-error-color">{{ $message }}</span> @enderror
            @error('fail') <span class="inline-block px-2 bg-transparent text-xs font-sans text-error-color">{{ $message }}</span> @enderror


        </form>

        <x-dropdown.confirm wire="true"></x-dropdown.confirm>

    </x-dropdown.panel>

</div>

