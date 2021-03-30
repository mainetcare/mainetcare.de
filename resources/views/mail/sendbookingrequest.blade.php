@component('mail::message')

# Buchungsanfrage
Es gibt eine neue Buchungsanfrage von  {{ config('app.name') }}
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
## Kontaktdaten

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
@endcomponent
