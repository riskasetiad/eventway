@extends('layouts.guest.template')
@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section"
        style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset($event->image) }}') center center / cover no-repeat;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center text-white">
                    <div class="breadcrumb-text py-5">
                        <p>Checkout</p>
                        <h1>{{ $event->title }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container text-center mt-5 mb-5">
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
