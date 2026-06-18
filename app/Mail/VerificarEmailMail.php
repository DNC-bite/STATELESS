<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificarEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $url;
    public string $nombre;

    public function __construct(string $url, string $nombre)
    {
        $this->url    = $url;
        $this->nombre = $nombre;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: '✅ Verifica tu cuenta — STATELESS');
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.verificar-email');
    }
}