<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AngebotGruppe extends Model {

    const KEY_TAX = 'angebotsgruppe';

    public static $gruppe_sauna = 'sauna';
    public static $gruppe_sportkurse = 'sportkurse';
    public static $gruppe_pferdepension = 'pferdepension';
    public static $gruppe_gefuehrte_ausritte = 'gefuehrte-ausritte';

}
