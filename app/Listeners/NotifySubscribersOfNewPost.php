<?php

namespace App\Listeners;

use App\Events\PostPublished;
use App\Mail\NewPostNotification;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class NotifySubscribersOfNewPost
{
    public function handle(PostPublished $event): void
    {
        $post = $event->post;
        
        $subscribers = Subscriber::verified()->get();
        
        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new NewPostNotification($post, $subscriber));
        }
    }
}