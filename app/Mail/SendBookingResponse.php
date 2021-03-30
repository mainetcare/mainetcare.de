<?php

namespace App\Mail;

use App\Models\Cart;
use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendBookingResponse extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Cart
     */
    public $cart;

    /**
     * @var Contact
     */
    public $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Cart $cart)
    {
        //
        $this->cart = $cart;
        $this->contact = $cart->contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Ihre Buchungsanfrage ' . config('app.name') )
            ->markdown('mail.sendbookingresponse');
    }
}
