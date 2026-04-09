<?php

namespace App\Http\Controllers;

use App\Models\ForumTopic;
use App\Models\ForumReply;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ForumController extends Controller
{
    public function index()
    {
        $topics = ForumTopic::where('is_published', true)
            ->latest()
            ->paginate(15);
        
        return view('public.forum.index', compact('topics'));
    }

    public function create()
    {
        return view('public.forum.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:5|max:200',
            'body' => 'required|min:10',
            'author_name' => 'nullable|max:50',
        ]);

        $topic = ForumTopic::create([
            'title' => $request->title,
            'body' => $request->body,
            'author_name' => $request->author_name ?: 'Anonymous',
            'is_published' => true,
        ]);

        return redirect()->route('forum.show', $topic->slug)
            ->with('success', 'Topic created successfully!');
    }

    public function show($slug)
    {
        $topic = ForumTopic::where('slug', $slug)->firstOrFail();
        
        return view('public.forum.show', compact('topic'));
    }

    public function reply(Request $request, $slug)
    {
        $topic = ForumTopic::where('slug', $slug)->firstOrFail();

        $request->validate([
            'body' => 'required|min:2',
            'author_name' => 'nullable|max:50',
        ]);

        $topic->replies()->create([
            'body' => $request->body,
            'author_name' => $request->author_name ?: 'Anonymous',
        ]);

        return redirect()->route('forum.show', $slug)
            ->with('success', 'Reply posted successfully!');
    }

    public function replyAjax(Request $request, $slug): JsonResponse
    {
        $topic = ForumTopic::where('slug', $slug)->firstOrFail();

        $request->validate([
            'body' => 'required|min:2',
            'author_name' => 'nullable|max:50',
        ]);

        $reply = $topic->replies()->create([
            'body' => $request->body,
            'author_name' => $request->author_name ?: 'Anonymous',
        ]);

        return response()->json([
            'success' => true,
            'reply' => [
                'id' => $reply->id,
                'author_name' => $reply->author_name,
                'body' => $reply->body,
                'created_at' => $reply->created_at->format('g:i A'),
                'is_even' => $topic->replies()->count() % 2 === 0,
            ]
        ]);
    }
}
