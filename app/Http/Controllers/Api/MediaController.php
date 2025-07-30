<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AudioClip;
use App\Models\EBook;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    // public function index()
    // {
    //     $audioClips = AudioClip::latest()->get()->map(function ($clip) {
    //         $clip->audio_url = $clip->audio_url ? asset($clip->audio_url) : null;
    //         $clip->type = 'audio';
    //         return $clip;
    //     })->values();
    //     $ebooks = EBook::latest()->get()->map(function ($ebook) {
    //         $ebook->file_path = $ebook->file_path ? asset('storage/' . $ebook->file_path) : null;
    //         $ebook->cover_image = $ebook->cover_image ? asset('storage/' . $ebook->cover_image) : null;
    //         $ebook->type = 'ebook';
    //         return $ebook;
    //     })->values();

    //     $max = max($audioClips->count(), $ebooks->count());
    //     $combined = [];
    //     for ($i = 0; $i < $max; $i++) {
    //         if (isset($audioClips[$i])) {
    //             $combined[] = $audioClips[$i];
    //         }
    //         if (isset($ebooks[$i])) {
    //             $combined[] = $ebooks[$i];
    //         }
    //     }

    //     return response()->json([
    //         'media' => $combined
    //     ]);
    // }




// for ebook or resource
     public function index()
    {
        $audioClips = EBook::latest()->get();
        return response()->json([
            'media' => $audioClips
        ]);
    }
} 