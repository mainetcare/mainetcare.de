<?php

namespace Tests\Feature;

use App\Jobs\BookingRequest;
use App\Mail\SendBookingRequest;
use App\Models\Appartement;
use App\Models\Cart;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Mail;
use Tests\CreatesModels;
use Tests\TestCase;

class BookingRequestTest extends TestCase {

    use CreatesModels;

    use RefreshDatabase;
    use CreatesModels;
    use InteractsWithSession;

    public function setUp(): void {
        parent::setUp();
    }

    /**
     * @test
     */
    public function a_request_can_only_be_sent_once() {

        Mail::fake();

        $cart =  $this->createCartForUrlaubInAppartementGoldfever();

        app(BookingRequest::class, ['cart' => $cart])->handle();

        Mail::assertSent(function (SendBookingRequest $mail) use ($cart) {
            return $mail->cart->id === $cart->id;
        });

        $return = app(BookingRequest::class, ['cart' => $cart])->handle();

        $this->assertFalse($return);

    }

    /**
     * @test
     */
    public function after_the_request_is_sent_the_appartement_has_status_reserved_for_given_period() {

        Mail::fake();

        $checkin = new Carbon('1.11.2020');
        $checkout = new Carbon('7.11.2020');

        $app = $this->createGoldfever();

        // before request it is available:
        $this->assertEquals(true, $app->availableIn($checkin, $checkout));

        $cart =  $this->createCartForUrlaubInAppartementGoldfever($checkin, $checkout);
        app(BookingRequest::class, ['cart' => $cart])->handle();

        // after request it is not available anymore:
        $this->assertEquals(false, $app->availableIn($checkin, $checkout));

    }

    /**
     * @return Cart
     */
    public function createCart() {
        return Cart::create([]);
    }

}
