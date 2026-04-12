<?php

namespace App\Mail;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterUnsubscribed extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $email
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You have been unsubscribed from ' . config('app.name'),
            from: new \Illuminate\Mail\Mailables\Address(
                config('mail.from.address', 'noreply@proguideph.com'),
                config('app.name')
            ),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter-unsubscribed',
            with: [
                'email' => $this->email,
            ],
        );
    }
}