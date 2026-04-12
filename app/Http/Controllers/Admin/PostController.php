<?php

namespace App\Http\Controllers\Admin;

use App\Events\PostPublished;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('category', 'user')->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $posts      = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'nullable|exists:categories,id',
            'excerpt'          => 'nullable|string|max:500',
            'body'             => 'required|string',
            'status'           => 'required|in:draft,published,archived',
            'is_featured'      => 'boolean',
            'featured_image'   => 'nullable|image|max:2048',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug']    = Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');

        Log::info('Post create - media_path: ' . $request->input('media_path'));

        if ($request->hasFile('featured_image')) {
            Log::info('Post create - using uploaded file');
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        } elseif ($request->filled('media_path')) {
            Log::info('Post create - using media library: ' . $request->input('media_path'));
            $mediaPath = $request->input('media_path');
            // Extract path after /storage/ - e.g., /storage/uploads/xxx.jpg -> uploads/xxx.jpg
            $validated['featured_image'] = str_replace('/storage/', '', $mediaPath);
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        $post = Post::create($validated);

        if ($post->status === 'published') {
            event(new PostPublished($post));
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully!');
    }

    public function edit(Post $post)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function editData($id)
    {
        $post = Post::findOrFail($id);
        Log::info('editData called for post id: ' . $post->id . ' slug: ' . $post->slug);
        return response()->json([
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'excerpt' => $post->excerpt,
            'body' => $post->body,
            'status' => $post->status,
            'category_id' => $post->category_id,
            'is_featured' => $post->is_featured,
            'featured_image' => $post->featured_image,
            'meta_title' => $post->meta_title,
            'meta_description' => $post->meta_description,
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'nullable|exists:categories,id',
            'excerpt'          => 'nullable|string|max:500',
            'body'             => 'required|string',
            'status'           => 'required|in:draft,published,archived',
            'is_featured'      => 'boolean',
            'featured_image'   => 'nullable|image|max:2048',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $validated['slug']        = Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        $wasPublished = $post->status === 'published';
        $willBePublished = $validated['status'] === 'published';

        if ($willBePublished && !$wasPublished) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        if ($willBePublished && !$wasPublished) {
            event(new PostPublished($post));
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $postTitle = $post->title;
        
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }
        
        $post->comments()->delete();
        $post->forceDelete();

        return redirect()->route('admin.posts.index')->with('success', '"' . $postTitle . '" deleted permanently!');
    }
}
