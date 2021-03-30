<div
    data-panel
    x-cloak=""
    x-show="showpicker"
    @click.away="close"
    {{ $attributes->merge(['class' => 'droppanel absolute z-50 sm:p-6 p-1 bg-white border border-gold-200']) }}
>
    {{ $slot }}
    <div class="arrow" data-popper-arrow></div>
</div>
