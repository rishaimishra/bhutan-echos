<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tribute;
use Illuminate\Http\Request;

class TributeController extends Controller
{
    public function index()
    {
        $tributes = Tribute::with('user')->latest()->paginate(10);
        $stats = [
            'total' => Tribute::count(),
            'pending' => Tribute::where('approved', false)->count(),
            'approved' => Tribute::where('approved', true)->count(),
            'by_type' => [
                'poem' => Tribute::where('type', 'poem')->count(),
                'artwork' => Tribute::where('type', 'artwork')->count(),
                'blessing' => Tribute::where('type', 'blessing')->count(),
                'voice_note' => Tribute::where('type', 'voice_note')->count(),
            ]
        ];

        return view('admin.tributes.index', compact('tributes', 'stats'));
    }

    public function show(Tribute $tribute)
    {
        $tribute->load('user');
        return view('admin.tributes.show', compact('tribute'));
    }

    public function approve(Tribute $tribute)
    {
        $tribute->update(['approved' => true]);

        return redirect()
            ->route('admin.tributes.index')
            ->with('success', 'Tribute has been approved successfully.');
    }

    public function reject(Tribute $tribute)
    {
        $tribute->update(['approved' => false]);

        return redirect()
            ->route('admin.tributes.index')
            ->with('success', 'Tribute has been rejected.');
    }

    public function destroy(Tribute $tribute)
    {
        // Delete the media file if it exists
        if ($tribute->media_path && file_exists(public_path($tribute->media_path))) {
            unlink(public_path($tribute->media_path));
        }

        $tribute->delete();

        return redirect()
            ->route('admin.tributes.index')
            ->with('success', 'Tribute has been deleted successfully.');
    }
} 