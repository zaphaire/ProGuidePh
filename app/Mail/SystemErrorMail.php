<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SystemErrorMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $errorMessage,
        public string $errorLocation,
        public string $severity,
        public string $userEmail = null
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[' . config('app.name') . '] System Error - ' . $this->severity,
            from: new \Illuminate\Mail\Mailables\Address(
                config('mail.from.address', 'noreply@' . request()->getHost()),
                config('mail.from.name', config('app.name'))
            ),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.system-error',
            with: [
                'errorMessage' => $this->errorMessage,
                'errorLocation' => $this->errorLocation,
                'severity' => $this->severity,
                'userEmail' => $this->userEmail,
                'time' => now()->format('F j, Y g:i A'),
                'ipAddress' => request()->ip(),
            ],
        );
    }
}