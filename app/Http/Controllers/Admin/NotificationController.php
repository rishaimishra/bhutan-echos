<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->paginate(10);
        $stats = [
            'total' => Notification::count(),
            'scheduled' => Notification::where('sent', false)->count(),
            'sent' => Notification::where('sent', true)->count(),
            'recent' => Notification::latest()->take(5)->get()
        ];

        return view('admin.notifications.index', compact('notifications', 'stats'));
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        $notification = Notification::create($validated);

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'Notification scheduled successfully.');
    }

    public function show(Notification $notification)
    {
        return view('admin.notifications.show', compact('notification'));
    }

    public function edit(Notification $notification)
    {
        if ($notification->sent) {
            return redirect()
                ->route('admin.notifications.index')
                ->with('error', 'Cannot edit a notification that has already been sent.');
        }

        return view('admin.notifications.edit', compact('notification'));
    }

    public function update(Request $request, Notification $notification)
    {
        if ($notification->sent) {
            return redirect()
                ->route('admin.notifications.index')
                ->with('error', 'Cannot update a notification that has already been sent.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        $notification->update($validated);

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'Notification updated successfully.');
    }

    public function destroy(Notification $notification)
    {
        if ($notification->sent) {
            return redirect()
                ->route('admin.notifications.index')
                ->with('error', 'Cannot delete a notification that has already been sent.');
        }

        $notification->delete();

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'Notification deleted successfully.');
    }

    public function sendNow(Notification $notification)
    {
        if ($notification->sent) {
            return redirect()
                ->route('admin.notifications.index')
                ->with('error', 'This notification has already been sent.');
        }

        // Get all users
        $users = User::all();

        // Send notification to each user
        foreach ($users as $user) {
            Mail::to($user->email)->send(new \App\Mail\NotificationMail($notification));
        }

        // Mark notification as sent
        $notification->update([
            'sent' => true,
            'scheduled_at' => now()
        ]);

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'Notification sent successfully to all users.');
    }
} 