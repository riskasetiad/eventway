<?php
namespace App\Http\Controllers;

use Alert;
use App\Models\Order;
use App\Models\Tiket;
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
        // Cek apakah pembeli punya order yang belum dibayar
        $userHasPendingOrder = \App\Models\Order::where('email', auth()->user()->email)
            ->where('status_pembayaran', 'pending')
            ->exists();

        if ($userHasPendingOrder) {
            Alert::toast('Anda memiliki pesanan yang belum dibayar!', 'warning')->autoClose(3000);
            return redirect()->route('admin.pembayaran.index');
        }

        // Ambil data event yang memiliki tiket yang tersedia
        $events = \App\Models\Event::whereHas('tikets', function ($query) {
            $query->where('status', 'tersedia');
        })
            ->with(['tikets' => function ($query) {
                $query->where('status', 'tersedia');
            }])
            ->where('status', 'Approved') // Menambahkan filter status event yang disetujui
            ->get();

        return view('admin.pembayaran.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tiket_id'      => 'required|integer',
            'nama_lengkap'  => 'required|string|max:255',
            'jenis_kelamin' => 'required',
            'tgl_lahir'     => 'required|date|before_or_equal:' . now()->subYears(16)->format('Y-m-d'),
            'email'         => 'required|email',
            'jumlah'        => 'required|integer|min:1',
            'total_harga'   => 'required|integer|min:0',
        ], [
            'tiket_id.required'         => 'Tiket harus dipilih.',
            'tiket_id.integer'          => 'ID Tiket tidak valid.',
            'nama_lengkap.required'     => 'Nama lengkap wajib diisi.',
            'nama_lengkap.string'       => 'Nama lengkap harus berupa teks.',
            'nama_lengkap.max'          => 'Nama lengkap maksimal 255 karakter.',
            'jenis_kelamin.required'    => 'Jenis kelamin wajib dipilih.',
            'tgl_lahir.required'        => 'Tanggal lahir wajib diisi.',
            'tgl_lahir.date'            => 'Format tanggal lahir tidak valid.',
            'tgl_lahir.before_or_equal' => 'Pendaftar harus berusia minimal 16 tahun.',
            'email.required'            => 'Email wajib diisi.',
            'email.email'               => 'Format email tidak valid.',
            'jumlah.required'           => 'Jumlah tiket wajib diisi.',
            'jumlah.integer'            => 'Jumlah tiket harus berupa angka.',
            'jumlah.min'                => 'Jumlah tiket minimal 1.',
            'total_harga.required'      => 'Total harga wajib diisi.',
            'total_harga.integer'       => 'Total harga harus berupa angka.',
            'total_harga.min'           => 'Total harga tidak boleh negatif.',
        ]);

        // Ambil tiket berdasarkan ID
        $tiket = \App\Models\Tiket::findOrFail($validated['tiket_id']);

        // Cek apakah stok mencukupi
        if ($validated['jumlah'] > $tiket->stok) {
            return back()->withErrors(['jumlah' => 'Stok tiket tidak mencukupi.'])->withInput();
        }

        // Kurangi stok
        $tiket->stok -= $validated['jumlah'];
        $tiket->save();

        // Tambahkan data tambahan yang tidak berasal dari form
        $validated['payment_type']      = '';
        $validated['status_pembayaran'] = 'pending';
        $validated['status_tiket']      = 'belum ditukar';
        $validated['snap_token']        = '';
        $validated['payment_deadline']  = now()->addMinutes(10); // Setel waktu batas pembayaran 10 menit setelah order

        $order = \App\Models\Order::create($validated);

        // Cek jika sudah lewat 10 menit, ubah status menjadi gagal dan kembalikan stok tiket
        if (now()->greaterThan($order->payment_deadline)) {
            $order->status_pembayaran = 'gagal';
            $order->save();

            // Kembalikan stok tiket
            $tiket->stok += $order->jumlah;
            $tiket->save();
        }

        Alert::toast('Order berhasil ditambahkan!', 'success')->autoClose(3000);
        return redirect()->route('admin.pembayaran.index');
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
        $order = Order::findOrFail($id);

        if ($order->status_pembayaran !== 'berhasil') {
            abort(403, 'Anda tidak diizinkan mengedit data ini.');
        }

        return view('admin.pembayaran.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status_pembayaran' => 'required|in:pending,berhasil,gagal',
            'status_tiket'      => 'required|in:sudah ditukar,belum ditukar',
        ]);

        // Jika sebelumnya bukan gagal, dan sekarang jadi gagal => kembalikan stok
        if ($order->status_pembayaran !== 'gagal' && $request->status_pembayaran === 'gagal') {
            $tiket = $order->tiket;
            $tiket->stok += $order->jumlah;
            $tiket->save();
        }

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

    public function formCheckout(Request $request)
    {
        $event_id = $request->event_id;

        // Ambil tiket berdasarkan event_id
        $tikets = Tiket::where('event_id', $event_id)
            ->where('status', 'tersedia')
            ->get();

        return view('guest.beli', [
            'tikets'   => $tikets,
            'event_id' => $event_id, // pastikan ini dikirim
        ]);
    }

    public function guestCheckout(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'tgl_lahir'     => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'jumlah'        => 'required|integer|min:1',
            'tiket_id'      => 'required|exists:tikets,id',
            'total_harga'   => 'required|numeric|min:1000',
        ]);

        // 2. Ambil tiket
        $tikets = Tiket::findOrFail($request->tiket_id);

        // 3. Cek stok tiket
        if ($tikets->stok < $request->jumlah) {
            return back()->with('error', 'Stok tiket tidak mencukupi.');
        }

        // 4. Simpan order ke DB
        $order = Order::create([
            'nama_lengkap'  => $request->nama_lengkap,
            'email'         => $request->email,
            'tgl_lahir'     => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'jumlah'        => $request->jumlah,
            'tiket_id'      => $request->tiket_id,
            'total_harga'   => $request->total_harga,
            'status'        => 'pending',
        ]);

        // 5. Konfigurasi Midtrans
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is3ds');

        // 6. Buat data untuk Snap
        $snapPayload = [
            'transaction_details' => [
                'order_id'     => 'INV-' . time(),
                'gross_amount' => $order->total_harga,
            ],
            'customer_details'    => [
                'first_name' => $order->nama,
                'email'      => $order->email,
            ],
            'item_details'        => [
                [
                    'id'       => $tikets->id,
                    'price'    => $tikets->harga,
                    'quantity' => $order->jumlah,
                    'name'     => $tikets->title,
                ],
            ],
        ];

        // 7. Dapatkan Snap Token
        $snapToken = Snap::getSnapToken($snapPayload);

        // 8. Simpan Snap Token ke order
        $order->update(['snap_token' => $snapToken]);
        $event = $order->tiket->event;

        // 9. Kirim ke view untuk tampilkan Snap
        return view('guest.checkout_snap', [
            'snapToken' => $snapToken,
            'order'     => $order,
            'event'     => $event,
        ]);
    }

}
