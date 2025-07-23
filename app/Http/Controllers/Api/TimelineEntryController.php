<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TimelineEntry;
use Illuminate\Http\Request;

class TimelineEntryController extends Controller
{
    public function index()
    {
        $entries = TimelineEntry::with('user')->latest()->get();

        // Map each entry to update media_url with full URL and include user name and image
        $entries->transform(function ($entry) {
            $entry->media_url = $entry->media_url ? url($entry->media_url) : null;
            $entry->user_name = $entry->user ? $entry->user->name : null;
            $entry->user_image = $entry->user && $entry->user->user_image ? url($entry->user->user_image) : null;
            return $entry;
        });

        return response()->json(['timeline_entries' => $entries]);
    }

    public function store(Request $request)
    {
        try {
            $user = $request->user();
            \Log::info('TimelineEntry store request', $request->all());
            $validated = $request->validate([
                'title' => 'nullable|string|max:255',
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
        } catch (\Exception $e) {
            \Log::error('TimelineEntry store error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return response()->json([
                'message' => 'An error occurred while creating the timeline entry.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}