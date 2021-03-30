<?php

namespace App\Jobs;

use App\Exceptions\PriceException;
use App\Models\Angebot;
use App\Models\Appartement;
use App\Models\Cart;
use App\Models\EntryModel;
use App\Models\Paket;
use App\Services\AngebotPriceCalculator;
use App\Services\AppartementPriceCalculator;
use App\Services\BulkPrices;
use App\Services\SaisonManager;
use Carbon\CarbonPeriod;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class ProcessInitPaketInCart {

    /**
     * @var Paket
     */
    protected $paket;
    /**
     * @var Cart
     */
    protected $cart;


    /**
     * @var Carbon | null
     */
    protected $checkin = null;
    protected $checkout = null;

    protected $teilnehmer = 0;
    protected $gaeste = 0;

    /**
     * ProcessAddPaketToCart constructor.
     *
     * @param array $arrSelection
     */
    public function __construct( array $arrSelection ) {
        $this->paket      = $arrSelection['paket'];
        $this->cart       = $arrSelection['cart'];
        $this->checkin    = $arrSelection['checkin'];
        $this->gaeste     = $arrSelection['gaeste'];
        $this->teilnehmer = $arrSelection['teilnehmer'];
        $this->amount     = 1;

    }

    /**
     * Execute the job.
     * initialize: we have
     *
     * @return void
     */
    public function handle() {

        $nights         = $this->paket->nights;
        $this->checkout = $this->checkin->copy()->addDays( $nights );
        $this->cart->update( [
            'gaeste'     => $this->gaeste,
            'checkin'    => $this->checkin,
            'checkout'   => $this->checkout,
            'teilnehmer' => $this->teilnehmer,
        ] );

        $content = plural( $nights, 'Übernachtung' ) . ' für ' . plural( $this->teilnehmer, 'Teilnehmer' );
        if ( $this->gaeste > 0 ) {
            $content .= ' und ' . plural( $this->gaeste, 'Begleitperson' );
        }

        $this->cart->updateOrCreateItem( [
            'model'   => $this->paket,
            'title'   => $this->paket->title,
            'unit'    => '',
            'content' => $content,
            'amount'  => $this->amount,
            'total'   => 0,
        ] );

    }

}
