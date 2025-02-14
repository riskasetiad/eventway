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
        $tikets = Tiket::with('event')->get();
        return view('admin.tiket.index', compact('tikets'));
    }

    public function create()
    {
        $events = Event::where('status', 'approved')->get(); // Hanya event yang disetujui
        return view('admin.tiket.create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => [
                'required',
                Rule::exists('events', 'id')->where('status', 'approved'),
            ], 'title' => 'required|string|max:255',
            'harga'    => 'required|integer',
            'stok'     => 'required|integer',
            'status'   => 'required|in:tersedia,habis',
        ]);

        Tiket::create($request->all());

        Alert::toast('Tiket berhasil ditambahkan!', 'success')->autoClose(3000);
        return redirect()->route('admin.tiket.index');
    }

    public function show(Tiket $tiket)
    {
        return view('admin.tiket.show', compact('tiket'));
    }

    public function edit(Tiket $tiket)
    {
        $events = Event::where('status', 'approved')->get(); // Hanya event yang disetujui
        return view('admin.tiket.edit', compact('tiket', 'events'));
    }

    public function update(Request $request, Tiket $tiket)
    {
        $request->validate([
            'event_id' => [
                'required',
                Rule::exists('events', 'id')->where('status', 'approved'),
            ], 'title' => 'required|string|max:255',
            'harga'    => 'required|integer',
            'stok'     => 'required|integer',
            'status'   => 'required|in:tersedia,habis',
        ]);

        $tiket->update($request->all());

        Alert::toast('Tiket berhasil diperbarui!', 'success')->autoClose(3000);
        return redirect()->route('admin.tiket.index');
    }

    public function destroy(Tiket $tiket)
    {
        $tiket->delete();

        Alert::toast('Tiket berhasil dihapus!', 'success')->autoClose(3000);
        return redirect()->route('admin.tiket.index');
    }
}
