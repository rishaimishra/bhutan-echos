<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AudioClip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AudioClipController extends Controller
{
    public function index()
    {
        $clips = AudioClip::latest()->paginate(10);
        $stats = [
            'total' => AudioClip::count(),
            'this_month' => AudioClip::whereMonth('release_date', now()->month)->count(),
            'this_year' => AudioClip::whereYear('release_date', now()->year)->count()
        ];

        return view('admin.audio.index', compact('clips', 'stats'));
    }

    public function create()
    {
        return view('admin.audio.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'audio_file' => 'required|file|mimes:mp3,wav|max:10240',
            'release_date' => 'required|date'
        ]);

        if ($request->hasFile('audio_file')) {
            $path = $request->file('audio_file')->store('audio-clips', 'public');
            $validated['audio_url'] = Storage::url($path);
        }

        AudioClip::create($validated);

        return redirect()
            ->route('admin.audio.index')
            ->with('success', 'Audio clip added successfully.');
    }

    public function show(AudioClip $audio)
    {
        return view('admin.audio.show', compact('audio'));
    }

    public function edit(AudioClip $audio)
    {
        return view('admin.audio.form', compact('audio'));
    }

    public function update(Request $request, AudioClip $audio)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'audio_file' => 'nullable|file|mimes:mp3,wav|max:10240',
            'release_date' => 'required|date'
        ]);

        if ($request->hasFile('audio_file')) {
            // Delete old file if exists
            if ($audio->audio_url) {
                $oldPath = str_replace('/storage/', '', $audio->audio_url);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('audio_file')->store('audio-clips', 'public');
            $validated['audio_url'] = Storage::url($path);
        }

        $audio->update($validated);

        return redirect()
            ->route('admin.audio.index')
            ->with('success', 'Audio clip updated successfully.');
    }

    public function destroy(AudioClip $audio)
    {
        // Delete audio file if exists
        if ($audio->audio_url) {
            $path = str_replace('/storage/', '', $audio->audio_url);
            Storage::disk('public')->delete($path);
        }

        $audio->delete();

        return redirect()
            ->route('admin.audio.index')
            ->with('success', 'Audio clip deleted successfully.');
    }
} 