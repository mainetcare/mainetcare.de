<div {{ $attributes->merge([
    'class' => 'px-4 py-4 flex items-center justify-center'
    ]) }}>
    <div class="flex items-center justify-center">
        {{ $slot }}
    </div>
</div>
