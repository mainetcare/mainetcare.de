<?php

namespace App\Jobs;

use App\Exceptions\PriceException;
use App\Models\Appartement;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Rabatt;
use App\Services\AppartementPriceCalculator;
use App\Services\DiscountCalculator;
use App\Services\SaisonManager;

class ProcessAddAppartementToCart {

    /**
     * @var Appartement
     */
    protected $appartement;
    /**
     * @var Cart
     */
    protected $cart;

    /**
     * @var mixed
     */
    protected $amount;


    /**
     * @var null | Rabatt
     */
    protected $rabatt = null;

    /**
     * @var AppartementPriceCalculator | null
     */
    protected $calculator;

    /**
     * @var bool
     */
    private $is_hs;

    /**
     * @var mixed
     */
    private $gaeste;


    /**
     * Create a new job instance.
     *
     * @param array $arrSelection
     *
     */
    public function __construct( array $arrSelection ) {
        //
        $this->appartement = $arrSelection['appartement'];
        $this->cart        = $arrSelection['cart'];
        $this->gaeste      = $arrSelection['gaeste'];
        $this->amount      = 1;
        $this->is_hs = app( SaisonManager::class )->isInHauptsaison( $this->cart->getPeriod() );

        $this->calculator = app( AppartementPriceCalculator::class )->input(
            $this->appartement,
            $this->cart->nights,
            $this->is_hs
        );

        if ( isset( $arrSelection['rabatt'] ) ) {
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
     *
     * @return void
     */
    public function handle() {

        $data = [
            'sum'           => $this->gaeste,
            'teilnehmer'    => $this->gaeste,
            'begleitperson' => 0
        ];

        $cart_item = $this->cart->updateOrCreateItem( [
            'model'   => $this->appartement,
            'title'   => $this->appartement->title,
            'unit'    => '',
            'content' => $this->getContent(),
            'amount'  => $this->amount,
            'total'   => $this->getTotal(),
            'data'    => [ 'persons' => $data ]
        ] );

        // Update Pauschalpreise für Appartements:
        $this->cart->pauschalen()->delete();
        foreach ( $this->appartement->getPauschalen() as $pauschale ) {
            if ( isset( $pauschale['preis_pauschale'] ) ) {
                $this->cart->items()->create( [
                    'cat'       => Cart::KAT_PAUSCHALEN,
                    'class'     => CartItem::class,
                    'model_id'  => 0,
                    'parent_id' => $cart_item->id,
                    'title'     => $pauschale['beschreibung'] ?? '',
                    'amount'    => 1,
                    'total'     => $pauschale['preis_pauschale']
                ] );
            }
        }

    }

    protected function getContent() {
        $arrC = [];
        if ( $this->gaeste > 0 ) {
            $arrC[] = plural( $this->gaeste, 'Gast' );
        }
        $content = 'Für ' . implode( ' und ', $arrC );

        $content .= '. ';

        if ( $this->rabatt ) {
            $content .= '-' . $this->rabatt->getDiscountPercent() . '% Aktion ' . $this->rabatt->title;
        }

        return $content;
    }

}
