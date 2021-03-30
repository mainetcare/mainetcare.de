<?php

namespace App\Console\Commands;

use App\Factories\AngebotFactory;
use App\Factories\AppartementFactory;
use App\Factories\PaketFactory;
use App\Jobs\BookingRequest;
use App\Jobs\ProcessAddAngebotToCart;
use App\Jobs\ProcessAddAppartementToCart;
use App\Jobs\ProcessAddPaketAppartementToCart;
use App\Jobs\ProcessInitPaketInCart;
use App\Models\Cart;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TestBookingRequest extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rkb:testmail {paket?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Cart with Data and send it via Mail';


    /**
     * @var null | Cart
     */
    protected $cart = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {

        $slugpaket = $this->argument( 'paket' );

        if ( $slugpaket ) {
            $this->line( 'Creating Cart for Paket ' . $slugpaket );
            $this->createCartForPaket( $slugpaket );
        } else {
            $this->line( 'Creating Cart for Appartment Booking' );
            $this->createCartForAppartement();
        }

        $this->info( 'Done! Now Sending..' );

        app( BookingRequest::class, [ 'cart' => $this->cart ] )->handle();

        $this->info( 'Test Request and the Response were sent' );

        $this->cleanup();

        return 0;
    }

    protected function cleanup() {
        $this->cart->contact()->delete();
        $this->cart->delete();
    }

    protected function createCartForPaket( $slug ) {

        $paket = app( PaketFactory::class )->initBySlug( $slug );

        if ( ! $paket ) {
            $this->error( 'Paket mit Slug ' . $slug . ' nicht gefunden' );
            exit;
        }

        $contact    = factory( Contact::class )->create();
        $this->cart = Cart::create( [
            'contact_id' => $contact->id
        ] );

        app( ProcessInitPaketInCart::class, [
            'arrSelection' => [
                'paket'      => $paket,
                'cart'       => $this->cart,
                'checkin'    => new Carbon,
                'teilnehmer' => 3,
                'gaeste'     => 2
            ]
        ] )->handle();

        // When I allocate an appartement for 1 Teilnehmer and 1 Begleitperson

        app( ProcessAddPaketAppartementToCart::class, [
            'arrSelection' => [
                'cart'          => $this->cart,
                'paket'         => $paket,
                'appartement'   => app( AppartementFactory::class )->initBySlug( 'appartement-1-goldfever' ),
                'teilnehmer'    => 3,
                'begleitperson' => 0,
            ]
        ] )->handle();

        // And another one:

        app( ProcessAddPaketAppartementToCart::class, [
            'arrSelection' => [
                'cart'          => $this->cart,
                'paket'         => $paket,
                'appartement'   => app( AppartementFactory::class )->initBySlug( 'appartement-12-meteor' ),
                'teilnehmer'    => 0,
                'begleitperson' => 2,
            ]
        ] )->handle();

        $slugs = [
            'aussenbox',
            'fahrrad',
            'gym-und-sauna',
            'intervallfasten',
            'kettlebell',
            'kryotherapie',
            'mixedcard',
        ];

        $this->createErlebniswelten( $slugs );


    }

    /**
     * @return Cart|\Illuminate\Database\Eloquent\Model
     */
    protected function createCartForAppartement() {

        $checkin  = Carbon::now();
        $checkout = $checkin->copy()->addDays( 4 );

        $contact = factory( Contact::class )->create();

        $this->cart = Cart::create( [
            'checkin'    => $checkin,
            'checkout'   => $checkout,
            'gaeste'     => 2,
            'note'       => 'Cart automatically generated for Testing',
            'contact_id' => $contact->id
        ] );

        app( ProcessAddAppartementToCart::class, [
            'arrSelection' => [
                'appartement' => app(AppartementFactory::class)->initBySlug( 'appartement-1-goldfever' ),
                'gaeste'      => 2,
                'cart'        => $this->cart,
                'checkin'     => $checkin,
                'checkout'    => $checkout
            ]
        ] )->handle();

        $slugs = [
            'aussenbox',
            'bauch-beine-po',
            'strandritt',
            'intervallfasten',
            'jetski',
            'kettlebell',
            'kryotherapie',
            'kunstkurs',
            'mixedcard',
            'motorrad',
            'paddock-box',
            'personal-trainer',
            'quad',
            'quadtour',
            'robust-weidehaltung',
            'rueckenschule',
            'stretching',
            'transferservice',
            'yoga',
            'zirkeltraining',
        ];

        $this->createErlebniswelten( $slugs );


    }

    protected function createErlebniswelten( array $slugs ) {

        foreach ( $slugs as $slug ) {
            $angebot = app( AngebotFactory::class )->initBySlug( $slug );
            if ( ! $angebot ) {
                return;
            }
            app( ProcessAddAngebotToCart::class,
                [
                    'arrSelection' =>
                        [
                            'angebot'    => $angebot,
                            'cart'       => $this->cart,
                            'unit'       => '',
                            'amount'     => 2,
                            'multiplier' => 2,
                        ]
                ] )->handle();

        }

    }


}
