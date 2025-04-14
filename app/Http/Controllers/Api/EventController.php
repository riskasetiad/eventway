<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('kategori')->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Event',
            'data'    => $events,
        ]);
    }

    public function show($id)
    {
        $event = Event::with('kategori')->find($id);

        if (! $event) {
            return response()->json([
                'success' => false,
                'message' => 'Event tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $event,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'image'         => 'required|image|mimes:jpeg,png,jpg|max:10240',
            'kategori_id'   => 'required|exists:kategoris,id',
            'tgl_mulai'     => 'required|date',
            'tgl_selesai'   => 'required|date|after_or_equal:tgl_mulai',
            'kota'          => 'required|string',
            'lokasi'        => 'required|string',
            'url_lokasi'    => 'required|url',
            'deskripsi'     => 'required|string',
            'waktu_mulai'   => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads'), $imageName);
        $imagePath = 'uploads/' . $imageName;

        $event = Event::create([
            'user_id'       => Auth::id(),
            'image'         => $imagePath,
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

        return response()->json([
            'success' => true,
            'message' => 'Event berhasil dibuat',
            'data'    => $event,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        if (! $event) {
            return response()->json([
                'success' => false,
                'message' => 'Event tidak ditemukan',
            ], 404);
        }

        $request->validate([
            'title'         => 'required|string|max:255',
            'kategori_id'   => 'required|exists:kategoris,id',
            'tgl_mulai'     => 'required|date',
            'tgl_selesai'   => 'required|date|after_or_equal:tgl_mulai',
            'kota'          => 'required|string',
            'lokasi'        => 'required|string',
            'url_lokasi'    => 'required|url',
            'deskripsi'     => 'required|string',
            'waktu_mulai'   => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
        ]);

        if ($request->hasFile('image')) {
            if ($event->image && file_exists(public_path($event->image))) {
                unlink(public_path($event->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $imageName);
            $event->image = 'uploads/' . $imageName;
        }

        $event->update($request->except('image'));

        return response()->json([
            'success' => true,
            'message' => 'Event berhasil diperbarui',
            'data'    => $event,
        ]);
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        if (! $event) {
            return response()->json([
                'success' => false,
                'message' => 'Event tidak ditemukan',
            ], 404);
        }

        if ($event->image && file_exists(public_path($event->image))) {
            unlink(public_path($event->image));
        }

        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event berhasil dihapus',
        ]);
    }

    public function yourEvent()
    {
        $userId = auth()->id();
        $events = Event::where('user_id', $userId)->get();

        return response()->json([
            'events' => $events,
        ]);
    }
}
