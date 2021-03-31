<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangePassword extends Mailable
{
    use Queueable, SerializesModels;
    public $changePwdDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($changePwdDetails)
    {
        $this->changePwdDetails = $changePwdDetails;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.changePassword')
        ->with('changePwdDetails', $this->changePwdDetails);
    }
}
