<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AudioClip;
use Illuminate\Http\Request;

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
} 