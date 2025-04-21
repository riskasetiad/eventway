<?php
namespace App\Http\Controllers;

use Alert;
use App\Models\Event;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = auth()->user()->can('view_admin')
        ? Event::with('kategoris')->latest()->get()
        : Event::with('kategoris')->where('user_id', auth()->id())->latest()->get();

        return view('admin.event.index', compact('events'));
    }

    public function indexapi()
    {
        $event = Event::with('kategoris')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Event',
            'events'  => $event,
        ]);
    }

    public function show($id)
    {
        $event = Event::with('kategoris', 'tikets')->find($id);

        if (! $event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        return response()->json($event, 200);
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.event.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        // Menentukan aturan validasi berdasarkan hak akses
        $tglMulaiRule = auth()->user()->can('view_admin')
        ? 'required|date'
        : 'required|date|after_or_equal:' . now()->addWeek()->format('Y-m-d');

        // Validasi input dari form
        $request->validate([
            'title'         => 'required|string|max:255',
            'image'         => 'required|image|mimes:jpeg,png,jpg|max:10240',
            'proposal'      => 'nullable|mimes:pdf|max:5120',
            'kategori_id'   => 'required|array|min:1',
            'kategori_id.*' => 'exists:kategoris,id',
            'tgl_mulai'     => $tglMulaiRule,
            'tgl_selesai'   => 'required|date|after_or_equal:tgl_mulai',
            'kota'          => 'required|string',
            'lokasi'        => 'required|string',
            'url_lokasi'    => 'required|url',
            'deskripsi'     => 'required|string',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
        ]);

        // Proses upload gambar
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads'), $imageName);
        $imagePath = 'uploads/' . $imageName;

        // Proses upload proposal (PDF) jika ada
        $proposalPath = null;
        if ($request->hasFile('proposal')) {
            $proposalName = time() . '.' . $request->proposal->extension();
            $request->proposal->move(public_path('proposals'), $proposalName);
            $proposalPath = 'proposals/' . $proposalName;
        }

        // Menyimpan data event ke database
        $event = Event::create([
            'user_id'       => Auth::id(),
            'image'         => $imagePath,
            'proposal'      => $proposalPath,
            'title'         => $request->title,
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

        // Menambahkan kategori yang dipilih ke event
        $event->kategoris()->attach($request->kategori_id);

        // Memberikan notifikasi sukses
        Alert::toast('Event berhasil ditambahkan!', 'success')->autoClose(3000);

        // Redirect ke halaman sesuai role pengguna
        return auth()->user()->can('view_admin')
        ? redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan!')
        : redirect()->route('events.index')->with('success', 'Event berhasil ditambahkan!');
    }

    public function edit(Event $event)
    {
        $kategoris = Kategori::all();
        return view('admin.event.edit', compact('event', 'kategoris'));
    }

    public function update(Request $request, Event $event)
    {
        $tglMulaiRule = auth()->user()->can('view_admin')
        ? 'required|date'
        : 'required|date|after_or_equal:' . now()->addWeek()->format('Y-m-d');

        $request->validate([
            'title'         => 'required|string|max:255',
            'kategori_id'   => 'required|array|min:1',
            'kategori_id.*' => 'exists:kategoris,id',
            'proposal'      => 'nullable|mimes:pdf|max:5120',
            'tgl_mulai'     => $tglMulaiRule,
            'tgl_selesai'   => 'required|date|after_or_equal:tgl_mulai',
            'kota'          => 'required|string',
            'lokasi'        => 'required|string',
            'url_lokasi'    => 'required|url',
            'deskripsi'     => 'required|string',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
        ]);

        if ($request->hasFile('image')) {
            if ($event->image && file_exists(public_path($event->image))) {
                unlink(public_path($event->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $imageName);
            $event->image = 'uploads/' . $imageName;
        }

        if ($request->hasFile('proposal')) {
            if ($event->proposal && file_exists(public_path($event->proposal))) {
                unlink(public_path($event->proposal));
            }

            $proposalName = time() . '.' . $request->proposal->extension();
            $request->proposal->move(public_path('proposals'), $proposalName);
            $event->proposal = 'proposals/' . $proposalName;
        }

        $event->update($request->except(['kategori_id', 'image', 'proposal']));
        $event->save();
        $event->kategoris()->sync($request->kategori_id);

        Alert::toast('Event berhasil diperbarui!', 'success')->autoClose(3000);
        return redirect()->route('events.index');
    }

    public function destroy(Event $event)
    {
        if ($event->image && file_exists(public_path($event->image))) {
            unlink(public_path($event->image));
        }

        if ($event->proposal && file_exists(public_path($event->proposal))) {
            unlink(public_path($event->proposal));
        }

        $event->delete();

        Alert::toast('Event berhasil dihapus!', 'success')->autoClose(3000);
        return redirect()->route('events.index');
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
            'alasan' => null,
        ]);

        Alert::toast('Event berhasil diajukan ulang!', 'success')->autoClose(3000);
        return redirect()->route('events.index');
    }
}
