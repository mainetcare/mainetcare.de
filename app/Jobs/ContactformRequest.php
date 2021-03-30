<?php

namespace App\Jobs;

use App\Helpers\StatamicHelper;
use App\Mail\SendBookingRequest;
use App\Mail\SendBookingResponse;
use App\Mail\SendContactformRequest;
use App\Models\Appartement;
use App\Models\BlockedPeriod;
use App\Models\Cart;
use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use Statamic\Facades\GlobalSet;

class ContactformRequest implements ShouldQueue {

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $data = [];


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( array $data ) {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle() {

        $contact = Contact::create( [
            'name'     => $this->data['name'],
            'email'    => $this->data['email'],
            'betreff'  => $this->data['betreff'],
            'hinweise' => $this->data['hinweise'],
        ] );

        Mail::to( $this->getMailTo() )->send( new SendContactformRequest( $contact ) );

        $contact->setSent();

        return true;

    }


    protected function getMailTo() {
        $mailto = StatamicHelper::getGlobalvar( 'company', 'mailto_request' );
        if ( ! $mailto ) {
            return config( 'rkb.mail_request_to' );
        }

        return $mailto;
    }

}
