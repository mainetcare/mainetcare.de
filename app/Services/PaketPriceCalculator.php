<?php

namespace App\Services;

use App\Exceptions\PriceException;
use App\Models\Angebot;
use App\Models\Paket;
use App\Models\Rabatt;
use Arr;

/**
 * Class AngebotPriceCalculator
 * @package App\Services
 */
class PaketPriceCalculator implements Calculator {

    /**
     * @var null | Paket
     */
    protected $model = null;
    protected $amount = null;
    protected $multiplier = null;

    /**
     * @var null | Rabatt
     */
    protected $rabatt = null;

    public $staffelpreis = null;
    public $aktuelle_staffel = null;
    /**
     * @var string
     */
    private $klasse;
    /**
     * @var int
     */
    private $teilnehmer = 0;
    /**
     * @var int
     */
    private $gaeste = 0;
    /**
     * @var bool
     */
    private $hs = true;

    private $total = 0;

    /**
     * @param Paket $model
     * @param string $klasse
     * @param int $teilnehmer
     * @param int $gaeste
     * @param bool $is_hs
     *
     * @return $this
     */
    public function input( Paket $model, string $klasse, int $teilnehmer, int $gaeste, bool $is_hs ) {

        $this->model      = $model;
        $this->klasse     = $klasse;
        $this->teilnehmer = $teilnehmer;
        $this->gaeste     = $gaeste;
        $this->hs         = $is_hs;

        $this->calc();

        return $this;
    }

    protected function calc() {
        $prices      = app( PackagePrices::class, [ 'model' => $this->model ] )->getPricesBySaison( $this->klasse, $this->hs, $this->is_ez() );
        $this->total = $this->teilnehmer * $prices->get( 'teilnehmer' ) + $this->gaeste * $prices->get( 'begleitperson' );
    }

    public function is_ez() {
        return $this->teilnehmer + $this->gaeste <= 1;
    }


    public function getTotal() {
        return $this->total;
    }


    public function getUnitPrice() {
        return $this->total;
    }
}
