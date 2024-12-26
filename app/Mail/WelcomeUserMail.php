<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class WelcomeUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $appName;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->appName = Config::get('app.name'); // Get the APP_NAME from .env
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject("Welcome to {$this->appName}")
            ->view('emails.welcome')
            ->with([
                'user' => $this->user,
                'appName' => $this->appName,
            ]);
    }
}
