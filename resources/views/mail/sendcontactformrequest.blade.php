@component('mail::message')

# Allgemeine Kontaktanfrage
Es gibt eine neue allgemeine Kontaktanfrage von {{ config('app.name') }}

## Kontaktdaten

Name: {{ $contact->vorname }} {{ $contact->name }}\
E-Mail: {{ $contact->email }}\
Betreffzeile: {{ $contact->betreff }}\

### Mitteilung / Hinweise:
{{ $contact->hinweise }}

@endcomponent
