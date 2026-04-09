<?php

namespace App\Console\Commands;

use App\Models\Page;
use App\Models\User;
use Illuminate\Console\Command;

class SyncAboutPage extends Command
{
    protected $signature = 'about:sync';

    protected $description = 'Sync the About Us page with new content';

    public function handle()
    {
        $body = '<h2>About EduCornerPh</h2><p>Welcome to EduCornerPh! This website is my personal space where I share what I know and what I have experienced. I created this platform to help Filipino students and families by sharing practical information about affordable education options that I am familiar with.</p><p>This is not an educational services website. I am simply sharing my knowledge and experience to help others who may benefit from the information I provide.</p><h3>What I Share</h3><ul><li><strong>Affordable Schools</strong> - Schools I know that offer quality education at reasonable prices</li><li><strong>Modular Schools</strong> - Information about schools with modular learning setups</li><li><strong>Budget-Friendly Options</strong> - Schools and programs that are easier on the pocket</li><li><strong>Personal Experiences</strong> - Things I have learned and encountered along the way</li><li><strong>Tips and Insights</strong> - Practical advice based on my own journey</li></ul><h3>My Goal</h3><p>My goal is simple — to share what I know so that others can benefit. Whether you are a student looking for an affordable school or a parent searching for the right option for your child, I hope the information I share here helps you in some way.</p><p>I do not provide formal educational services. This is purely a sharing platform where I pass on knowledge and experiences that may be useful to you.</p>';

        Page::updateOrCreate(
            ['slug' => 'about'],
            [
                'user_id' => User::first()->id ?? 1,
                'title' => 'About Us',
                'body' => $body,
                'is_published' => true,
            ]
        );

        $this->info('About page synced successfully!');
    }
}
