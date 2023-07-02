<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class CareerRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $role;
    public $mensaje;
    public $email;

    public function __construct($role, $mensaje, $email)
    {
        $this->role = $role;
        $this->mensaje = $mensaje;
        $this->email = $email;
    }

    public function build()
    {
        return $this->subject('Solicitud de empleo recibida')
                    ->view('emails.career_request')
                    ->with([
                        'role' => $this->role,
                        'mensaje' => $this->mensaje,
                        'email' => $this->email
                    ]);
    }
}
