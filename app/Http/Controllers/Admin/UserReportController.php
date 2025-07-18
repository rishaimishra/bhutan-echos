<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserReport;
use Illuminate\Http\Request;
use App\Models\User;

class UserReportController extends Controller
{
    public function index()
    {
        $reports = UserReport::with(['reporter', 'reported'])->latest()->paginate(20);
        return view('admin.user_reports.index', compact('reports'));
    }

    public function block($userId)
    {
        $user = User::findOrFail($userId);
        $user->blocked = true;
        $user->save();
        return redirect()->back()->with('success', 'User blocked successfully.');
    }

    public function unblock($userId)
    {
        $user = User::findOrFail($userId);
        $user->blocked = false;
        $user->save();
        return redirect()->back()->with('success', 'User unblocked successfully.');
    }
}
