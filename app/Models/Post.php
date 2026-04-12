<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'title', 'slug', 'excerpt', 'body',
        'featured_image', 'status', 'is_featured', 'views',
        'meta_title', 'meta_description', 'published_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = static::uniqueSlugFrom($post->title);
            }
        });
    }

    public static function uniqueSlugFrom(string $title): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function approvedComments(): HasMany
    {
        return $this->hasMany(Comment::class)->where('is_approved', true);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrderByPublishedAt($query, $direction = 'desc')
    {
        return $query->orderBy('published_at', $direction);
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        if ($this->featured_image) {
            // If it's already a URL, use it directly
            if (str_starts_with($this->featured_image, 'http')) {
                // If it's a Google Drive link, convert to direct download link
                if (str_contains($this->featured_image, 'drive.google.com')) {
                    preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $this->featured_image, $matches);
                    if (isset($matches[1])) {
                        return 'https://drive.google.com/uc?export=download&id=' . $matches[1];
                    }
                }
                return $this->featured_image;
            }
            return asset('storage/' . $this->featured_image);
        }
        return asset('images/default-post.jpg');
    }
}
