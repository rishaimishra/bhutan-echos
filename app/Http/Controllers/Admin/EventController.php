<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest()->paginate(20);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            // 'icon' => 'required|image|dimensions:width=500,height=500',
            // 'banner_images.*' => 'image',
            // 'description' => 'required|string',
            // 'start_date' => 'required|date',
            // 'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        dd($validated);

        // Handle icon upload
        $iconPath = $request->file('icon')->store('events/icons', 'public');

        // Handle banner images upload
        $bannerPaths = [];
        if ($request->hasFile('banner_images')) {
            foreach ($request->file('banner_images') as $banner) {
                $bannerPaths[] = $banner->store('events/banners', 'public');
            }
        }

        $event = Event::create([
            'title' => $validated['title'],
            'icon' => $iconPath,
            'banner_images' => $bannerPaths,
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|image|dimensions:width=500,height=500',
            'banner_images.*' => 'image',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Handle icon upload
        if ($request->hasFile('icon')) {
            // Delete old icon
            if ($event->icon) {
                Storage::disk('public')->delete($event->icon);
            }
            $iconPath = $request->file('icon')->store('events/icons', 'public');
        } else {
            $iconPath = $event->icon;
        }

        // Handle banner images upload
        $bannerPaths = $event->banner_images ?? [];
        if ($request->hasFile('banner_images')) {
            // Optionally delete old banners if you want
            foreach ($bannerPaths as $oldBanner) {
                Storage::disk('public')->delete($oldBanner);
            }
            $bannerPaths = [];
            foreach ($request->file('banner_images') as $banner) {
                $bannerPaths[] = $banner->store('events/banners', 'public');
            }
        }

        $event->update([
            'title' => $validated['title'],
            'icon' => $iconPath,
            'banner_images' => $bannerPaths,
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Delete icon and banners
        if ($event->icon) {
            Storage::disk('public')->delete($event->icon);
        }
        if ($event->banner_images) {
            foreach ($event->banner_images as $banner) {
                Storage::disk('public')->delete($banner);
            }
        }
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
