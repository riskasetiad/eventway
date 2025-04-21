@extends('layouts.admin.template')
@section('content')
    <div class="container p-4">
        <h4>Daftar Tiket</h4>
        <a href="{{ auth()->user()->can('view_admin') ? route('admin.tiket.create') : route('tiket.create') }}"
            class="btn btn-success mb-3">Tambah Event</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center align-middle">#</th>
                    <th class="text-center align-middle">Event</th>
                    <th class="text-center align-middle">Jenis</th>
                    <th class="text-center align-middle">Harga</th>
                    <th class="text-center align-middle">Stok</th>
                    <th class="text-center align-middle">Status</th>
                    <th class="text-center align-middle">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tikets as $tiket)
                    <tr>
                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                        <td class="text-center align-middle">{{ $tiket->event->title ?? 'Tidak Ada Event' }}</td>
                        <td class="text-center align-middle">{{ $tiket->title }}</td>
                        <td class="text-center align-middle">Rp{{ number_format($tiket->harga, 0, ',', '.') }}</td>
                        <td class="text-center align-middle">{{ $tiket->stok }}</td>
                        <td class="text-center align-middle">{{ ucfirst($tiket->status) }}</td>
                        <td class="text-center align-middle">
                            @if ($tiket->event && $tiket->event->user_id === auth()->id())
                                <a href="{{ route('admin.tiket.edit', $tiket->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.tiket.destroy', $tiket->id) }}" method="POST"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-delete"
                                        data-id="{{ $tiket->id }}">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
