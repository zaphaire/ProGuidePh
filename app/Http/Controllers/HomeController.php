<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Announcement;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPosts  = Post::with('category', 'user')->published()->featured()->latest('published_at')->take(3)->get();
        $recentPosts    = Post::with('category', 'user')->published()->latest('published_at')->take(6)->get();
        $categories     = Category::withCount('publishedPosts')->orderBy('order')->get();

        return view('public.home', compact('featuredPosts', 'recentPosts', 'categories'));
    }
}
