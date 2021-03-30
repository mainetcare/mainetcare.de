<div {{ $attributes }} x-data="{
        active:false,
        togglecb() {
            this.active = ! this.active;
            $el.querySelector('input[type=checkbox]').checked=this.active;
        }
    }">
    <label for="{{ $id }}" class="flex items-start justify-start cursor-pointer inline-flex items-center" @click.prevent="togglecb">
        <input id="_{{ $id }}" name="{{ $id }}" value="" type="hidden">
        <input id="{{ $id }}" name="{{ $id }}" value=" {{ $value }}" type="checkbox" class="hidden">
        {{--  checkbox checked svg           --}}
        <svg x-cloak x-show="active" class="w-8 h-8" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="1" y="1" width="28" height="28" rx="4" stroke="#C4C4C4" stroke-width="2"/>
            <path d="M6 15.2308L11.8846 21.1154L24 9" stroke="#B38729" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        {{-- checkbox unchecked svg            --}}
        <svg x-show="!active" class="w-8 h-8 text-gray-200 @error($id) text-error-color @enderror stroke-current" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="1" y="1" width="28" height="28" rx="4" stroke-width="2"/>
        </svg>
        <span class="ml-4">{{ $slot }}</span>
    </label>
    <div>
        @error($id) <span class="inline-block mt-1 font-sans text-error-color">{!! $message !!}</span> @enderror
    </div>
</div>
