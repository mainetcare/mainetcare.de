<div>
    <input type="hidden" wire:model="appartement_id"/>

    @if ($errors->any())
        <div class="bg-red-100 p-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-error-color text-lg">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="p-4 bg-gray-100">
        <h3 class="py-2 font-semibold">Neue Sperrzeit hinzufügen:</h3>
        <div class="grid grid-cols-4 flex items-center justify-between">
            <div>
                <label for="newvon">Von:</label>
                <input class="px-3 py-2" type="date" id="newvon" wire:model.defer="new.von">
            </div>
            <div>
                <label for="newbis">Bis:</label>
                <input class="px-3 py-2" type="date" id="newbis" wire:model.defer="new.bis">
            </div>
            <div>
                <label for="new-status-select">Status:</label>

                <select class="px-3 py-2" wire:model.defer="new.status" name="status" id="new-status-select">
                    <option value="">--Bitte wählen--</option>
                    <option value="reserviert">Reserviert</option>
                    <option value="gebucht">Gebucht</option>
                    <option value="manuell">Manuell</option>
                </select>
            </div>
            <div class="justify-self-center">
                <button wire:click="newPeriod" class="btn btn-flat">Neue Sperrzeit</button>
            </div>
        </div>
    </div>

    <h3 class="py-2 font-semibold">Bisherige Sperrzeiten:</h3>

    @foreach($sperrzeiten as $key => $sperrzeit)
        <div class="grid grid-cols-4 flex items-center justify-between">
            <div class="">
                <label>Von:</label>
                <input class="px-3 py-2" type="date" wire:model.defer="sperrzeiten.{{ $key }}.start">
            </div>
            <div class="">
                <label>Bis:</label>
                <input class="px-3 py-2" type="date" wire:model.defer="sperrzeiten.{{ $key }}.end">
            </div>
            <div class="">
                <label>Status:</label>
                <select class="bg-gold-100 px-3 py-2" wire:model.defer="sperrzeiten.{{ $key }}.reason" name="status">
                    <option value="">--Bitte wählen--</option>
                    <option value="reserviert">Reserviert</option>
                    <option value="gebucht">Gebucht</option>
                    <option value="manuell">Manuell</option>
                </select>
            </div>
            <div class="w-full justify-self-center">
                <div class="flex items-center justify-between">
                    <button wire:click="updateSperrzeit( '{{ $key }}' )" class="btn btn-flat">Update</button>
                    <button onclick="confirm('Sind Sie sicher?') || event.stopImmediatePropagation()" wire:click="deleteSperrzeit('{{ $key }}')" class="btn btn-flat">Löschen</button>
                </div>
            </div>
        </div>
        <x-divider/>

    @endforeach


</div>
