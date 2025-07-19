<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TimelineEntry;
use Illuminate\Http\Request;

class TimelineEntryController extends Controller
{
    public function index()
    {
        $entries = TimelineEntry::latest()->get();

        // Map each entry to update media_url with full URL
        $entries->transform(function ($entry) {
            $entry->media_url = url($entry->media_url);
            return $entry;
        });

        return response()->json(['timeline_entries' => $entries]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'media_type' => 'required|in:image,video,text',
            'media_url' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:10240',
            'decade' => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('media_url')) {
            $file = $request->file('media_url');
            $fileName = 'timeline_media/' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('timeline_media'), $fileName);
            $validated['media_url'] = $fileName;
        } elseif ($request->media_url && $validated['media_type'] === 'text') {
            $validated['media_url'] = $request->media_url;
        }

        $validated['user_id'] = $user->id;

        $entry = TimelineEntry::create($validated);
        $entry->media_url = $entry->media_url ? url($entry->media_url) : null;

        return response()->json([
            'message' => 'Timeline entry created successfully.',
            'timeline_entry' => $entry,
        ], 201);
    }
}