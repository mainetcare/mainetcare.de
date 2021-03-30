<?php

namespace Tests\Unit;

use App\Http\Livewire\AddPaketAppartementToCart;
use App\Jobs\ProcessAddPaketAppartementToCart;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Contact;
use App\Models\Pferdepension;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesModels;
use Tests\TestCase;
use function Stringy\create;

class ContactTest extends TestCase {


    use RefreshDatabase, CreatesModels, InteractsWithDatabase;


    /**
     * @test
     */
    public function a_contact_has_needed_fields() {
        $this->assertFieldsAndFillable( Contact::class, [
            'vorname'      => 'Michael',
            'name'         => 'Mai',
            'email'        => 'info@mainetcare.com',
            'adresszusatz' => 'Some Street',
            'strasse'      => 'TWS 122',
            'plz'          => '10555',
            'ort'          => 'Berlin',
            'betreff'      => 'Some Betreff',
            'sent_at'      => '',
            'origin'       => 'some value'
        ] );
    }


    /**
     * @test
     */
    public function the_first_name_is_optional() {

        $contact = factory( Contact::class )->create( [
            'vorname' => ''
        ] );

        $this->assertEquals( '', Contact::find( 1 )->vorname );

    }


    /**
     * @test
     */
    public function a_contact_has_an_origin() {

        $contact = factory( Contact::class )->create( [
            'origin' => Contact::ORIGIN_CONTACTFORM
        ] );

        $this->assertEquals( 'contactform', Contact::find( 1 )->origin );

    }


}
