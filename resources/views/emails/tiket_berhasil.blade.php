<h2>Detail Tiket Anda</h2>
<p><strong>Nama:</strong> {{ $order->nama_lengkap }}</p>
<p><strong>Event:</strong> {{ $order->tiket->title }}</p>
<p><strong>Jumlah Tiket:</strong> {{ $order->jumlah }}</p>
<p><strong>Total Bayar:</strong> Rp{{ number_format($order->total_harga, 0, ',', '.') }}</p>
<p><strong>Status:</strong> {{ ucfirst($order->status_pembayaran) }}</p>

<h4>QR Code untuk Penukaran Tiket:</h4>
<img src="https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl={{ urlencode($order->id) }}" alt="QR Code">
