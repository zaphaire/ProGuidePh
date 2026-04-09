<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(15);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'style'    => 'required|in:info,warning,success,danger,premium',
            'animation_type' => 'required|in:none,fade,slide-down,pulse,shimmer,bounce,marquee',
            'is_active' => 'boolean',
            'start_at' => 'nullable|date',
            'end_at'   => 'nullable|date|after_or_equal:start_at',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Announcement::create($validated);
        return redirect()->route('admin.announcements.index')->with('success', 'Announcement created!');
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'style'    => 'required|in:info,warning,success,danger,premium',
            'animation_type' => 'required|in:none,fade,slide-down,pulse,shimmer,bounce,marquee',
            'is_active' => 'boolean',
            'start_at' => 'nullable|date',
            'end_at'   => 'nullable|date|after_or_equal:start_at',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $announcement->update($validated);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement updated!');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('admin.announcements.index')->with('success', 'Announcement deleted!');
    }
}
