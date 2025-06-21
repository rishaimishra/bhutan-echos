<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TimelineEntry;
use Illuminate\Http\Request;

class TimelineEntryController extends Controller
{
    public function index()
    {
        $entries = TimelineEntry::latest()->get();

        // Map each entry to update media_url with full URL
        $entries->transform(function ($entry) {
            $entry->media_url = url($entry->media_url);
            return $entry;
        });

        return response()->json(['timeline_entries' => $entries]);
    }
}