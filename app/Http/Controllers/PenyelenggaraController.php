<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

class PenyelenggaraController extends Controller
{
    public function index()
    {
        // Ambil semua user yang BUKAN admin
        // $users = User::whereDoesntHave('roles', function ($query) {
        //     $query->where('name', 'admin');
        // })->get();
        $users = User::all();

        return view('admin.penyelenggara.index', compact('users'));
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.penyelenggara.index')->with('success', 'Penyelenggara berhasil dihapus');
    }

}
