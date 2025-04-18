@extends('layouts.admin.template')

@section('content')
    <div class="container p-4">
        <h4>Edit Tiket</h4>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.tiket.update', $tiket->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="event_id" class="form-label">Event</label>
                <select name="event_id" class="form-control" required>
                    <option value="">Pilih Event</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}" {{ $tiket->event_id == $event->id ? 'selected' : '' }}>
                            {{ $event->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Judul Tiket</label>
                <input type="text" name="title" class="form-control" value="{{ $tiket->title }}" required>
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control" value="{{ $tiket->harga }}" required>
            </div>

            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" value="{{ $tiket->stok }}" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="tersedia" {{ $tiket->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="habis" {{ $tiket->status == 'habis' ? 'selected' : '' }}>Habis</option>
                </select>
            </div>

            <button type="submit" class="btn btn-warning">Update</button>
            <a href="{{ route('admin.tiket.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
