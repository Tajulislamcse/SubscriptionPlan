<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginOTPMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($otp, $user)
    {
        $this->otp = $otp;
        $this->user = $user;
    }

    /**
     * Build the message.
     */
   public function build()
    {
        return $this->subject('Your Login OTP')
            ->markdown('login-otp')
            ->with([
                'user' => $this->user,
                'otp' => $this->otp,
            ]);
    }
}
