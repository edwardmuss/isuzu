<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuoteRequestMail extends Mailable
{
    public $name;
    public $vehicle;

    public function __construct($name, $vehicle)
    {
        $this->name = $name;
        $this->vehicle = $vehicle;
    }

    public function build()
    {
        return $this->view('emails.quote')
            ->with(['name' => $this->name, 'vehicle' => $this->vehicle]);
    }
}
