@extends('layouts.admin.template')

@section('content')

    <div class="container p-4">
        <h4 class="mb-4">Edit Event</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Judul Event</label>
                <input type="text" name="title" id="title" class="form-control"
                    value="{{ old('title', $event->title) }}" required>
            </div>

            <div class="mb-3">
                <label for="kategori_id" class="form-label">Kategori</label>
                <select name="kategori_id" id="kategori_id" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ $kategori->id == $event->kategori_id ? 'selected' : '' }}>
                            {{ $kategori->kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Gambar Event</label>
                <input type="file" name="image" id="image" class="form-control">
                @if ($event->image)
                    <img src="{{ asset($event->image) }}" alt="Gambar Event" class="mt-2"
                        style="width: 150px; height: 150px; object-fit: cover;">
                @endif
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control"
                        value="{{ old('tgl_mulai', $event->tgl_mulai) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control"
                        value="{{ old('tgl_selesai', $event->tgl_selesai) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                    <input type="time" name="waktu_mulai" id="waktu_mulai" class="form-control"
                        value="{{ old('waktu_mulai', $event->waktu_mulai) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                    <input type="time" name="waktu_selesai" id="waktu_selesai" class="form-control"
                        value="{{ old('waktu_selesai', $event->waktu_selesai) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="kota" class="form-label">Kota</label>
                <input type="text" name="kota" id="kota" class="form-control"
                    value="{{ old('kota', $event->kota) }}" required>
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <input type="text" name="lokasi" id="lokasi" class="form-control"
                    value="{{ old('lokasi', $event->lokasi) }}" required>
            </div>

            <div class="mb-3">
                <label for="url_lokasi" class="form-label">URL Lokasi (Google Maps)</label>
                <input type="url" name="url_lokasi" id="url_lokasi" class="form-control"
                    value="{{ old('url_lokasi', $event->url_lokasi) }}">
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Event</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="10">{!! old('deskripsi', $event->deskripsi ?? '') !!}</textarea>
            </div>


            <button type="submit" class="btn btn-primary">Update Event</button>
            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    @push('scripts')
        <script src="https://cdn.tiny.cloud/1/3lu615xty82ph7mid1dymfmnkietg5mezg5n3tlfytz4g5i4/tinymce/7/tinymce.min.js"
            referrerpolicy="no-referrer-when-downgrade"></script>
        <script>
            tinymce.init({
                selector: '#deskripsi',
                height: 300,
                menubar: false,
                plugins: 'advlist autolink lists link image charmap print preview',
                toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                branding: false,
                image_title: true,
                automatic_uploads: true,
                file_picker_types: 'image',
                images_upload_url: 'admin/upload-image',
                images_upload_handler: function(blobInfo, success, failure) {
                    let formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());

                    fetch('admin/upload-image', {
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
                                throw new Error('Upload gagal: Tidak ada URL gambar.');
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            failure('Upload gagal: ' + error.message);
                        });
                }
            });

            // Validasi sebelum submit
            document.querySelector('form').addEventListener('submit', function(e) {
                const deskripsi = tinymce.get('deskripsi').getContent({
                    format: 'text'
                }).trim();
                if (deskripsi === '') {
                    e.preventDefault();
                    alert('Deskripsi tidak boleh kosong!');
                    tinymce.get('deskripsi').focus();
                }
            });
        </script>
    @endpush
@endsection
