@extends('layouts.guest.template')
@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Tiket Event Favoritmu</p>
                        <h1>Checkout Tiket</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <!-- checkout section -->
    <div class="checkout-section mt-100 mb-150">
        <div class="container">
            <div class="row">
                <!-- Kiri: Form Checkout -->
                <div class="col-lg-8 mb-4">
                    <div class="checkout-accordion-wrap">
                        <div class="accordion" id="accordionExample">

                            <!-- Data Pemesan -->
                            <div class="card single-accordion">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Data Pemesan
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <form action="{{ route('guest.checkout.proses') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="event_id" value="{{ $event_id }}">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <input type="text" name="nama_lengkap" class="form-control"
                                                        placeholder="Nama Lengkap" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <select name="jenis_kelamin" class="form-control" required>
                                                        <option value="">Pilih Jenis Kelamin</option>
                                                        <option value="Laki-laki">Laki-laki</option>
                                                        <option value="Perempuan">Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <input type="date" name="tgl_lahir" class="form-control" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <input type="email" name="email" class="form-control"
                                                        placeholder="Email Aktif" required>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pilih Tiket -->
                            <div class="card single-accordion">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                            data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Pilih Tiket
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                @if ($tikets->isEmpty())
                                                    <p>Maaf, tidak ada tiket tersedia untuk event ini.</p>
                                                @else
                                                    <select name="tiket_id" id="tiket_id" class="form-control" required>
                                                        <option value="">-- Pilih Tiket --</option>
                                                        @foreach ($tikets as $tiket)
                                                            <option value="{{ $tiket->id }}"
                                                                data-harga="{{ $tiket->harga }}">
                                                                {{ $tiket->title }} - Rp
                                                                {{ number_format($tiket->harga, 0, ',', '.') }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <input type="number" name="jumlah" id="jumlah" class="form-control"
                                                    placeholder="Jumlah Tiket" required min="1"
                                                    onchange="hitungTotal()">
                                            </div>
                                            <input type="hidden" name="total_harga" id="total_harga">
                                            <div class="col-12 mt-2">
                                                <strong>Total Harga:</strong> Rp <span id="totalHargaDisplay">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Konfirmasi & Pembayaran -->
                            <div class="card single-accordion">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                            data-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            Konfirmasi & Pembayaran
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <p>Cek ulang data sebelum melanjutkan ke pembayaran.</p>
                                        <button type="submit" class="boxed-btn mt-3">Lanjut Pembayaran</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- End Accordion -->
                    </div>
                </div>

                <!-- Kanan: Ringkasan -->
                <div class="col-lg-4">
                    <div class="order-details-wrap p-4 border rounded shadow-sm">
                        <h4 class="mb-3">Ringkasan Pemesanan</h4>
                        <table class="order-details w-100">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody class="order-details-body">
                                <tr>
                                    <td>Tiket</td>
                                    <td><span id="summaryTiket">-</span></td>
                                </tr>
                                <tr>
                                    <td>Jumlah</td>
                                    <td><span id="summaryJumlah">-</span></td>
                                </tr>
                            </tbody>
                            <tfoot class="checkout-details">
                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td><strong>Rp <span id="summaryTotal">0</span></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div> <!-- End Row -->
        </div> <!-- End Container -->
    </div> <!-- End Checkout Section -->
@endsection

<script>
    // Fungsi untuk menghitung total harga berdasarkan jumlah tiket yang dipilih
    function hitungTotal() {
        var tiketHarga = parseInt(document.getElementById('tiket_id').selectedOptions[0].getAttribute('data-harga'));
        var jumlahTiket = parseInt(document.getElementById('jumlah').value);
        var totalHarga = tiketHarga * jumlahTiket;

        document.getElementById('total_harga').value = totalHarga;
        document.getElementById('totalHargaDisplay').innerText = totalHarga.toLocaleString('id-ID');
        document.getElementById('summaryTiket').innerText = document.getElementById('tiket_id').selectedOptions[0]
            .innerText;
        document.getElementById('summaryJumlah').innerText = jumlahTiket;
        document.getElementById('summaryTotal').innerText = totalHarga.toLocaleString('id-ID');
    }
</script>
