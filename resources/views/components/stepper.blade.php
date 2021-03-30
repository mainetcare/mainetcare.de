<div {{ $attributes->merge(['class' => 'grid grid-cols-2 items-center justify-between']) }}>
    {{ $slot }}
    <div class="ml-8 flex items-center justify-between">
        @if($framework == 'alpine')
            <button x-on:click.prevent="{{ $dec }}">
                <x-svg url="assets/svg/stepper_minus.svg" x-bind:class="{ 'text-gray-600': {{ $bindto }} > 0 }" class="w-8 h-8 text-gray-200 stroke-current"/>
            </button>
            <span class="mx-3 text-center inline-block" x-text="{{ $bindto }}" style="min-width:20px;">0</span>
            <button x-on:click.prevent="{{ $inc }}">
                <x-svg url="assets/svg/stepper_plus.svg" x-bind:class="{ 'text-gray-600': {{ $bindto }} < 8 }" class="w-8 h-8 text-gray-200 stroke-current"/>
            </button>
        @elseif($framework == 'livewire')
            <button {{ $dec }}>
                <x-svg url="assets/svg/stepper_minus.svg" x-bind:class="{ 'text-gray-600': {{ $bindto }} > 0 }" class="w-8 h-8 text-gray-200 stroke-current"/>
            </button>
            <span class="mx-3 text-center inline-block" style="min-width:20px;">{{ $bindto }}</span>
            <button {{ $inc }}>
                <x-svg url="assets/svg/stepper_plus.svg" x-bind:class="{ 'text-gray-600': {{ $bindto }} < 8 }" class="w-8 h-8 text-gray-200 stroke-current"/>
            </button>
        @else
        <!-- No Framework defined -->
        @endif
    </div>
</div>
