<?php

namespace App\Mail;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Subscriber $subscriber
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to ' . config('app.name') . ' Newsletter!',
            from: new \Illuminate\Mail\Mailables\Address(
                config('mail.from.address', 'noreply@proguideph.com'),
                config('app.name')
            ),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter-confirmation',
            with: [
                'subscriber' => $this->subscriber,
            ],
        );
    }
}