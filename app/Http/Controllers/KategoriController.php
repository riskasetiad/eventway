<?php
namespace App\Http\Controllers;

use Alert;
use App\Models\Kategori;
use Illuminate\Http\Request;
// Pastikan SweetAlert di-import

class KategoriController extends Controller
{
    // Tampilkan semua kategori
    public function index()
    {
        $kategori = Kategori::all();
        return view('admin.kategori.index', compact('kategori'));
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:255',
        ]);

        Kategori::create($request->all());

        Alert::toast('Kategori berhasil ditambahkan!', 'success')->autoClose(3000);
        return redirect()->route('admin.kategori.index');
    }

    // Tampilkan form edit (opsional kalau pakai AJAX, bisa dihapus)
    public function edit(Kategori $kategori)
    {
        return response()->json($kategori);
    }

    // Update kategori
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'kategori' => 'required|string|max:255',
        ]);

        $kategori->update($request->all());

        Alert::toast('Kategori berhasil diperbarui!', 'success')->autoClose(3000);
        return redirect()->route('admin.kategori.index');
    }

    // Hapus kategori
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        Alert::toast('Kategori berhasil dihapus!', 'success')->autoClose(3000);
        return redirect()->route('admin.kategori.index');
    }
}
