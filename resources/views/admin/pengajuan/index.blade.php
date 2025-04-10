@extends('layouts.admin.template')

@section('content')
    <div class="container p-4">
        <h4>Pengajuan Event</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Penyelenggara</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $index => $event)
                    <tr>
                        <td class="text-center align-middle">{{ $index + 1 }}</td>
                        <td class="text-center align-middle">
                            <img src="{{ asset($event->image) }}" alt="Gambar Event"
                                style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                        </td>
                        <td class="text-center align-middle">{{ $event->title }}</td>
                        <td class="text-center align-middle">
                            {{ $event->penyelenggara ? $event->penyelenggara->name : 'Tidak Diketahui' }}</td>
                        <td class="text-center align-middle">
                            <!-- Tombol untuk membuka modal -->
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deskripsiModal{{ $event->id }}">
                                Lihat Deskripsi
                            </button>
                        </td>
                        <td class="text-center align-middle">
                            @if ($event->status == 'Pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif ($event->status == 'Approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            @if ($event->status === 'Pending')
                                <form action="{{ route('admin.pengajuan.approve', $event) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#rejectModal{{ $event->id }}">
                                    Reject
                                </button>
                            @elseif ($event->status === 'Approved')
                                <button class="btn btn-secondary btn-sm" disabled>Approved</button>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>Rejected</button>
                            @endif
                        </td>
                    </tr>

                    <!-- Modal untuk alasan reject -->
                    <div class="modal fade" id="rejectModal{{ $event->id }}" tabindex="-1"
                        aria-labelledby="rejectModalLabel{{ $event->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="rejectModalLabel{{ $event->id }}">Tolak Event</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.pengajuan.reject', $event->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <label for="alasan">Alasan Penolakan:</label>
                                        <textarea name="alasan" class="form-control" required></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Tolak Event</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Deskripsi -->
                    <div class="modal fade" id="deskripsiModal{{ $event->id }}" tabindex="-1"
                        aria-labelledby="deskripsiLabel{{ $event->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered"> <!-- Tambahkan kelas modal-dialog-centered -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deskripsiLabel{{ $event->id }}">{{ $event->title }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {!! $event->deskripsi !!}
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
