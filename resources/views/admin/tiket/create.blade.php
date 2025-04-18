@extends('layouts.admin.template')

@section('content')
    <div class="container p-4">
        <h4>Tambah Tiket</h4>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ auth()->user()->can('view_admin') ? route('admin.tiket.store') : route('tiket.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="event_id" class="form-label">Event</label>
                <select name="event_id" class="form-control" required>
                    <option value="">Pilih Event</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}">{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Judul Tiket</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control" value="{{ old('harga') }}" required>
            </div>

            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" value="{{ old('stok') }}" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="tersedia">Tersedia</option>
                    <option value="habis">Habis</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('tiket.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
