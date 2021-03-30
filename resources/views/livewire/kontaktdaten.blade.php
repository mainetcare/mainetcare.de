<div class="sm:text-lg">
    <form wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))" method="POST" action="">

        <h3 class="hidden sm:inline-block sm:mt-8 mt-0 heading4">Kontaktinfo</h3>

        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 sm:gap-8 gap-4">

            <x-textinput id="vorname" defer>Vorname</x-textinput>
            <x-textinput id="name" defer>Name *</x-textinput>
            <x-textinput id="telefon" defer>Telefonnummer</x-textinput>
            <x-textinput id="email" defer>E-Mail *</x-textinput>

        </div>

        <h3 class="sm:mt-12 mt-6 heading4">Adresse</h3>

        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-8">

            <x-textinput class="sm:col-span-2" id="strasse" defer>Straße und Hausnummer *</x-textinput>
            <x-textinput  id="plz" defer>Plz *</x-textinput>
            <x-textinput  id="ort" defer>Ort *</x-textinput>

        </div>

        <h3 class="sm:mt-12 mt-6 heading4 leading-tight">Besondere Wünsche und Anliegen</h3>
        {{--        <label for="hinweise" class="block text-xs">Bitte geben Sie hier besondere Wünsche und Anliegen ein</label>--}}
        <x-textarea  id="hinweise" defer />
        <x-checkbox id="agb" withwire="model" value="agb" class="mt-6">
            <span class="">Ich stimme den
                <x-dropdown.modal
                    class="underline inline cursor-pointer hover:text-gold-600 transition-all ease-in-out duration-300"
                    label="AGB"
                    innerstyle="width:66.66667vw;max-height:90vh"
                >
                        <iframe src="/agb?modal=1" height="600" width="100%"></iframe>
                    </x-dropdown.modal>
                und der <x-dropdown.modal
                    class="underline inline cursor-pointer hover:text-gold-600 transition-all ease-in-out duration-300"
                    label="Datenschutzerklärung"
                    innerstyle="width:66.66667vw;max-height:90vh"
                >
                        <iframe src="/datenschutz?modal=1" height="600" width="100%"></iframe>
                    </x-dropdown.modal>
                zu.</span>
        </x-checkbox>
        <button type="submit" class="w-full my-8 btn">Zusammenfassung anzeigen</button>
    </form>
</div>
