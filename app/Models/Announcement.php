<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['title', 'content', 'style', 'animation_type', 'is_active', 'start_at', 'end_at'];

    protected $casts = [
        'is_active' => 'boolean',
        'start_at'  => 'datetime',
        'end_at'    => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_at')->orWhere('start_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_at')->orWhere('end_at', '>=', now());
            });
    }

    public function getStyleClassAttribute(): string
    {
        return match($this->style) {
            'warning' => 'announcement-warning',
            'success' => 'announcement-success',
            'danger'  => 'announcement-danger',
            'premium' => 'announcement-premium',
            default   => 'announcement-info',
        };
    }
}
