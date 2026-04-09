<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumTopic;
use App\Models\ForumReply;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function topics()
    {
        $topics = ForumTopic::latest()->paginate(20);
        return view('admin.forum.topics', compact('topics'));
    }

    public function topicDestroy(ForumTopic $topic)
    {
        $topic->replies()->delete();
        $topic->delete();
        return back()->with('success', 'Topic deleted successfully');
    }

    public function topicToggle(ForumTopic $topic)
    {
        $topic->update(['is_published' => !$topic->is_published]);
        return back()->with('success', 'Topic status updated');
    }

    public function replies()
    {
        $replies = ForumReply::with('topic')->latest()->paginate(20);
        return view('admin.forum.replies', compact('replies'));
    }

    public function replyDestroy(ForumReply $reply)
    {
        $reply->delete();
        return back()->with('success', 'Reply deleted successfully');
    }
}
