<?php


namespace App\Repositories;

use App\Factories\AngebotFactory;
use App\Factories\PaketFactory;
use App\Models\Angebot;
use App\Models\AngebotBereich;
use App\Models\AngebotGruppe;
use App\Models\Appartement;
use App\Models\Cart;
use Statamic\Facades\Entry;

class CartItemRepository {

    /**
     * @var Cart|null
     */
    protected $cart;

    protected $data = 0;

    public function __construct( Cart $cart = null ) {
        $this->cart = $cart;
    }


    public function getAllocatedPersons() {
        $data = $this->cart
            ->items()
            ->where( 'class', Appartement::class )
            ->whereNotNull( 'data' )
            ->get()
            ->pluck( 'data.persons' );

        return $data;
    }

    public function getSumAllocatedPersons() {
        $data = $this->getAllocatedPersons();

        return collect( [
            'all'           => $data->sum( 'sum' ),
            'teilnehmer'    => $data->sum( 'teilnehmer' ),
            'begleitperson' => $data->sum( 'begleitperson' ),
        ] );
    }

    public static function removeAppartements() {
        
    }



}
