<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('category', 'user')->published()->latest('published_at');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        $posts      = $query->paginate(9)->withQueryString();
        $categories = Category::withCount('publishedPosts')->orderBy('order')->get();

        return view('public.posts.index', compact('posts', 'categories'));
    }

    public function show(Post $post)
    {
        if ($post->status !== 'published') {
            $user = auth()->user();
            abort_if(!$user || !in_array($user->role, ['admin', 'editor']), 404);
        }

        $post->incrementViews();

        $comments = $post->approvedComments()->latest()->get();

        $relatedPosts = Post::with('category')
            ->published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('public.posts.show', compact('post', 'comments', 'relatedPosts'));
    }

    public function storeComment(Request $request, Post $post)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'body'  => 'required|string|max:1000',
        ]);

        $validated['post_id']    = $post->id;
        $validated['ip_address'] = $request->ip();

        Comment::create($validated);

        return back()->with('success', 'Your comment has been submitted and is awaiting moderation. Thank you!');
    }
}
