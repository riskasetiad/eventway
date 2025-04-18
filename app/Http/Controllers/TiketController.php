<?php
namespace App\Http\Controllers;

use Alert;
use App\Models\Event;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TiketController extends Controller
{
    public function index()
    {
        $tikets = Tiket::whereHas('event', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();
        return view('admin.tiket.index', compact('tikets'));
    }

    public function create()
    {
        $events = Event::where('status', 'approved')
            ->where('user_id', auth()->id()) // Hanya event milik user
            ->get();

        return view('admin.tiket.create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => [
                'required',
                Rule::exists('events', 'id')
                    ->where('status', 'approved')
                    ->where('user_id', auth()->id()), // Hanya event milik user
            ],
            'title'    => 'required|string|max:255',
            'harga'    => 'required|integer|min:0',
            'stok'     => 'required|integer|min:1',
            'status'   => 'required|in:tersedia,habis',
        ], [
            'event_id.required' => 'Event wajib dipilih.',
            'event_id.exists'   => 'Event tidak valid atau belum disetujui.',

            'title.required'    => 'Judul tiket wajib diisi.',
            'title.string'      => 'Judul tiket harus berupa teks.',
            'title.max'         => 'Judul tiket maksimal 255 karakter.',

            'harga.required'    => 'Harga tiket wajib diisi.',
            'harga.integer'     => 'Harga tiket harus berupa angka.',
            'harga.min'         => 'Harga tiket tidak boleh negatif.',

            'stok.required'     => 'Stok tiket wajib diisi.',
            'stok.integer'      => 'Stok tiket harus berupa angka.',
            'stok.min'          => 'Stok tiket minimal 1.',

            'status.required'   => 'Status tiket wajib dipilih.',
            'status.in'         => 'Status tiket harus antara "tersedia" atau "habis".',
        ]);

        Tiket::create($request->all());

        Alert::toast('Tiket berhasil ditambahkan!', 'success')->autoClose(3000);
        return redirect()->route('tiket.index');
    }

    public function show(Tiket $tiket)
    {
        return view('admin.tiket.show', compact('tiket'));
    }

    public function edit(Tiket $tiket)
    {
        $events = Event::where('status', 'approved')
            ->where('user_id', auth()->id()) // Hanya event milik user
            ->get();

        return view('admin.tiket.edit', compact('tiket', 'events'));
    }
    public function update(Request $request, Tiket $tiket)
    {
        $request->validate([
            'event_id' => [
                'required',
                Rule::exists('events', 'id')
                    ->where('status', 'approved')
                    ->where('user_id', auth()->id()), // Hanya event milik user
            ],
            'title'    => 'required|string|max:255',
            'harga'    => 'required|integer',
            'stok'     => 'required|integer',
            'status'   => 'required|in:tersedia,habis',
        ]);

        $tiket->update($request->all());

        Alert::toast('Tiket berhasil diperbarui!', 'success')->autoClose(3000);
        return redirect()->route('tiket.index');
    }

    public function destroy(Tiket $tiket)
    {
        $tiket->delete();

        Alert::toast('Tiket berhasil dihapus!', 'success')->autoClose(3000);
        return redirect()->route('tiket.index');
    }
}
