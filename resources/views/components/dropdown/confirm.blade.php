<div class="mt-5 flex items-center justify-between">
    @if(isset($wire) && $wire == true)
        <button x-on:click.prevent.stop="close" class="btn-out btn-flat">Abbrechen</button>
        <button wire:click.prevent.stop="submit" class="ml-4 btn btn-flat">Bestätigen</button>
    @else
        <button x-on:click.prevent.stop="reset" class="btn-out btn-flat">Abbrechen</button>
        <button x-on:click.prevent.stop="close" class="ml-4 btn btn-flat">Bestätigen</button>
    @endif
</div>
