<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = \App\Models\Order::with('tiket')->get();
        return view('admin.pembayaran.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $events = \App\Models\Event::whereHas('tikets', function ($query) {
            $query->where('status', 'tersedia');
        })->with(['tikets' => function ($query) {
            $query->where('status', 'tersedia');
        }])->get();

        return view('admin.pembayaran.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi hanya field yang dikirim dari form
        $validated = $request->validate([
            'tiket_id'      => 'required|integer',
            'nama_lengkap'  => 'required|string',
            'jenis_kelamin' => 'required|string',
            'tgl_lahir'     => 'required|date',
            'email'         => 'required|email',
            'jumlah'        => 'required|integer|min:1',
            'total_harga'   => 'required|integer',
        ]);

                                              // Tambahkan field yang tidak ada di form tapi dibutuhkan di database
        $validated['payment_type']      = ''; // atau sesuaikan dengan sistem kamu
        $validated['status_pembayaran'] = 'pending';
        $validated['status_tiket']      = 'belum ditukar';
        $validated['snap_token']        = ''; // jika belum generate token, bisa kosong dulu

        // Simpan ke database
        \App\Models\Order::create($validated);

        return redirect()->route('admin.pembayaran.index')->with('success', 'Order berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        return view('admin.pembayaran.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Bisa dipakai untuk mengubah status tiket atau status pembayaran secara manual
        $order = Order::findOrFail($id);
        return view('admin.pembayaran.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        // Contoh validasi untuk update status
        $request->validate([
            'status_pembayaran' => 'required|in:pending,berhasil,gagal',
            'status_tiket'      => 'required|in:sudah ditukar,belum ditukar',
        ]);

        $order->update([
            'status_pembayaran' => $request->status_pembayaran,
            'status_tiket'      => $request->status_tiket,
        ]);

        return redirect()->route('admin.pembayaran.index')->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.pembayaran.index')->with('success', 'Data pembayaran berhasil dihapus.');
    }

    public function bayar($id)
    {
        $order = Order::findOrFail($id);
        // Inisialisasi Midtrans
        \Midtrans\Config::$serverKey    = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized  = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds        = config('midtrans.is3ds');

        $tiket = $order->tiket;

        $params = [
            'transaction_details' => [
                'order_id'     => 'ORDER-' . $order->id . '-' . uniqid(),
                'gross_amount' => $order->total_harga,
            ],
            'customer_details'    => [
                'first_name' => $order->nama_lengkap,
                'email'      => $order->email,
            ],
            'item_details'        => [
                [
                    'id'       => $tiket->id,
                    'price'    => $tiket->harga,
                    'quantity' => $order->jumlah,
                    'name'     => $tiket->title,
                ],
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        // Simpan snap token untuk digunakan di halaman pembayaran
        $order->update([
            'snap_token' => $snapToken,
        ]);

        return view('admin.pembayaran.bayar', compact('order', 'snapToken'));
    }

    public function updateStatusTiket(Request $request, $id)
    {
        $order               = Order::findOrFail($id);
        $order->status_tiket = $request->status_tiket;
        $order->save();

        return response()->json(['success' => true]);
    }

}
