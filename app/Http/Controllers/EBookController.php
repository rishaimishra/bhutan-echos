<?php

namespace App\Http\Controllers;

use App\Models\EBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EBookController extends Controller
{
    public function index()
    {
        $ebooks = EBook::latest()->paginate(12);
        return view('ebooks.index', compact('ebooks'));
    }

    public function download(EBook $ebook)
    {
        if (!Storage::disk('public')->exists($ebook->file_path)) {
            abort(404);
        }
        return Storage::disk('public')->download($ebook->file_path, $ebook->title . '.' . $ebook->format);
    }
} 