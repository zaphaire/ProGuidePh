<?php

namespace App\Mail;

use App\Models\Post;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewPostNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Post $post,
        public ?Subscriber $subscriber = null
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[' . config('app.name') . '] ' . $this->post->title,
            from: new \Illuminate\Mail\Mailables\Address(
                config('mail.from.address', 'noreply@' . request()->getHost()),
                config('mail.from.name', config('app.name'))
            ),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-post-notification',
            with: [
                'post' => $this->post,
                'subscriber' => $this->subscriber,
            ],
        );
    }
}