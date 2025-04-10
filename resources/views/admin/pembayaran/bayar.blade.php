@extends('layouts.admin.template')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4 class="card-title mb-4">Detail Pembayaran</h4>

            {{-- Informasi Pemesan --}}
            <h5 class="mb-3">Informasi Pemesan</h5>
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Nama Lengkap</th>
                    <td>{{ $order->nama_lengkap }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $order->email }}</td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>{{ $order->jenis_kelamin }}</td>
                </tr>
                <tr>
                    <th>Tanggal Lahir</th>
                    <td>{{ \Carbon\Carbon::parse($order->tgl_lahir)->format('d-m-Y') }}</td>
                </tr>
            </table>

            {{-- Detail Tiket --}}
            <h5 class="mt-4 mb-3">Detail Tiket</h5>
            <table class="table table-bordered">
                <tr>
                    <th>Nama Tiket</th>
                    <td>{{ $order->tiket->title ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Harga Tiket</th>
                    <td>Rp{{ number_format($order->tiket->harga, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Jumlah</th>
                    <td>{{ $order->jumlah }}</td>
                </tr>
                <tr>
                    <th>Total Bayar</th>
                    <td><strong>Rp{{ number_format($order->total_harga, 0, ',', '.') }}</strong></td>
                </tr>
            </table>

            {{-- Informasi Pembayaran --}}
            <div class="alert alert-info mt-4">
                Klik tombol <strong>"Bayar Sekarang"</strong> untuk melanjutkan pembayaran dengan metode yang tersedia melalui Midtrans.
            </div>

            <div class="text-end">
                <button id="pay-button" class="btn btn-primary">
                    <i class="fas fa-credit-card me-1"></i> Bayar Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Midtrans Snap Script --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                alert("Pembayaran berhasil!");
                window.location.href = "{{ route('admin.pembayaran.index') }}";
            },
            onPending: function(result) {
                alert("Pembayaran sedang diproses. Silakan tunggu konfirmasi.");
                window.location.href = "{{ route('admin.pembayaran.index') }}";
            },
            onError: function(result) {
                alert("Terjadi kesalahan dalam proses pembayaran. Silakan coba lagi.");
            }
        });
    });
</script>
@endsection
