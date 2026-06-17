<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ResetPasswordOtpMail extends Mailable
{
    public $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function build()
    {
        return $this
            ->subject('Reset Password')
            ->view('emails.reset-password-otp');
    }
}
