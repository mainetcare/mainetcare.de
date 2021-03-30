@if($contact = $cart->contact)

    <ul class="mt-4">
        <li>
            {{ $contact->vorname }} {{ $contact->name }}
        </li>
        @isset($contact->telefon)
            <li>
                Tel.: {{ $contact->telefon }}
            </li>
        @endisset
        <li>
            {{ $contact->email }}
        </li>
        <li class="mt-2">
            {{ $contact->strasse }} {{ $contact->adresszusatz }}
        </li>
        <li>
            {{ $contact->plz }} {{ $contact->ort }}
        </li>
        <li class="mt-3">
            {{ nl2br($contact->hinweise) }}
        </li>
    </ul>

@endif

