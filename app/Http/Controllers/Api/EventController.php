<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get()->map(function ($event) {
            $event->icon = $event->icon ? asset('storage/' . $event->icon) : null;
            $event->banner_images = $event->banner_images ? array_map(fn($img) => asset('storage/' . $img), $event->banner_images) : [];
            $event->is_featured = (bool) $event->is_featured;
            return $event;
        });
        return response()->json(['events' => $events]);
    }

    public function show(Event $event)
    {
        $event->icon = $event->icon ? asset('storage/' . $event->icon) : null;
        $event->banner_images = $event->banner_images ? array_map(fn($img) => asset('storage/' . $img), $event->banner_images) : [];
        $event->is_featured = (bool) $event->is_featured;
        return response()->json(['event' => $event]);
    }
} 