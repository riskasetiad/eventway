<?php
namespace App\Http\Controllers;

use Alert;
use App\Models\Event;
use Illuminate\Http\Request;

class PengajuanEventController extends Controller
{
    public function index()
    {
        $events = Event::with('penyelenggara')->latest()->get(); // Ambil semua event tanpa filter status
        return view('admin.pengajuan.index', compact('events'));
    }

    public function approve(Event $event)
    {
        $event->update(['status' => 'approved']);
        Alert::toast('Event Approved!', 'success')->autoClose(3000);
        return redirect()->route('admin.pengajuan.index');
    }

    public function reject(Request $request, Event $event)
    {
        $request->validate([
            'alasan' => 'required|string|max:255',
        ]);

        $event->update([
            'status' => 'Rejected',
            'alasan' => $request->input('alasan'), // Ambil alasan dari request
        ]);

        Alert::toast('Event Rejected!', 'success')->autoClose(3000);
        return redirect()->route('admin.pengajuan.index');
    }

}
