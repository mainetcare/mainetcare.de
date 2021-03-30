<?php

namespace App\Mail;

use App\Models\Cart;
use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendContactformRequest extends Mailable {
    use Queueable, SerializesModels;

    /**
     * @var Contact | null
     */
    public Contact $contact;

    /**
     * Create a new message instance.
     *
     * @param Contact $contact
     */
    public function __construct( Contact $contact ) {
        //
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this
            ->subject( 'Allgemeine Anfrage über Kontaktformular ' . config( 'app.name' ) )
            ->markdown( 'mail.sendcontactformrequest' );
    }
}
