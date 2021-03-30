<div {{ $attributes->merge(['class' => 'container relative']) }}>
    <div class="sm:w-2/3 mx-auto">
        {{ $slot }}
    </div>
</div>
