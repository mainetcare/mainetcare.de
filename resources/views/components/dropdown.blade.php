<div x-data="{ ...dropdown()@isset($add),...{{ $add }}@endif }" x-init="listen()" {{ $attributes }}>

    {{ $trigger }}

    <div
        x-cloak=""
        x-show.transition="showpicker"
        @click.away="close"
        class="mt-3 p-3 z-50 bg-white border border-gray-100 absolute text-base"
    >
        {{ $slot }}
    </div>

</div>
