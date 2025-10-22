<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailInfoUtil extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $motdepasse;

    public function __construct($user, $motdepasse)
    {
        $this->user = $user;
        $this->motdepasse = $motdepasse;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Informations de compte Concour Robots',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.generationUtil',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
