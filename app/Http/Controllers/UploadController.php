<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads', 'public');                       // Simpan di storage/app/public/uploads
            return response()->json(['location' => asset("storage/$path")]); // Kembalikan URL gambar
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
