@extends('layouts.admin.template')

@section('content')
    <div class="container p-4">
        <h4>Daftar Event</h4>
        <a href="{{ route('admin.events.create') }}" class="btn btn-success mb-3">Tambah Event</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped text-center align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $key => $event)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <img src="{{ asset($event->image) }}" alt="Gambar Event"
                                style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                        </td>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->kategori->kategori }}</td>
                        <td>
                            @if ($event->status === 'Pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif ($event->status === 'Approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                @if ($event->status === 'Rejected' && $event->user_id === auth()->id())
                                    <form action="{{ route('events.reapply', $event->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            Ajukan Ulang
                                        </button>
                                    </form>
                                @endif

                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $event->id }}">
                                    Detail
                                </button>

                                <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-primary">
                                    Edit
                                </a>

                                <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST"
                                    class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-delete"
                                        data-id="{{ $event->id }}">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>



                    </tr>

                    <!-- Modal Detail Event -->
                    <div class="modal fade" id="detailModal{{ $event->id }}" tabindex="-1"
                        aria-labelledby="detailModalLabel{{ $event->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailModalLabel{{ $event->id }}">Detail Event -
                                        {{ $event->title }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center mb-3">
                                        <img src="{{ asset($event->image) }}" alt="Gambar Event" class="img-fluid rounded"
                                            style="max-height: 300px;">
                                    </div>
                                    <p><strong>Judul:</strong> {{ $event->title }}</p>
                                    <p><strong>Kategori:</strong> {{ $event->kategori->kategori }}</p>
                                    <p><strong>Tanggal Mulai:</strong>
                                        {{ \Carbon\Carbon::parse($event->tgl_mulai)->format('d M Y') }}</p>
                                    <p><strong>Tanggal Selesai:</strong>
                                        {{ \Carbon\Carbon::parse($event->tgl_selesai)->format('d M Y') }}</p>
                                    <p><strong>Kota:</strong> {{ $event->kota }}</p>
                                    <p><strong>Lokasi:</strong> {{ $event->lokasi }}</p>
                                    <p><strong>URL Lokasi:</strong> <a href="{{ $event->url_lokasi }}"
                                            target="_blank">Lihat di Peta</a></p>
                                    <p><strong>Deskripsi:</strong> {!! $event->deskripsi !!}</p>
                                    <p><strong>Waktu Mulai:</strong> {{ $event->waktu_mulai }}</p>
                                    <p><strong>Waktu Selesai:</strong> {{ $event->waktu_selesai }}</p>
                                    <p><strong>Status:</strong>
                                        @if ($event->status === 'Pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif ($event->status === 'Approved')
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </p>
                                    @if ($event->status === 'Rejected')
                                        <div class="alert alert-danger">
                                            <strong>Alasan Penolakan:</strong>
                                            {{ $event->alasan ?? 'Tidak ada alasan yang diberikan.' }}
                                        </div>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
