@extends('layouts.guest.template')
@section('content')
    <div class="container text-center mt-5">
        <h3>Silakan Lanjutkan Pembayaran</h3>
        <p>Order ID: {{ $order->id }} | Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
        <button id="pay-button" class="boxed-btn mt-3">Bayar Sekarang</button>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        document.getElementById('pay-button').addEventListener('click', function() {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    alert("Pembayaran sukses!");
                    window.location.href = "/";
                },
                onPending: function(result) {
                    alert("Menunggu pembayaran...");
                },
                onError: function(result) {
                    alert("Pembayaran gagal!");
                },
                onClose: function() {
                    alert('Kamu menutup popup pembayaran.');
                }
            });
        });
    </script>
@endsection
