<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            if ($key === 'site_logo' && ! empty($value)) {
                $processedLogo = $this->processLogoUrl($value);
                Setting::set($key, $processedLogo);
            } elseif (! empty($value)) {
                Setting::set($key, $value);
            }
        }

        Cache::flush();

        return redirect()->route('admin.settings.index')->with('success', 'Settings saved successfully!');
    }

    private function processLogoUrl(string $url): string
    {
        $url = trim($url);

        if (preg_match('/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $fileId = $matches[1];

            return 'https://drive.google.com/uc?export=view&id='.$fileId;
        }

        if (preg_match('/drive\.google\.com\/uc\?export=view&id=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $fileId = $matches[1];

            return 'https://drive.google.com/uc?export=view&id='.$fileId;
        }

        return $url;
    }

    private function generateFavicon($logo)
    {
        try {
            $extension = strtolower($logo->getClientOriginalExtension());

            if ($extension === 'svg') {
                $svgContent = file_get_contents($logo->getRealPath());
                file_put_contents(public_path('favicon.svg'), $svgContent);
                file_put_contents(public_path('favicon.svg'), $svgContent);

                return;
            }

            $imageCreateFunc = 'imagecreatefrom'.($extension === 'jpg' ? 'jpeg' : $extension);

            if (! function_exists($imageCreateFunc)) {
                Log::error('Cannot create image from '.$extension);

                return;
            }

            $sourceImage = $imageCreateFunc($logo->getRealPath());

            if (! $sourceImage) {
                Log::error('Failed to create source image');

                return;
            }

            $this->createFaviconFromImage($sourceImage, 32, public_path('favicon.ico'));
            $this->createFaviconFromImage($sourceImage, 32, public_path('favicon-32x32.png'), 'png');
            $this->createFaviconFromImage($sourceImage, 180, public_path('apple-touch-icon.png'), 'png');
            $this->createFaviconFromImage($sourceImage, 192, public_path('android-chrome-192x192.png'), 'png');
            $this->createFaviconFromImage($sourceImage, 512, public_path('android-chrome-512x512.png'), 'png');

            $publicPath = public_path('favicons');
            if (! File::exists($publicPath)) {
                File::makeDirectory($publicPath, 0755, true);
            }

            $sizes = [16, 32, 48, 64, 128, 192, 512];
            foreach ($sizes as $size) {
                $this->createFaviconFromImage($sourceImage, $size, $publicPath.'/icon-'.$size.'.png', 'png');
            }

            imagedestroy($sourceImage);

        } catch (\Exception $e) {
            Log::error('Failed to generate favicon: '.$e->getMessage());
        }
    }

    private function createFaviconFromImage($sourceImage, int $size, string $path, string $format = 'ico')
    {
        $newImage = imagecreatetruecolor($size, $size);
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);

        imagecopyresampled(
            $newImage, $sourceImage,
            0, 0, 0, 0,
            $size, $size,
            imagesx($sourceImage), imagesy($sourceImage)
        );

        if ($format === 'png') {
            imagepng($newImage, $path, 9);
        } else {
            imagepng($newImage, $path, 9);
        }

        imagedestroy($newImage);
    }

    public function syncAboutPage()
    {
        $body = <<<'HTML'
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
                <p>No complicated jargon. We write in a way that's conversational, friendly, and easy to follow.</p>
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

        Page::updateOrCreate(
            ['slug' => 'about'],
            [
                'user_id' => User::where('role', 'admin')->first()->id ?? (User::first()->id ?? 1),
                'title' => 'About Us',
                'body' => $body,
                'is_published' => true,
                'meta_title' => 'About ProGuidePh - Your Digital Tambayan for Practical Knowledge',
                'meta_description' => 'Learn more about ProGuidePh, our mission to share practical wisdom, and our commitment to providing helpful guides for Filipinos.',
            ]
        );

        return redirect()->route('admin.settings.index')->with('success', 'About page successfully synchronized to ProGuidePh branding!');
    }
}
