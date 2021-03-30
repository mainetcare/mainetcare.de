<div {{ $attributes }}>
    <textarea wire:model{{ $defer }}="{{ $id }}" id="{{ $id }}" class="h-40 bg-gold-100 block mt-2 w-full border-2 border-gray-100 rounded px-3 py-4 focus:outline-none focus:border-gold-400 @error( $id ) border-error-color @enderror" ></textarea>
    @error($id) <span class="text-xs font-sans text-error-color">{{ $message }}</span> @enderror
</div>
