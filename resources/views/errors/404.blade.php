@extends(app('request')->input('modal') == "1" ? '_layouts.modal' : 'layout')
@section('content')
    <x-container-narrow>
        <div class="mt-24 content">
            <h1 class="heading1">404</h1>
            <p>Sehr geehrter Besucher. Die aufgerufenene Seite konnte nicht gefunden werden.</p>
            <p><a class="block mt-6 label" href="/">Weiter zur Startseite...</a></p>
        </div>
    </x-container-narrow>
@endsection
