<?php
namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Mail\PesanTerkirim;
use App\Models\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class KontakController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'email'   => 'required|email',
            'telepon' => 'nullable|string|max:20',
            'subjek'  => 'required|string|max:255',
            'pesan'   => 'required|string',
        ]);

        $pesan = Pesan::create($request->only('nama', 'email', 'telepon', 'subjek', 'pesan'));

        // Kirim email ke admin
        Mail::to('admin@example.com')->send(new PesanTerkirim($pesan));

        return redirect()->back()->with('success', 'Pesan kamu berhasil dikirim!');
    }
}
