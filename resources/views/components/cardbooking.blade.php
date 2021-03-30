<div {{ $attributes->merge(['class' => 'mb-6 bg-white overflow-auto p-6 border-gold-200 border']) }}>
    <div class="">
        <div class="grid sm:grid-cols-3 grid-cols-1 gap-6">
            <div>
                {{ $cardimage }}
            </div>
            <div class="sm:text-lg sm:col-span-2">
                <h3 class="heading4 leading-tight mt-0 text-gold-500">{{ $cardtitle }}</h3>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
