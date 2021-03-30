@component('mail::message')

# Sehr geehrt(e) {{ $contact->vorname }} {{ $contact->name }},

wir freuen uns sehr, dass Sie sich für einen Urlaub bei uns auf der Residenz Kubitzer Bodden entschieden haben.
Ihre Anfrage ist mit folgenden Daten an unser Service-Team weitergeleitet worden:

Zeitraum: {{ $cart->present()->vonbis() }}

@if($paket = $cart->pakete()->first())
Urlaubspaket: {{ $paket->title }}
{{ plural( $cart->nights, 'Übernachtung' ) }}
{{ plural( $cart->teilnehmer, 'Teilnehmer' ) }}
@if($cart->gaeste > 0) und {{ plural( $cart->gaeste, 'Begleitperson' ) }}@endif
@else
{{ $cart->present()->nights() }} für {{ $cart->present()->gaeste() }}
@endif

@if($cart->appartements()->count() > 0)
## {{ plural($cart->appartements()->count(), 'Appartement') }}
@foreach($cart->appartements() as $appartement)

{{ $appartement->title }} {{ $appartement->zimmer }} Zimmer, {{ $appartement->lage }}\
@if($appartement->cart_item->content)
{!! $appartement->cart_item->content !!}
@endif


Preis: {{ euro($appartement->cart_item->total) }}
@endforeach
@endif


@foreach($cart->erlebniswelten() as $erlebniswelt)
@if(count($erlebniswelt['list']) > 0)

---

## {{ $erlebniswelt['title'] }}

@foreach($erlebniswelt['list'] as $angebot)

* {{ $angebot->cart_item->title }} {{ $angebot->cart_item->content }}: {!! nbsp(euro($angebot->cart_item->total))  !!}



@endforeach

@endif
@endforeach

---

## Komplettpreis: {{ euro($cart->getSumTotal()) }}

---

@if($contact = $cart->contact)
## Ihre Kontaktangaben:

{{ $contact->vorname }} {{ $contact->name }}\
@isset($contact->telefon)
Tel.: {{ $contact->telefon }}\
@endisset
{{ $contact->email }}\
{{ $contact->strasse }} {{ $contact->adresszusatz }}\
{{ $contact->plz }} {{ $contact->ort }}

### Sonstige Hinweise
{{ $contact->hinweise }}
@endif

### Bitte beachten Sie:

Diese E-Mail ist eine automatische Antwort zu Ihrer Anfrage. Bitte überprüfen Sie Ihre Angaben und benachrichtigen
Sie uns schnellstmöglich sollte etwas korrigiert werden.<br>
In Kürze erhalten Sie von unserem Service-Team die Bestätigung Ihrer Buchung mit den Zahlungsangaben.

@endcomponent
