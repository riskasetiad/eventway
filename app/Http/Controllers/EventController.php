<?php
namespace App\Http\Controllers;

use Alert;
use App\Models\Event;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// Import notifikasi

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('kategori')->latest()->get();
        return view('admin.event.index', compact('events'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.event.create', compact('kategoris'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title'         => 'required|string|max:255',
            'image'         => 'required|image|mimes:jpeg,png,jpg|max:10240',
            'kategori_id'   => 'required',
            'tgl_mulai'     => 'required|date',
            'tgl_selesai'   => 'required|date|after_or_equal:tgl_mulai',
            'kota'          => 'required|string',
            'lokasi'        => 'required|string',
            'url_lokasi'    => 'required|url',
            'deskripsi'     => 'required|string',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads'), $imageName);

        $event = Event::create([
            'user_id'       => Auth::id() ?? 1,
            'image'         => 'uploads/' . $imageName,
            'title'         => $request->title,
            'kategori_id'   => $request->kategori_id,
            'tgl_mulai'     => $request->tgl_mulai,
            'tgl_selesai'   => $request->tgl_selesai,
            'kota'          => $request->kota,
            'lokasi'        => $request->lokasi,
            'url_lokasi'    => $request->url_lokasi,
            'deskripsi'     => $request->deskripsi,
            'waktu_mulai'   => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'status'        => 'Pending',
            'slug'          => Str::slug($request->title),
        ]);

        // // Kirim notifikasi ke semua admin
        // $admins = User::where('role', 'admin')->get();
        // foreach ($admins as $admin) {
        //     $admin->notify(new EventSubmissionNotification($event));
        // }

        Alert::toast('Event berhasil ditambahkan!', 'success')->autoClose(3000);
        return redirect()->route('events.index');
    }

    public function edit(Event $event)
    {
        $kategoris = Kategori::all();
        return view('admin.event.edit', compact('event', 'kategoris'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'kategori_id'   => 'required',
            'tgl_mulai'     => 'required|date',
            'tgl_selesai'   => 'required|date|after_or_equal:tgl_mulai',
            'kota'          => 'required|string',
            'lokasi'        => 'required|string',
            'url_lokasi'    => 'required|url',
            'deskripsi'     => 'required',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
        ]);

        if ($request->hasFile('image')) {
            if ($event->image && file_exists(public_path($event->image))) {
                unlink(public_path($event->image)); // Hapus gambar lama
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $imageName);
            $event->image = 'uploads/' . $imageName;
        }

        $event->update($request->except('image'));

        Alert::toast('Event berhasil diperbarui!', 'success')->autoClose(3000);
        return redirect()->route('admin.events.index');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        Alert::toast('Event berhasil dihapus!', 'success')->autoClose(3000);
        return redirect()->route('admin.events.index');
    }

    public function reapply(Event $event)
    {
        if (auth()->id() !== $event->user_id) {
            abort(403, 'Anda tidak memiliki izin untuk mengajukan ulang event ini.');
        }

        if ($event->status !== 'Rejected') {
            return back()->with('error', 'Event ini tidak dapat diajukan ulang.');
        }

        $event->update([
            'status' => 'Pending',
            'alasan' => null, // Hapus alasan penolakan
        ]);

        Alert::toast('Event berhasil diajukan ulang!', 'success')->autoClose(3000);
        return redirect()->route('events.index');
    }

}
