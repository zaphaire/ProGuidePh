<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subscriber extends Model
{
    protected $fillable = [
        'email',
        'name',
        'verify_token',
        'is_verified',
        'is_active',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function ($subscriber) {
            if (empty($subscriber->verify_token)) {
                $subscriber->verify_token = Str::random(64);
            }
        });
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true)->where('is_active', true);
    }

    public function verify(): void
    {
        $this->update(['is_verified' => true, 'verify_token' => null]);
    }

    public function unsubscribe(): void
    {
        $this->update(['is_active' => false]);
    }
}