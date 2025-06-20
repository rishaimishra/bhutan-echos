<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimelineEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TimelineEntryController extends Controller
{
    public function index()
    {
        $entries = TimelineEntry::latest()->paginate(10);
        $stats = [
            'total' => TimelineEntry::count(),
            'by_type' => [
                'image' => TimelineEntry::where('media_type', 'image')->count(),
                'video' => TimelineEntry::where('media_type', 'video')->count(),
                'text' => TimelineEntry::where('media_type', 'text')->count(),
            ],
            'by_decade' => TimelineEntry::select('decade')
                ->distinct()
                ->pluck('decade')
                ->count()
        ];

        return view('admin.timeline.index', compact('entries', 'stats'));
    }

    public function create()
    {
        return view('admin.timeline.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'media_type' => 'required|in:image,video,text',
            'media_url' => 'nullable|url',
            'decade' => 'nullable|string|max:50',
            'media_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4|max:10240'
        ]);

        if ($request->hasFile('media_file')) {
            $path = $request->file('media_file')->store('timeline', 'public');
            $validated['media_url'] = Storage::url($path);
        }

        TimelineEntry::create($validated);

        return redirect()
            ->route('admin.timeline.index')
            ->with('success', 'Timeline entry created successfully.');
    }

    public function show(TimelineEntry $timeline)
    {
        return view('admin.timeline.show', compact('timeline'));
    }

    public function edit(TimelineEntry $timeline)
    {
        return view('admin.timeline.edit', compact('timeline'));
    }

    public function update(Request $request, TimelineEntry $timeline)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'media_type' => 'required|in:image,video,text',
            'media_url' => 'nullable|url',
            'decade' => 'nullable|string|max:50',
            'media_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4|max:10240'
        ]);

        if ($request->hasFile('media_file')) {
            // Delete old file if exists
            if ($timeline->media_url) {
                $oldPath = str_replace('/storage/', '', $timeline->media_url);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('media_file')->store('timeline', 'public');
            $validated['media_url'] = Storage::url($path);
        }

        $timeline->update($validated);

        return redirect()
            ->route('admin.timeline.index')
            ->with('success', 'Timeline entry updated successfully.');
    }

    public function destroy(TimelineEntry $timeline)
    {
        // Delete media file if exists
        if ($timeline->media_url) {
            $path = str_replace('/storage/', '', $timeline->media_url);
            Storage::disk('public')->delete($path);
        }

        $timeline->delete();

        return redirect()
            ->route('admin.timeline.index')
            ->with('success', 'Timeline entry deleted successfully.');
    }
} 