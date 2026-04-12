<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AlreadySubscribed extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $email
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You are already subscribed to ' . config('app.name'),
            from: new \Illuminate\Mail\Mailables\Address(
                config('mail.from.address', 'noreply@proguideph.com'),
                config('app.name')
            ),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.already-subscribed',
            with: [
                'email' => $this->email,
            ],
        );
    }
}