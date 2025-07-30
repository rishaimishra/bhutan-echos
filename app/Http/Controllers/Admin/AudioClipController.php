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

    public function storeOld(Request $request)
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

    public function updateOld(Request $request, AudioClip $audio)
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






    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'media_type' => 'required|in:audio,video,image,text',
            'media_file' => 'nullable|file|max:10240',
            'media_files.*' => 'nullable|file|max:10240|image',
            'release_date' => 'required|date'
        ]);

        $type = $request->media_type;
        $validated['media_type'] = $type;

        // Handle file uploads
        if ($type === 'text') {
            $validated['media_url'] = null;
        } elseif ($type === 'image' && $request->hasFile('media_files')) {
            $paths = [];
            foreach ($request->file('media_files') as $file) {
                $paths[] = Storage::url($file->store("media-clips/$type", 'public'));
            }
            $validated['media_url'] = json_encode($paths);
        } elseif ($request->hasFile('media_file')) {
            $file = $request->file('media_file');
            $path = $file->store("media-clips/$type", 'public');
            $validated['media_url'] = Storage::url($path);
        } elseif ($type !== 'text') {
            return back()->withErrors(['media_file' => 'Media file is required for this type'])->withInput();
        }

        AudioClip::create($validated);
        return redirect()->route('admin.audio.index')->with('success', 'Content created successfully.');
    }

    public function update(Request $request, AudioClip $audio)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'media_type' => 'required|in:audio,video,image,text',
            'media_file' => 'nullable|file|max:10240',
            'media_files.*' => 'nullable|file|max:10240|image',
            'release_date' => 'required|date'
        ]);

        $type = $request->media_type;
        $validated['media_type'] = $type;

        // Handle file uploads
        if ($type === 'text') {
            $this->deleteOldMedia($audio);
            $validated['media_url'] = null;
        } elseif ($type === 'image' && $request->hasFile('media_files')) {
            $this->deleteOldMedia($audio);
            $paths = [];
            foreach ($request->file('media_files') as $file) {
                $paths[] = Storage::url($file->store("media-clips/$type", 'public'));
            }
            $validated['media_url'] = json_encode($paths);
        } elseif ($request->hasFile('media_file')) {
            $this->deleteOldMedia($audio);
            $path = $request->file('media_file')->store("media-clips/$type", 'public');
            $validated['media_url'] = Storage::url($path);
        } elseif ($type !== 'text') {
            // Keep existing media if not changing
            $validated['media_url'] = $audio->media_url;
        }

        $audio->update($validated);
        return redirect()->route('admin.audio.index')->with('success', 'Content updated successfully.');
    }

    protected function deleteOldMedia($audio)
    {
        if (!$audio->media_url) return;

        if ($audio->media_type === 'image') {
            $paths = json_decode($audio->media_url, true) ?: [];
            foreach ($paths as $path) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $path));
            }
        } else {
            Storage::disk('public')->delete(str_replace('/storage/', '', $audio->media_url));
        }
    }

    

    


} 