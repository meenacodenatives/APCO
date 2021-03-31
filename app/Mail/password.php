<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class password extends Mailable
{
    
    use Queueable, SerializesModels;
public $forgotPwdDetails;
    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($forgotPwdDetails)
    {
        $this->forgotPwdDetails = $forgotPwdDetails;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //$message=$this->forgotPwdDetails['message'];
        return $this->markdown('emails.forgotPassword')
                    ->with('forgotPwdDetails', $this->forgotPwdDetails);
    // return $this->subject('Forgot Password')->view('emails.forgotPassword')->with([
    //     'link' => $message,
    // ]);
    }
}
