<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends MncModel {

    const ORIGIN_CONTACTFORM = 'contactform';

    protected $fillable = [
        'vorname',
        'name',
        'telefon',
        'email',
        'strasse',
        'adresszusatz',
        'plz',
        'ort',
        'newsletter',
        'hinweise',
        'origin',
        'betreff',
        'sent_at'
    ];

    protected $dates = [
        'sent_at'
    ];

    public function setSent() {
        $this->update( [
                'sent_at' => now()
            ]
        );
    }


}
