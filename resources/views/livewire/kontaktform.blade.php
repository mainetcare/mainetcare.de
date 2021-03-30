<div class="text-lg">
    @if(! $sent)
        <form wire:submit.prevent="submit(Object.fromEntries(new FormData($event.target)))" method="POST" action="">

            <div class="mt-8 grid-cols-1 sm:grid grid-cols-2 sm:gap-8 gap-4">

                <x-textinput id="name" defer>Ihr Name *</x-textinput>
                <x-textinput id="email" defer>Ihre E-Mail *</x-textinput>
                <x-textinput class="col-span-2" id="betreff" defer>Betreff</x-textinput>

            </div>

            <h3 class="sm:mt-12 heading4">Was möchten Sie uns mitteilen?</h3>

            <x-textarea id="hinweise" defer />
            <x-checkbox id="agb" withwire="model" value="agb" class="sm:mt-6 mt-4">
            <span class="">Ich stimme der
                <x-dropdown.modal
                    class="underline inline cursor-pointer hover:text-gold-600 transition-all ease-in-out duration-300"
                    label="Datenschutzerklärung"
                    innerstyle="@if(! $is_mobile) width:66.66667vw;max-height:90vh @endif"
                >
                        <iframe src="/datenschutz?modal=1" height="600" width="100%"></iframe>
                    </x-dropdown.modal>
                zu.</span>
            </x-checkbox>
            <div class="text-sm mt-4">Hinweis: Der Schutz Ihrer Daten ist uns sehr wichtig. Wenn Sie uns eine Anfrage senden, werden
                Ihre Angaben lediglich zur Kontaktaufnahme gespeichert und keinesfalls Dritten zugänglich gemacht.
                Nähere Angaben finden Sie in unserer Datenschutzerklärung.
            </div>
            <button @if($sent) disabled @endif type="submit" wire:loading.class="btn btn-disabled" class="@if($sent) btn-disabled @endif w-full mt-8 btn">Anfrage senden</button>
        </form>
    @else
        <div class="content">
            <p>Vielen Dank für Ihre Mühe. Ihre Anfrage wurde per E-Mail an uns weitergeleitet.
                Ein Mitarbeiter wird sich in Kürze bei Ihnen melden.
            </p>
            <p>Ihr Service Team von der Residenz Kubitzer Bodden</p>
        </div>
    @endif
</div>
