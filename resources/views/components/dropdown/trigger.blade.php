<button {{ $attributes->merge(['class' => 'btn btn-flat ']) }} x-on:keydown.escape.away="close" @click.prevent="open">{{ $slot ?? 'Auswählen' }}</button>
