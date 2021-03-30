<?php

namespace App\Jobs;

use App\Models\Appartement;
use App\Models\Cart;
use App\Models\Paket;
use App\Models\Rabatt;
use App\Services\DiscountCalculator;
use App\Services\PaketPriceCalculator;
use App\Services\SaisonManager;

class ProcessAddPaketAppartementToCart {

    /**
     * @var Paket
     */
    protected $paket;

    /**
     * @var Cart
     */
    protected $cart;


    /**
     * @var Appartement
     */
    protected $appartement = null;

    /**
     * @var int
     */
    protected $teilnehmer;

    /**
     * @var int
     */
    protected $begleitperson;

    /**
     * @var null | Rabatt
     */
    protected $rabatt = null;

    /**
     * @var bool
     */
    protected $is_hs = true;

    /**
     * @var null | PaketPriceCalculator
     */
    protected $calculator = null;


    /**
     * ProcessAddPaketToCart constructor.
     *
     * @param array $arrSelection
     */
    public function __construct( array $arrSelection ) {

        $this->cart          = $arrSelection['cart'];
        $this->paket         = $arrSelection['paket'];
        $this->appartement   = $arrSelection['appartement'];
        $this->teilnehmer    = $arrSelection['teilnehmer'];
        $this->begleitperson = $arrSelection['begleitperson'];
        $this->is_hs         = app( SaisonManager::class )->isInHauptsaison( $this->cart->getPeriod() );
        $this->calculator    = app( PaketPriceCalculator::class )->input(
            $this->paket,
            $this->appartement->appartementklasse,
            $this->teilnehmer,
            $this->begleitperson,
            $this->is_hs
        );

        if ( isset ( $arrSelection['rabatt'] ) ) {
            $this->rabatt = $arrSelection['rabatt'];
        }

    }

    protected function getTotal() {
        if ( $this->rabatt ) {
            $discount_calculator = new DiscountCalculator( $this->calculator, $this->rabatt );

            return $discount_calculator->getTotal();
        }

        return $this->calculator->getTotal();
    }

    /**
     * Execute the job.
     * initialize: we have
     *
     * @return void
     */
    public function handle() {


        $data = [
            'sum'           => $this->teilnehmer + $this->begleitperson,
            'teilnehmer'    => $this->teilnehmer,
            'begleitperson' => $this->begleitperson
        ];

        $this->cart->updateOrCreateItem( [
            'model'     => $this->appartement,
            'title'     => $this->appartement->title,
            'unit'      => '',
            'content'   => $this->getContent(),
            'amount'    => 1,
            'total'     => $this->getTotal(),
            'editroute' => route( 'paket-select.index' ),
            'data'      => [ 'persons' => $data ]
        ] );

    }

    protected function getContent() {
        $arrC = [];

        if ( $this->teilnehmer > 0 ) {
            $arrC[] = plural( $this->teilnehmer, 'Teilnehmer' );
        }

        if ( $this->begleitperson > 0 ) {
            $arrC[] = plural( $this->begleitperson, 'Begleitperson' );
        }

        $content = 'Für ' . implode( ' und ', $arrC );

        if ( $this->calculator->is_ez() ) {
            $content .= ' (EZ)';
        }

        $content .= ". ";

        if ( $this->rabatt ) {
            $content .= '-' . $this->rabatt->getDiscountPercent() . '% Aktion ' . $this->rabatt->title;
        }

        return $content;
    }

}
