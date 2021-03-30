<div class="flex justify-start text-base">
    @if($cart_item->editroute)
    <a href="{{ $cart_item->editroute }}" class="mr-5 text-gold-500 font-sans underline">Ändern</a>
    @endif
    <a href="#" wire:click.prevent="delete('{{ $cart_item->id }}')" class="text-gold-500 font-sans underline">Löschen</a>
</div>
