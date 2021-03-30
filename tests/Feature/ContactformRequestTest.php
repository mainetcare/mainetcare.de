<?php

namespace Tests\Feature;

use App\Jobs\BookingRequest;
use App\Jobs\ContactformRequest;
use App\Mail\SendBookingRequest;
use App\Mail\SendContactformRequest;
use App\Models\Appartement;
use App\Models\Cart;
use App\Models\Contact;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Mail;
use Tests\CreatesModels;
use Tests\TestCase;

class ContactformRequestTest extends TestCase {

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
    public function a_valid_contact_request_creates_a_contact() {

        $data = [
            'name'     => 'Michael Mai',
            'email'    => 'info@mainetcare.com',
            'betreff'  => 'Some Text',
            'hinweise' => 'Lorem Ipsum'
        ];

        app( ContactformRequest::class, [ 'data' => $data ] )->handle();

        $contact = Contact::find( 1 );

        $this->assertEquals( $data['name'], $contact->name );
        $this->assertEquals( $data['email'], $contact->email );
        $this->assertEquals( $data['betreff'], $contact->betreff );
        $this->assertEquals( $data['hinweise'], $contact->hinweise );

    }

    /**
     * @test
     */
    public function a_contact_request_can_be_mailed() {

        Mail::fake();

        $data = [
            'name'     => 'Michael Mai',
            'email'    => 'info@mainetcare.com',
            'betreff'  => 'Some Text',
            'hinweise' => 'Lorem Ipsum'
        ];

        app( ContactformRequest::class, [ 'data' => $data ] )->handle();

        $contact = Contact::findOrFail( 1 );

        Mail::assertSent( function ( SendContactformRequest $mail ) use ( $contact ) {
            return $mail->contact->id === $contact->id;
        } );

    }


}
