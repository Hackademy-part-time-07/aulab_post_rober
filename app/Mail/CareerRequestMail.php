<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CareerRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $role;
    public $message;
    public $email;

    public function __construct($role, $message, $email)
    {
        $this->role = $role;
        $this->message = $message;
        $this->email = $email;
    }

    public function build()
    {
        return $this->subject('Solicitud de empleo recibida')
                    ->view('emails.career_request')
                    ->with([
                        'role' => $this->role,
                        'message' => $this->message,
                        'email' => $this->email
                    ]);
    }
}

