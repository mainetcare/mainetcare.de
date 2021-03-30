@if($cart->appartements()->count() > 0)
    <div class="mt-12">
        <h5 class="label">Appartement</h5>
        @foreach($cart->appartements() as $appartement)
            <div class="mt-2 flex items-end justify-between">
        <span class="inline-block w-3/4">
            {!! $appartement->title !!}<br>
            {!! $appartement->zimmer !!} Zimmer, {!! $appartement->lage !!}
        </span>
            </div>
        @endforeach
    </div>
@endif
