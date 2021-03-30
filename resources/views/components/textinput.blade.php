<div {{ $attributes }}>
    <label for="{{$id}}" class="block text-gray-500">{{ $slot }}</label>
    <input id="{{ $id }}" type="text" class="bg-gold-100 block sm:mt-2 w-full border-2 border-gray-100 rounded px-3 sm:py-4 py-2 focus:outline-none focus:border-gold-400 @error( $id ) border-error-color @enderror" wire:model{{ $defer }}="{{ $id }}">
    @error($id) <span class="inline-block mt-2 font-sans text-error-color">{{ $message }}</span> @enderror
</div>
