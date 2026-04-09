<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts'      => Post::count(),
            'published_posts'  => Post::where('status', 'published')->count(),
            'draft_posts'      => Post::where('status', 'draft')->count(),
            'total_comments'   => Comment::count(),
            'pending_comments' => Comment::where('is_approved', false)->count(),
            'total_users'      => User::count(),
            'total_categories' => Category::count(),
            'total_views'      => Post::sum('views'),
        ];

        $recentPosts    = Post::with('category', 'user')->latest()->take(5)->get();
        $pendingComments = Comment::with('post')->where('is_approved', false)->latest()->take(5)->get();
        $topPosts       = Post::orderByDesc('views')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'pendingComments', 'topPosts'));
    }
}
