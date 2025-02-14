<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function showSubmissions()
{
    $notifications = auth()->user()->unreadNotifications;
    $events = Event::whereIn('status', ['Pending', 'Approved', 'Rejected'])->get();
    return view('admin.submissions', compact('notifications', 'events'));
}

public function markAsRead($id)
{
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->markAsRead();
    return back()->with('success', 'Notifikasi ditandai sebagai sudah dibaca.');
}

public function updateStatus(Request $request, Event $event)
{
    $request->validate([
        'status' => 'required|in:Pending,Approved,Rejected',
    ]);

    $event->status = $request->status;
    $event->save();

    return back()->with('success', 'Status event berhasil diperbarui.');
}
}
