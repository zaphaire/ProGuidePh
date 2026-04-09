<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        $admin = User::create([
            'name' => 'ProGuide Admin',
            'email' => 'admin@proguideph.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Editor User
        User::create([
            'name' => 'Content Editor',
            'email' => 'editor@proguideph.com',
            'password' => Hash::make('password'),
            'role' => 'editor',
        ]);

        // Categories
        $categories = [
            ['name' => 'Affordable Schools',  'slug' => 'affordable-schools',  'color' => '#3B82F6', 'icon' => '🏫'],
            ['name' => 'Senior High School',  'slug' => 'senior-high-school',  'color' => '#10B981', 'icon' => '📚'],
            ['name' => 'College & Universities', 'slug' => 'college-universities', 'color' => '#8B5CF6', 'icon' => '🎓'],
            ['name' => 'Vocational Training', 'slug' => 'vocational-training',  'color' => '#F59E0B', 'icon' => '🔧'],
            ['name' => 'Scholarships & Grants', 'slug' => 'scholarships-grants',  'color' => '#06B6D4', 'icon' => '🎁'],
            ['name' => 'Student Tips',       'slug' => 'student-tips',        'color' => '#EF4444', 'icon' => '💡'],
            ['name' => 'Career Paths',       'slug' => 'career-paths',        'color' => '#F97316', 'icon' => '🚀'],
            ['name' => 'News & Updates',     'slug' => 'news-updates',        'color' => '#EC4899', 'icon' => '📰'],
        ];

        foreach ($categories as $i => $cat) {
            Category::create(array_merge($cat, ['order' => $i]));
        }

        // Default Settings
        $settings = [
            ['key' => 'site_name',        'value' => 'ProGuidePh',                                             'group' => 'general'],
            ['key' => 'site_tagline',     'value' => 'Your Digital Tambayan for Practical Tips & Guides',    'group' => 'general'],
            ['key' => 'site_email',       'value' => 'support@proguideph.com',                                 'group' => 'general'],
            ['key' => 'site_phone',       'value' => '+63 900 000 0000',                                        'group' => 'general'],
            ['key' => 'site_address',     'value' => 'Philippines',                                             'group' => 'general'],
            ['key' => 'site_logo',        'value' => '',                                                        'group' => 'general'],
            ['key' => 'site_favicon',     'value' => '',                                                        'group' => 'general'],
            ['key' => 'meta_description', 'value' => 'Discover practical tips and helpful guides for Filipinos. Your digital tambayan for useful information in the Philippines.', 'group' => 'seo'],
            ['key' => 'meta_keywords',    'value' => 'tips, guides, philippines, filipino, tambayan, how-to',                                  'group' => 'seo'],
            ['key' => 'social_facebook',  'value' => '', 'group' => 'social'],
            ['key' => 'social_twitter',   'value' => '', 'group' => 'social'],
            ['key' => 'social_tiktok',    'value' => '', 'group' => 'social'],
            ['key' => 'social_linkedin',  'value' => '', 'group' => 'social'],
            ['key' => 'social_instagram', 'value' => '', 'group' => 'social'],
            ['key' => 'posts_per_page',   'value' => '9',                                                       'group' => 'general'],
            ['key' => 'footer_text',      'value' => '© '.date('Y').' ProGuidePh. All rights reserved.', 'group' => 'general'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }

        // Sample Announcement
        Announcement::create([
            'title' => 'Welcome to EduCorner!',
            'content' => 'Your one-stop source for information on affordable schools, educational programs, scholarships, and student resources in the Philippines. Find the right school for you!',

            'style' => 'info',
            'is_active' => true,
        ]);

        $aboutBody = <<<'HTML'
<div class="about-hero">
    <div class="about-hero-content">
        <span class="about-badge">Welcome to ProGuidePh</span>
        <h1>Your Digital Tambayan for Practical Knowledge</h1>
        <p>ProGuidePh is your trusted online destination for helpful articles, practical tips, and useful guides written by Filipinos, for Filipinos. We share real-world knowledge that you can apply in your daily life.</p>
    </div>
</div>

<div class="about-section about-mission">
    <h2><span class="icon">🎯</span> Our Mission</h2>
    <p>To create a welcoming space where helpful information flows freely — sharing practical wisdom, useful tips, and actionable guides that empower every Filipino to live smarter and make better decisions in their daily lives.</p>
</div>

<div class="about-section about-values">
    <h2>What We Stand For</h2>
    <div class="values-grid">
        <div class="value-card">
            <span class="value-icon">📝</span>
            <h3>Practical Content</h3>
            <p>We share tips and guides that you can actually use — no fluff, just helpful information you can apply today.</p>
        </div>
        <div class="value-card">
            <span class="value-icon">🤝</span>
            <h3>Filipino-Centric</h3>
            <p>Content that speaks to the Filipino experience — addressing the unique challenges and opportunities we face daily.</p>
        </div>
        <div class="value-card">
            <span class="value-icon">💡</span>
            <h3>Simple & Clear</h3>
            <p>We believe good information should be easy to understand. No jargon, no complexity — just clear, practical advice.</p>
        </div>
        <div class="value-card">
            <span class="value-icon">❤️</span>
            <h3>Community-Driven</h3>
            <p>This is our shared space. We learn from each other, share what we know, and grow together as a community.</p>
        </div>
    </div>
</div>

<div class="about-section about-why">
    <h2>Why ProGuidePh?</h2>
    <div class="why-grid">
        <div class="why-item">
            <span class="why-number">1</span>
            <div>
                <h3>Real, Practical Tips</h3>
                <p>Every article is written with real-world application in mind. We share what actually works.</p>
            </div>
        </div>
        <div class="why-item">
            <span class="why-number">2</span>
            <div>
                <h3>Written by Filipinos</h3>
                <p>Our content is created by people who understand the Filipino context — culture, challenges, and lifestyle.</p>
            </div>
        </div>
        <div class="why-item">
            <span class="why-number">3</span>
            <div>
                <h3>Easy to Understand</h3>
                <p>No complicated jargon. We write in a way that's friendly and easy to follow.</p>
            </div>
        </div>
        <div class="why-item">
            <span class="why-number">4</span>
            <div>
                <h3>Always Free</h3>
                <p>Helpful information should be free. Everything on ProGuidePh is accessible to everyone, no paywalls.</p>
            </div>
        </div>
    </div>
</div>
HTML;

        // About Page
        Page::create([
            'user_id' => $admin->id,
            'title' => 'About Us',
            'slug' => 'about',
            'body' => $aboutBody,
            'is_published' => true,
            'order' => 1,
            'meta_title' => 'About ProGuidePh - Your Digital Tambayan for Practical Knowledge',
            'meta_description' => 'Learn more about ProGuidePh and our mission to provide practical tips and guides for Filipinos.',
        ]);

        // Contact Page
        Page::create([
            'user_id' => $admin->id,
            'title' => 'Contact Us',
            'slug' => 'contact',
            'body' => '<h2>Get in Touch</h2><p>Have questions, suggestions, or want to contribute? We\'d love to hear from you!</p>',
            'is_published' => true,
            'order' => 2,
        ]);

        // Sample Posts
        $lifestyleCat = Category::where('slug', 'student-tips')->first();
        $healthCat = Category::where('slug', 'affordable-schools')->first();
        $techCat = Category::where('slug', 'college-universities')->first();
        $moneyCat = Category::where('slug', 'scholarships-grants')->first();

        Post::create([
            'user_id' => $admin->id,
            'category_id' => $lifestyleCat->id,
            'title' => 'Simple Home Organization Tips for Filipino Families',
            'slug' => 'simple-home-organization-tips-filipinos',
            'excerpt' => 'Maximize your space and declutter your home with these practical organization tips perfect for Filipino homes.',
            'body' => '<h2>Keep Your Home Organized</h2><p>A well-organized home makes life easier and more peaceful. Start with one room and work your way through your entire house.</p><p>Use storage solutions like bins, shelves, and vertical space to maximize your living area. In Filipino homes where space is often limited, creativity is key!</p><h2>Decluttering Steps</h2><ol><li>Start small - Pick one shelf or corner</li><li>Sort items into keep, donate, and trash</li><li>Organize what you\'re keeping</li><li>Label storage containers</li></ol>',
            'status' => 'published',
            'is_featured' => true,
            'published_at' => now(),
        ]);

        Post::create([
            'user_id' => $admin->id,
            'category_id' => $healthCat->id,
            'title' => 'Quick and Easy Exercises You Can Do at Home',
            'slug' => 'quick-easy-exercises-at-home',
            'excerpt' => 'Stay fit without a gym membership. These simple exercises can be done in your living room and require no equipment.',
            'body' => '<h2>No-Equipment Home Workouts</h2><p>You don\'t need fancy gym equipment to get fit. Your body weight is enough to build strength and endurance.</p><h2>Beginner Routine</h2><ul><li>Jumping jacks - 30 seconds</li><li>Push-ups - 10 reps</li><li>Squats - 15 reps</li><li>Planks - 30 seconds</li></ul><p>Do this routine 3 times a week and you\'ll see improvements in just a month!</p>',
            'status' => 'published',
            'is_featured' => true,
            'published_at' => now(),
        ]);

        Post::create([
            'user_id' => $admin->id,
            'category_id' => $moneyCat->id,
            'title' => 'Budgeting 101: How to Save Money on a Tight Budget',
            'slug' => 'budgeting-save-money-tight-budget',
            'excerpt' => 'Learn practical budgeting strategies that work for Filipino families trying to make ends meet.',
            'body' => '<h2>Start Budgeting Today</h2><p>Whether you earn a little or a lot, budgeting helps you make the most of your money. Here\'s how to start:</p><h2>The 50/30/20 Rule</h2><ul><li>50% - Essentials (rent, food, utilities)</li><li>30% - Wants (entertainment, dining out)</li><li>20% - Savings and debt repayment</li></ul><p>Track every peso you spend for one month to understand your spending habits, then adjust accordingly.</p>',
            'status' => 'published',
            'is_featured' => true,
            'published_at' => now(),
        ]);

        Post::create([
            'user_id' => $admin->id,
            'category_id' => $techCat->id,
            'title' => 'Essential Cybersecurity Tips for Filipinos Online',
            'slug' => 'cybersecurity-tips-filipinos',
            'excerpt' => 'Protect yourself and your family from online threats with these practical cybersecurity tips.',
            'body' => '<h2>Stay Safe Online</h2><p>As more Filipinos go online for work and social interaction, cybersecurity has become crucial. Here are essential tips:</p><h2>Password Security</h2><ul><li>Use strong passwords with mix of letters, numbers, and symbols</li><li>Never reuse passwords across different accounts</li><li>Enable two-factor authentication when available</li></ul><h2>Avoid Scams</h2><p>Be wary of unsolicited messages, links, and requests for personal information. When in doubt, verify directly with the official source.</p>',
            'status' => 'published',
            'is_featured' => true,
            'published_at' => now(),
        ]);
    }
}
