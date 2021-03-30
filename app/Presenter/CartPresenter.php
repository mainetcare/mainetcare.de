<?php

namespace App\Presenter;

use Carbon\Carbon;
use Laracasts\Presenter\Presenter;


class CartPresenter extends Presenter {


    public function vonbis() {
        $von = $this->entity->checkin;
        $bis = $this->entity->checkout;
        if(!($von instanceof Carbon && $bis instanceof Carbon)) {
            return '';
        }
        return $von->locale('de')->minDayName . $von->format(', d.m.Y') . ' – ' . $bis->locale('de')->minDayName . $bis->format(', d.m.Y');
    }

    public function gaeste() {
        return plural($this->entity->gaeste, 'Gast');
    }

    public function getPriceOfAppartement() {
        return money($this->entity->getPriceOfAppartement());
    }

    public function nights() {
        $nights = $this->entity->nights;
        return $nights == 1 ?  '1 Übernachtung' : $nights .' Übernachtungen';
    }

    public function getSumTotal() {
        return money($this->entity->getSumTotal());
    }




}

/**
 * title: 'Appartement 1 "Goldfever"'
rf: 1
updated_by: 1
updated_at: 1599297762
nickname: Goldfever
teaser: 'Luxuriöses 3 Raum Appartement im Erdgeschoss mit Terrasse. WLAN'
anzahl_raum: '3'
flaeche: '63'
aussenerweiterung: Terrasse
lage: eg
anzahl_schlafzimmer: '2'
gaeste_max: '4'
teaser_img: appartements/placeholder_app.jpg
appartementklasse: klasse-4
id: d1a48a96-1475-4e7e-a970-5c51e6891b4a
---
 */
