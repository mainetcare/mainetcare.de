@if($appartement->entry->app_status == 'na')
    <p class="p-1 text-gray-600">{{ $appartement->entry->app_statusmessage }}</p>
@else
    <form method="POST" action="{{ route('appartement-select.store') }}">
        <input type="hidden" name="appartement_id" value="{{ $appartement->id }}">
        @csrf
        <button class="btn">Auswählen</button>
    </form>
    @livewire(
    'add-appartement-to-cart',
    ['appartement' => $appartement ],
    key($appartement->id)
    )
@endif

