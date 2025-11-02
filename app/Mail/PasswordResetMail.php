<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetUrl;

    public function __construct($token, $email)
    {
        $this->resetUrl = URL::temporarySignedRoute(
            'password.reset',
            now()->addMinutes(60),
            ['token' => $token, 'email' => $email]
        );
    }

    public function build()
    {
        return $this->subject('Password Reset Request')
                    ->view('emails.password-reset')
                    ->with(['url' => $this->resetUrl]);
    }
}
