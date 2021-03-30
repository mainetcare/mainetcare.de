<?php

namespace App\Jobs;

use App\Exceptions\PriceException;
use App\Models\Angebot;
use App\Models\Cart;
use App\Models\EntryModel;
use App\Services\AngebotPriceCalculator;
use App\Services\BulkPrices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessAddAngebotToCart {

//    implements ShouldQueue {
//
//    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Angebot
     */
    protected $angebot;
    /**
     * @var Cart
     */
    protected $cart;
    /**
     * @var mixed
     */
    protected $unit;

    /**
     * the variant of a price unit @see BulkPrices
     * @var null
     */
    protected $variant = null;

    /**
     * @var mixed
     */
    protected $amount;
    /**
     * @var mixed
     */
    protected $multiplier;


    /**
     * Create a new job instance.
     *
     * @param array $arrSelection
     *
     * @throws PriceException
     */
    public function __construct( array $arrSelection ) {
        //
        $this->angebot = $arrSelection['angebot'];
        $this->cart    = $arrSelection['cart'];
        $this->unit    = $this->sanitizeUnit( $this->angebot, $arrSelection['unit'] );
        if ( isset ( $arrSelection['variant'] ) ) {
            $this->variant = $arrSelection['variant'];
        }
        $this->amount     = $arrSelection['amount'];
        $this->multiplier = $arrSelection['multiplier'];

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $bulk    = new BulkPrices( $this->angebot, $this->unit, $this->variant );
        $staffel = $bulk->getPrices();

        $calculator = app( AngebotPriceCalculator::class, [
            'bulkprices' => $bulk,
            'amount'     => $this->amount,
            'multiplier' => $this->multiplier
        ] );

        $total      = $calculator->getTotal();

        $content = $this->content( $staffel, $bulk );

        $this->cart->updateOrCreateItem( [
            'model'   => $this->angebot,
            'title'   => $this->title( $this->angebot, $bulk ),
            'unit'    => $this->unit . (string) $this->variant,
            'amount'  => $this->amount,
            'content' => $content,
            'total'   => $total,
        ] );
    }

    protected function content( $staffel, BulkPrices $bulk ) {
        $content = '';
        $content .= $this->label( $staffel );
        if ( $bulk->hasMultiplier() ) {
            $content .= sprintf( " für %s", plural( $this->multiplier, ucfirst($bulk->getMultiplier()) ) );
        }

        return $content;
    }

    protected function title( $model, $bulk ) {
        $title = $model->title;
        if ( $bulk->hasVariant() ) {
            $title = $title . ' ' . $bulk->getVariant();
        }

        return $title;
    }


    /**
     * calulates the correct label for the cart depending on the amount and the cart label of the unit
     *
     * @param $staffel
     *
     * @return string
     */
    protected function label( $staffel ) {

        if ( $staffel && (string) $staffel->get( 'label_cart' ) != '' ) {
            $label = $staffel->get( 'label_cart' );

            return sprintf( $label, $this->amount );
        } else {
            $label = ucfirst( $this->unit );

            return plural( $this->amount, $label );
        }

    }

    /**
     * // Wenn die Unit fehlerhaft oder nicht vorhanden ist, wird eine Default Unit (die erste) benutzt:
     *
     * @param EntryModel $model
     * @param string $unit
     *
     * @return mixed
     * @throws PriceException
     */
    protected function sanitizeUnit( Angebot $model, $unit ) {
        $units = $model->getUnits();
        if ( $units === null || $units->count() == 0 ) {
            throw new PriceException( 'Angebot ' . $model->title . ' hat keine oder defekte Preisliste. Angebot kann nicht zum Warenkorb hinzugefügt werden.' );
        }
        if ( ! $model->hasUnit( $unit ) ) {
            return $units->first();
        }

        return $unit;
    }


}
