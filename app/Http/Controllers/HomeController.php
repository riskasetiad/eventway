<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            // Data dashboard untuk Admin
            $penyelenggara = User::role('User')->count();

            $eventBerlangsung = Event::where('tgl_mulai', '<=', now())
                ->where('tgl_selesai', '>=', now())
                ->count();

            $eventSelesai = Event::where('tgl_selesai', '<', now())->count();

            $statistik = [
                'total_event'   => Event::count(),
                'event_terjual' => Order::where('status_pembayaran', 'berhasil')->count(),
            ];

            return view('admin.dashboard.admin', compact('penyelenggara', 'eventBerlangsung', 'eventSelesai', 'statistik'));
        }

        if ($user->hasRole('User')) {
            // Data dashboard untuk User
            $eventIds = Event::where('user_id', $user->id)
                ->where('status', 'Approved')
                ->pluck('id');

            $jumlahEvent = $eventIds->count();

            $eventTerjual = Order::whereIn('tiket_id', function ($query) use ($eventIds) {
                $query->select('id')
                    ->from('tikets')
                    ->whereIn('event_id', $eventIds);
            })
                ->where('status_pembayaran', 'berhasil')
                ->count();

            $totalPendapatan = Order::whereIn('tiket_id', function ($query) use ($eventIds) {
                $query->select('id')
                    ->from('tikets')
                    ->whereIn('event_id', $eventIds);
            })
                ->where('status_pembayaran', 'berhasil')
                ->sum('total_harga');

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
