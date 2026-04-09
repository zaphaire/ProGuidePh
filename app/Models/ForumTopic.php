<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ForumTopic extends Model
{
    protected $fillable = ['title', 'body', 'author_name', 'slug', 'is_published'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($topic) {
            if (empty($topic->slug)) {
                $topic->slug = Str::slug($topic->title) . '-' . uniqid();
            }
        });
    }

    public function replies()
    {
        return $this->hasMany(ForumReply::class, 'forum_topic_id')->orderBy('created_at', 'asc');
    }

    public function getReplyCountAttribute()
    {
        return $this->replies()->count();
    }
}
