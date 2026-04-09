<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $posts      = Post::with('user')->published()->where('category_id', $category->id)->latest('published_at')->paginate(9);
        $categories = Category::withCount('publishedPosts')->orderBy('order')->get();

        return view('public.categories.show', compact('category', 'posts', 'categories'));
    }
}
