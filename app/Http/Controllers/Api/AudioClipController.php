<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AudioClip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AudioClipController extends Controller
{
    public function index()
    {
        $audioClips = AudioClip::latest()->get()->map(function ($clip) {
            $clip->audio_url = $clip->audio_url ? asset($clip->audio_url) : null;
            return $clip;
        });
        return response()->json(['audio_clips' => $audioClips]);
    }

    public function download(Request $request, $id)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        $audio = \App\Models\AudioClip::findOrFail($id);
        if (!$audio->audio_url) {
            return response()->json(['message' => 'Audio file not found.'], 404);
        }
        $path = str_replace('/storage/', '', $audio->audio_url);
        if (!Storage::disk('public')->exists($path)) {
            return response()->json(['message' => 'Audio file not found in storage.'], 404);
        }
        $filename = $audio->title . '.' . pathinfo($path, PATHINFO_EXTENSION);
        return Storage::disk('public')->download($path, $filename);
    }
} 