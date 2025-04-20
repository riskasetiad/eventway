<?php
namespace App\Http\Controllers;

use App\Models\Pesan;

class PesanController extends Controller
{
    public function index()
    {
        $pesans = Pesan::latest()->paginate(10);
        return view('admin.pesan.index', compact('pesans'));
    }
}
