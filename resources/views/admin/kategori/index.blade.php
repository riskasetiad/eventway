@extends('layouts.admin.template')

@section('content')
    <div class="container p-4">

        <!-- Form Tambah/Edit Kategori -->
        <div class="card mb-4">
            <div class="card-header">
                <h4 id="form-title">Tambah Kategori</h4>
            </div>
            <div class="card-body">
                <form id="kategori-form"
                    action="{{ auth()->user()->can('view_admin') ? route('admin.kategori.store') : route('kategori.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="kategori-id">

                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <input type="text" class="form-control" name="kategori" id="kategori-input" required>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" id="reset-btn" style="display:none;">Batal
                        Edit</button>
                </form>

            </div>
        </div>

        <!-- Tabel Data Kategori -->
        <div class="card">
            <div class="card-header">
                <h4>Daftar Kategori</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">#</th>
                            <th class="text-center align-middle">Kategori</th>
                            <th class="text-center align-middle">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategori as $index => $item)
                            <tr>
                                <td class="text-center align-middle">{{ $index + 1 }}</td>
                                <td class="text-center align-middle">{{ $item->kategori }}</td>
                                <td class="text-center align-middle">
                                    {{-- <!-- Tombol Edit -->
                                    <button class="btn btn-primary btn-sm edit-btn" data-id="{{ $item->id }}"
                                        data-kategori="{{ $item->kategori }}"
                                        onclick="console.log('ID:', this.dataset.id, 'Kategori:', this.dataset.kategori)">
                                        Edit
                                    </button> --}}

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('kategori.destroy', $item->id) }}" method="POST"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-delete"
                                            data-id="{{ $item->id }}">
                                            Hapus
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

{{-- @section('scripts')
    <script>
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('form-title').innerText = 'Edit Kategori';
                document.getElementById('kategori-id').value = this.dataset.id;
                document.getElementById('kategori-input').value = this.dataset.kategori;
                document.getElementById('reset-btn').style.display = 'inline-block';

                const form = document.getElementById('kategori-form');
                const baseUrl =
                    "{{ auth()->user()->can('view_admin') ? url('admin/kategori') : url('kategori') }}";
                form.action = `${baseUrl}/${this.dataset.id}`;

                let methodInput = form.querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    form.appendChild(methodInput);
                }
                methodInput.value = 'PATCH';
            });
        });

        // Tombol Batal Edit
        document.getElementById('reset-btn').addEventListener('click', function() {
            document.getElementById('form-title').innerText = 'Tambah Kategori';
            document.getElementById('kategori-id').value = '';
            document.getElementById('kategori-input').value = '';
            this.style.display = 'none';

            const form = document.getElementById('kategori-form');
            form.action =
                "{{ auth()->user()->can('view_admin') ? route('admin.kategori.store') : route('kategori.store') }}";

            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) methodInput.remove();
        });
    </script>
@endsection --}}
