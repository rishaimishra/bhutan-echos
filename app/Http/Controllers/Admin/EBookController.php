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

    public function store(Request $request)
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

    public function update(Request $request, EBook $ebook)
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
} 