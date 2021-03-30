<?php

namespace App\Jobs;

use App\Helpers\StatamicHelper;
use App\Mail\SendBookingRequest;
use App\Mail\SendBookingResponse;
use App\Models\Appartement;
use App\Models\BlockedPeriod;
use App\Models\Cart;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use Statamic\Facades\GlobalSet;

class BookingRequest implements ShouldQueue {

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $cart = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( Cart $cart ) {
        $this->cart = $cart;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle() {


        if($this->cart->isSent()) {
            return false;
        }

        $this->cart->update( [
            'status' => 'sending'
        ] );

        Mail::to($this->getMailTo())->send(new SendBookingRequest($this->cart));

        if($responder = $this->getMailResponder()) {
            Mail::to($responder)
                ->send(new SendBookingResponse($this->cart));
        }

        $this->cart->setSent();
        $this->cart->appartements()->each(function($appartement) {
            /**
             * @var $appartement Appartement
             */
            $appartement->block($this->cart->checkin, $this->cart->checkout, BlockedPeriod::STATUS_RESERVIERT);
        });

        return true;

    }


    protected function getMailTo() {
        $mailto = StatamicHelper::getGlobalvar('company', 'mailto_request');
        if(!$mailto) {
            return config('rkb.mail_request_to');
        }
        return $mailto;
    }

    protected function getMailResponder() {
        $contact = $this->cart->contact;
        if(!$contact) {
            return null;
        }
        return $contact->email;
    }


}
