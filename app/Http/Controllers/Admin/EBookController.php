<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EBookController extends Controller
{
    public function index()
    {
        $ebooks = EBook::latest()->paginate(10);
        return view('admin.ebooks.index', compact('ebooks'));
    }

    public function create()
    {
        return view('admin.ebooks.create');
    }

    public function storeOld(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,epub|max:20480', // 20MB max
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096', // 4MB max
        ]);

        $file = $request->file('file');
        $format = $file->getClientOriginalExtension();
        $path = $file->store('ebooks', 'public');

        $cover = $request->file('cover_image');
        $coverPath = $cover->store('ebook_covers', 'public');

        EBook::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'file_path' => $path,
            'format' => $format,
            'cover_image' => $coverPath,
        ]);

        return redirect()->route('admin.ebooks.index')->with('success', 'E-Book uploaded successfully.');
    }

    public function edit(EBook $ebook)
    {
        return view('admin.ebooks.edit', compact('ebook'));
    }

    public function updateOld(Request $request, EBook $ebook)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,epub|max:20480',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $data = [
            'title' => $validated['title'],
            'author' => $validated['author'],
        ];

        if ($request->hasFile('file')) {
            if ($ebook->file_path && Storage::disk('public')->exists($ebook->file_path)) {
                Storage::disk('public')->delete($ebook->file_path);
            }
            $file = $request->file('file');
            $data['format'] = $file->getClientOriginalExtension();
            $data['file_path'] = $file->store('ebooks', 'public');
        }

        if ($request->hasFile('cover_image')) {
            if ($ebook->cover_image && Storage::disk('public')->exists($ebook->cover_image)) {
                Storage::disk('public')->delete($ebook->cover_image);
            }
            $cover = $request->file('cover_image');
            $data['cover_image'] = $cover->store('ebook_covers', 'public');
        }

        $ebook->update($data);

        return redirect()->route('admin.ebooks.index')->with('success', 'E-Book updated successfully.');
    }

    public function destroy(EBook $ebook)
    {
        if ($ebook->file_path && Storage::disk('public')->exists($ebook->file_path)) {
            Storage::disk('public')->delete($ebook->file_path);
        }
        $ebook->delete();
        return redirect()->route('admin.ebooks.index')->with('success', 'E-Book deleted successfully.');
    }








    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,epub,mp3,wav,aac,ogg,flac|max:20480', // 20MB max
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096', // 4MB max
        ]);

        // Handle file upload
        $file = $request->file('file');
        $format = strtolower($file->getClientOriginalExtension());
        
        // Determine file type and storage folder
        $type = in_array($format, ['pdf', 'epub']) ? 'ebook' : 'audio';
        $folder = $type === 'ebook' ? 'ebooks' : 'audios';
        $filePath = $file->store($folder, 'public');

        // Handle cover image upload
        $cover = $request->file('cover_image');
        $coverPath = $cover->store('ebook_covers', 'public');

        // Create new record
        EBook::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'file_path' => $filePath,
            'format' => $format,
            'type' => $type,
            'cover_image' => $coverPath,
        ]);

        return redirect()->route('admin.ebooks.index')->with('success', 'File uploaded successfully.');
    }

    
    public function update(Request $request, EBook $ebook)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,epub,mp3,wav,aac,ogg,flac|max:20480',
            'cover_image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $data = [
            'title' => $validated['title'],
            'author' => $validated['author'],
        ];

        // Handle file upload if provided
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($ebook->file_path && Storage::disk('public')->exists($ebook->file_path)) {
                Storage::disk('public')->delete($ebook->file_path);
            }

            $file = $request->file('file');
            $format = strtolower($file->getClientOriginalExtension());
            $type = in_array($format, ['pdf', 'epub']) ? 'ebook' : 'audio';
            $folder = $type === 'ebook' ? 'ebooks' : 'audios';
            $filePath = $file->store($folder, 'public');

            $data['file_path'] = $filePath;
            $data['format'] = $format;
            $data['type'] = $type;
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover if exists
            if ($ebook->cover_image && Storage::disk('public')->exists($ebook->cover_image)) {
                Storage::disk('public')->delete($ebook->cover_image);
            }

            $cover = $request->file('cover_image');
            $data['cover_image'] = $cover->store('ebook_covers', 'public');
        }

        $ebook->update($data);

        return redirect()->route('admin.ebooks.index')->with('success', 'File updated successfully.');
    }

   

  
} 