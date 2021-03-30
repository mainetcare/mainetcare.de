<div class="w-full" x-data="dropdown()" x-init="listen()" data-droptrig>

    <x-dropdown.trigger class="w-full">Auswählen</x-dropdown.trigger>

    <x-dropdown.panel class="text-base">
        <form wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))">

            <input type="hidden" name="appartementid" value="{{ $appartement_id }}">
            <input wire:model="gaeste" type="hidden" name="gaeste">

            <x-stepper dec="wire:click.prevent=dec('gaeste')" inc="wire:click.prevent=inc('gaeste')" :bindto="$gaeste">Wie viele Gäste?</x-stepper>

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <span class="inline-block px-2 bg-transparent text-xs font-sans text-error-color">{{ $error }}</span>
                @endforeach
            @endif

            <x-dropdown.confirm wire="true"></x-dropdown.confirm>

        </form>
    </x-dropdown.panel>

</div>


