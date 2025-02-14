@extends('layouts.admin.template')

@section('content')
    <div class="container p-4">
        <h4 class="mb-4">Tambah Event Baru</h4>
        <script src="https://cdn.tiny.cloud/1/3lu615xty82ph7mid1dymfmnkietg5mezg5n3tlfytz4g5i4/tinymce/7/tinymce.min.js"
            referrerpolicy="no-referrer-when-downgrade"></script>

        <form action="{{ auth()->user()->can('view_admin') ? route('admin.events.store') : route('events.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="image" class="form-label">Gambar Event</label>
                <input type="file" class="form-control" name="image" accept="image/*" required>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Judul Event</label>
                <input type="text" class="form-control" name="title" placeholder="Masukkan judul event" required>
            </div>

            <div class="mb-3">
                <label for="kategori_id" class="form-label">Kategori</label>
                <select name="kategori_id" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" name="tgl_mulai" required>
                </div>
                <div class="col-md-6">
                    <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" name="tgl_selesai" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                    <input type="time" class="form-control" name="waktu_mulai" required>
                </div>
                <div class="col-md-6">
                    <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                    <input type="time" class="form-control" name="waktu_selesai" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="kota" class="form-label">Kota</label>
                <input type="text" class="form-control" name="kota" placeholder="Masukkan nama kota" required>
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi Detail</label>
                <input type="text" class="form-control" name="lokasi" placeholder="Masukkan detail lokasi" required>
            </div>

            <div class="mb-3">
                <label for="url_lokasi" class="form-label">URL Lokasi (Google Maps)</label>
                <input type="url" class="form-control" name="url_lokasi" placeholder="https://maps.google.com" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4" placeholder="Jelaskan detail event..."></textarea>

                <script>
                    tinymce.init({
                        selector: '#deskripsi',
                        height: 300,
                        menubar: false,
                        plugins: 'advlist autolink lists link image charmap preview',
                        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                        branding: false,
                        image_title: true,
                        automatic_uploads: true,
                        file_picker_types: 'image',
                        images_upload_url: '/admin/upload-image',
                        images_upload_handler: function(blobInfo, success, failure) {
                            let formData = new FormData();
                            formData.append('file', blobInfo.blob(), blobInfo.filename());

                            fetch('/admin/upload-image', {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.location) {
                                        success(data.location);
                                    } else {
                                        failure('Upload gagal: Tidak ada URL gambar.');
                                    }
                                })
                                .catch(error => {
                                    failure('Upload gagal: ' + error.message);
                                });
                        }
                    });
                </script>

            </div>

            <button type="submit" class="btn btn-success">Simpan Event</button>
            <a href="{{ route('events.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <!-- Inisialisasi TinyMCE -->
@endsection
