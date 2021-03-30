<?php

namespace App\Mail;

use App\Models\Cart;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendBookingRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Cart
     */
    public $cart;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Cart $cart)
    {
        //
        $this->cart = $cart;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Anfrage Online-Buchung von ' . config('app.name') )
            ->markdown('mail.sendbookingrequest');
    }
}
