@extends('layouts.admin.template')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title m-0">Detail Pembayaran</h4>
                    <a href="{{ auth()->user()->hasRole('Admin') ? route('admin.pembayaran.index') : route('pembayaran.index') }}"
                        class="btn btn-secondary">
                        &larr; Kembali
                    </a>
                </div>

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
                        <th width="30%">Event</th>
                        <td>{{ $order->tiket->event->title ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th width="30%">Tiket</th>
                        <td>{{ $order->tiket->title ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Harga Tiket</th>
                        <td>Rp{{ number_format($order->tiket->harga ?? 0, 0, ',', '.') }}</td>
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

                {{-- Status Pembayaran --}}
                <div class="mt-4">
                    <h5 class="mb-3">Status Pembayaran</h5>
                    <div class="text-center">
                        <div
                            class="btn w-100
            {{ $order->status_pembayaran == 'berhasil'
                ? 'btn-success'
                : ($order->status_pembayaran == 'pending'
                    ? 'btn-warning text-dark'
                    : 'btn-danger') }}">
                            {{ ucfirst($order->status_pembayaran) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
