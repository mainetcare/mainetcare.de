<?php

namespace Tests;


use App\Factories\AngebotFactory;
use App\Factories\AppartementFactory;
use App\Factories\PaketFactory;
use App\Factories\RabattFactory;
use App\Factories\VeranstaltungFactory;
use App\Jobs\ProcessAddAngebotToCart;
use App\Jobs\ProcessAddAppartementToCart;
use App\Models\Cart;
use App\Models\Contact;
use App\Models\Rabatt;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Trait CreatesUsers
 * @package Tests
 */
trait CreatesModels {


    /**
     * we need this only if we have the mysql switch on
     */
    protected function resetTables() {
        DB::statement( 'SET FOREIGN_KEY_CHECKS=0;' );
        DB::statement( 'SET FOREIGN_KEY_CHECKS=1;' );
    }


    /**
     * @return Rabatt
     */
    public function createTestRabatt() {
        return app(RabattFactory::class)->initBySlug( 'testrabatt-a' );
    }

    /**
     * @return Rabatt
     */
    public function createTestRabatt_B() {
        return app(RabattFactory::class)->initBySlug( 'testrabatt-b' );
    }

    /**
     * @return \App\Models\Appartement
     */
    public function createGoldfever() {
        return app(AppartementFactory::class)->initBySlug( 'appartement-1-goldfever' );
    }

    /**
     * @return \App\Models\Appartement
     */
    public function createTestappartement() {
        return app(AppartementFactory::class)->initBySlug( 'appartement-21-testappartement' );
    }

    /**
     * @return \App\Models\Appartement
     */
    public function createAppartementMeteor() {
        return app(AppartementFactory::class)->initBySlug( 'appartement-12-meteor' );
    }

    /**
     * @return \App\Models\Veranstaltung
     */
    public function createTestveranstaltung() {
        return app( VeranstaltungFactory::class )->initBySlug( 'testveranstaltung' );
    }

    public function createTestangebot() {
        return app( AngebotFactory::class )->initBySlug( 'testangebot' );
    }

    public function createTestpaket() {
        return app( PaketFactory::class )->initBySlug( 'testpaket' );
    }

    public function createCartForUrlaubInAppartementGoldfever(Carbon $checkin = null, Carbon  $checkout = null) {

        if(!$checkin) {
            $checkin  = Carbon::now();
            $checkout = $checkin->copy()->addDays( 4 );
        }

        $contact = factory( Contact::class )->create();

        $cart = Cart::create( [
            'checkin'    => $checkin,
            'checkout'   => $checkout,
            'gaeste'     => 2,
            'note'       => 'Cart automatically generated for Testing',
            'contact_id' => $contact->id
        ] );

        app( ProcessAddAppartementToCart::class, [
            'arrSelection' => [
                'appartement' => app(AppartementFactory::class)->initBySlug( 'appartement-1-goldfever' ),
                'cart'        => $cart,
                'checkin'     => $checkin,
                'gaeste'      => 2,
                'checkout'    => $checkout
            ]
        ] )->handle();

        $erlebnisse = [
            'aussenbox',
            'bauch-beine-po',
            'fahrrad',
            'gym-und-sauna',
            'mixedcard',
            'quadtour',
            'transferservice',
            'yoga',
            'zirkeltraining',
        ];

        foreach ( $erlebnisse as $slug ) {
            app( ProcessAddAngebotToCart::class,
                [
                    'arrSelection' =>
                        [
                            'angebot'    => app( AngebotFactory::class )->initBySlug( $slug ),
                            'cart'       => $cart,
                            'unit'       => 'tag',
                            'amount'     => 2,
                            'multiplier' => 2,
                        ]
                ] )->handle();
        }

        return $cart;

    }


    /**
     * Asserts that it has given fields in Table and these fields are mass fillable (not guarded by model)
     *
     * @param $classname
     * @param $data
     */
    public function assertFieldsAndFillable( $classname, $data ) {
        $model = app( $classname )->create( $data );
        $model->fresh();
        $arr2 = collect( $model->getAttributes() )->only( array_keys( $data ) )->toArray();
        $this->assertEquals( $data, $arr2 );
    }


}
