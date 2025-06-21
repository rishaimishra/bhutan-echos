<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EBookController extends Controller
{
    public function index()
    {
        $ebooks = EBook::latest()->get()->map(function ($ebook) {
            $ebook->file_path = $ebook->file_path ? asset('storage/' . $ebook->file_path) : null;
            $ebook->cover_image = $ebook->cover_image ? asset('storage/' . $ebook->cover_image) : null;
            return $ebook;
        });
        return response()->json(['ebooks' => $ebooks]);
    }

    public function show(EBook $ebook)
    {
        $ebook->file_path = $ebook->file_path ? asset('storage/' . $ebook->file_path) : null;
        $ebook->cover_image = $ebook->cover_image ? asset('storage/' . $ebook->cover_image) : null;
        return response()->json(['ebook' => $ebook]);
    }
} 