<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user, public string $activationUrl)
    {
    }

    public function build()
    {
        return $this->subject('MyGovEvent — Activate Your Account')
            ->view('mail.account-activation');
    }
}
