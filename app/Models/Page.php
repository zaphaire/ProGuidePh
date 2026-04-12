<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = [
        'user_id', 'title', 'slug', 'body',
        'meta_title', 'meta_description', 'is_published', 'order',
    ];

    protected $casts = ['is_published' => 'boolean'];

    protected static function booted(): void
    {
        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }
}
