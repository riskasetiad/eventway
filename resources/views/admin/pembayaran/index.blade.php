@extends('layouts.admin.template')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Daftar Pemesanan</h2>

        {{-- <a href="{{ route('admin.pembayaran.create') }}" class="btn btn-primary mb-3">+ Tambah Order</a> --}}

        @if ($orders->isEmpty())
            <div class="alert alert-info">Belum ada data pembayaran.</div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Event</th>
                        <th>Tiket</th>
                        <th>Email</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Status Pembayaran</th>
                        <th>Status Tiket</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $index => $order)
                        <tr>
                            <td class="text-center align-middle">{{ $index + 1 }}</td>
                            <td class="text-center align-middle">{{ $order->nama_lengkap }}</td>
                            <td class="text-center align-middle">
                                {{ $order->tiket->event->title ?? '-' }}
                            </td>
                            <td class="text-center align-middle">{{ $order->tiket->title ?? '-' }}</td>
                            <td class="text-center align-middle">{{ $order->email }}</td>
                            <td class="text-center align-middle">{{ $order->jumlah }}</td>
                            <td class="text-center align-middle">Rp{{ number_format($order->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="text-center align-middle">
                                <span
                                    class="badge bg-{{ $order->status_pembayaran == 'berhasil' ? 'success' : ($order->status_pembayaran == 'pending' ? 'warning text-dark' : 'danger') }}">
                                    {{ ucfirst($order->status_pembayaran) }}
                                </span>
                            </td>
                            <td class="text-center align-middle" id="status-tiket-{{ $order->id }}">
                                <span
                                    class="badge bg-{{ $order->status_tiket == 'sudah ditukar' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($order->status_tiket) }}
                                </span>
                            </td>
                            <td class="text-center align-middle">
                                {{-- @if ($order->status_pembayaran === 'pending')
                                    <form action="{{ route('admin.pembayaran.bayar', $order->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Bayar</button>
                                    </form>
                                @endif --}}

                                <a href="{{ auth()->user()->hasRole('Admin')
                                    ? route('admin.pembayaran.show', $order->id)
                                    : route('pembayaran.show', $order->id) }}"
                                    class="btn btn-info btn-sm">Detail</a>
                                @php
                                    $eventUserId = optional($order->tiket->event)->user_id;
                                @endphp

                                @if (
                                    $order->status_pembayaran === 'berhasil' &&
                                        $order->status_tiket !== 'sudah ditukar' &&
                                        $eventUserId &&
                                        auth()->id() === $eventUserId)
                                    <button class="btn btn-warning btn-sm mt-1"
                                        onclick="showEditModal('{{ $order->id }}', '{{ $order->status_tiket }}')">
                                        Edit Status
                                    </button>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Modal Edit Status Tiket -->
    <div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editStatusForm">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <input type="hidden" id="edit_order_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Status Tiket</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="status_tiket">Status Tiket</label>
                            <select class="form-select" id="status_tiket" name="status_tiket">
                                <option value="belum ditukar">Belum ditukar</option>
                                <option value="sudah ditukar">Sudah ditukar</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('editStatusForm');
            form.addEventListener('submit', submitStatus);
        });

        function showEditModal(orderId, statusTiket) {
            document.getElementById('edit_order_id').value = orderId;
            document.getElementById('status_tiket').value = statusTiket;

            const modal = new bootstrap.Modal(document.getElementById('editStatusModal'));
            modal.show();
        }

        function submitStatus(event) {
            event.preventDefault();

            const orderId = document.getElementById('edit_order_id').value;
            const statusTiket = document.getElementById('status_tiket').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            fetch(`/admin/pembayaran/${orderId}/status_tiket`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        status_tiket: statusTiket
                    })
                })
                .then(res => {
                    if (!res.ok) throw new Error("Server error " + res.status);
                    return res.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('Status berhasil diperbarui!');
                        const statusTiketBadge = document.getElementById(`status-tiket-${orderId}`);
                        statusTiketBadge.innerHTML =
                            `<span class="badge bg-${statusTiket === 'sudah ditukar' ? 'success' : 'secondary'}">${statusTiket}</span>`;
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editStatusModal'));
                        modal.hide();
                    } else {
                        alert('Gagal update: ' + (data.message ?? 'Terjadi kesalahan'));
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('AJAX Error: ' + err.message);
                });
        }
    </script>

@endsection
