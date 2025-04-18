<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Tiket;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            // Data dashboard untuk Admin
            $penyelenggara = User::count();

            $eventBerlangsung = Event::where('tgl_mulai', '<=', now())
                ->where('tgl_selesai', '>=', now())
                ->count();

            $eventSelesai = Event::where('tgl_selesai', '<', now())->count();

            $statistik = [
                'total_event'   => Event::count(),
                'event_terjual' => Tiket::where('status', 'terjual')->count(),
            ];

            return view('admin.dashboard.admin', compact('penyelenggara', 'eventBerlangsung', 'eventSelesai', 'statistik'));
        }

        if ($user->hasRole('User')) {
            // Data dashboard untuk User
            $jumlahEvent = Event::where('user_id', $user->id)->count();

            $eventIds        = Event::where('user_id', $user->id)->pluck('id');
            $eventTerjual    = Tiket::whereIn('event_id', $eventIds)->where('status', 'terjual')->count();
            $totalPendapatan = Tiket::whereIn('event_id', $eventIds)->where('status', 'terjual')->sum('harga');

            $statistikPenjualan = [
                'event_terjual'    => $eventTerjual,
                'total_pendapatan' => $totalPendapatan,
            ];

            return view('admin.dashboard.user', compact('jumlahEvent', 'statistikPenjualan'));
        }

        // Default fallback
        return redirect('/')->with('error', 'Role tidak dikenali.');
    }
}
