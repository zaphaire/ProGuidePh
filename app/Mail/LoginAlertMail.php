<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoginAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public bool $success,
        public string $ipAddress,
        public string $userAgent,
        public string $time
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->success 
            ? '[' . config('app.name') . '] Successful Login' 
            : '[' . config('app.name') . '] Failed Login Attempt';
            
        return new Envelope(
            subject: $subject,
            from: new \Illuminate\Mail\Mailables\Address(
                config('mail.from.address', 'noreply@' . request()->getHost()),
                config('mail.from.name', config('app.name'))
            ),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.login-alert',
            with: [
                'user' => $this->user,
                'success' => $this->success,
                'ipAddress' => $this->ipAddress,
                'userAgent' => $this->userAgent,
                'time' => $this->time,
            ],
        );
    }
}