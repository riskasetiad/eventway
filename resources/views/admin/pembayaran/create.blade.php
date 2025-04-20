@extends('layouts.admin.template')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Form Tambah Order</h2>

        <form id="orderForm" action="{{ route('admin.pembayaran.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="eventSelect" class="form-label">Pilih Event</label>
                <select name="event_id" id="eventSelect" class="form-select" required>
                    <option value="">-- Pilih Event --</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                            {{ $event->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Pilih Tiket -->
            <div class="mb-3">
                <label for="tiketSelect" class="form-label">Pilih Tiket</label>
                <select name="tiket_id" id="tiketSelect" class="form-select" required>
                    <option value="">-- Pilih Tiket --</option>
                    {{-- Tiket akan diisi otomatis via JS --}}
                </select>
            </div>

            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
                    required value="{{ old('nama_lengkap') }}">
                @error('nama_lengkap')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio"
                        name="jenis_kelamin" value="laki-laki" {{ old('jenis_kelamin') == 'laki-laki' ? 'checked' : '' }}
                        required>
                    <label class="form-check-label">Laki-laki</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio"
                        name="jenis_kelamin" value="perempuan" {{ old('jenis_kelamin') == 'perempuan' ? 'checked' : '' }}>
                    <label class="form-check-label">Perempuan</label>
                </div>
                @error('jenis_kelamin')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror"
                    required value="{{ old('tgl_lahir') }}">
                @error('tgl_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required
                    value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label">Harga Tiket</label>
                <input type="number" id="hargaTiket" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label for="jumlahTiket" class="form-label">Jumlah Tiket</label>
                <input type="number" name="jumlah" id="jumlahTiket"
                    class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', 1) }}"
                    min="1">
                @error('jumlah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="total_harga" class="form-label">Total Harga</label>
                <input type="number" name="total_harga" class="form-control @error('total_harga') is-invalid @enderror"
                    readonly value="{{ old('total_harga') }}">
                @error('total_harga')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    @push('scripts')
        <script>
            const events = @json($events);
            console.log("DATA EVENTS:", events);
            document.addEventListener('DOMContentLoaded', () => {
                const events = @json($events);
                const oldTiketId = "{{ old('tiket_id') }}";

                const eventSelect = document.getElementById('eventSelect');
                const tiketSelect = document.getElementById('tiketSelect');
                const hargaTiketInput = document.getElementById('hargaTiket');
                const jumlahTiketInput = document.getElementById('jumlahTiket');
                const totalHargaInput = document.querySelector('input[name="total_harga"]');

                function populateTiketOptions(eventId) {
                    tiketSelect.innerHTML = '<option value="">-- Pilih Tiket --</option>';
                    const selectedEvent = events.find(event => event.id == eventId);

                    if (selectedEvent && selectedEvent.tikets) {
                        selectedEvent.tikets.forEach(tiket => {
                            if ((tiket.status || '').toLowerCase().trim() === 'tersedia') {
                                const option = document.createElement('option');
                                option.value = tiket.id;
                                option.textContent = tiket.title;
                                option.dataset.harga = tiket.harga;

                                if (tiket.id == oldTiketId) {
                                    option.selected = true;
                                }

                                tiketSelect.appendChild(option);
                            }
                        });
                    }

                    updateHargaDanTotal();
                }

                function updateHargaDanTotal() {
                    const selectedTiket = tiketSelect.options[tiketSelect.selectedIndex];
                    const harga = parseInt(selectedTiket?.dataset?.harga || 0);
                    const jumlah = parseInt(jumlahTiketInput.value || 0);

                    hargaTiketInput.value = harga || '';

                    if (harga > 0 && jumlah > 0) {
                        totalHargaInput.value = harga * jumlah;
                    } else {
                        totalHargaInput.value = '';
                    }
                }

                eventSelect.addEventListener('change', function() {
                    populateTiketOptions(this.value);
                });

                tiketSelect.addEventListener('change', updateHargaDanTotal);
                jumlahTiketInput.addEventListener('input', updateHargaDanTotal);

                // Trigger awal kalau ada old value
                if (eventSelect.value) {
                    populateTiketOptions(eventSelect.value);
                }

                // Validasi submit
                document.getElementById('orderForm').addEventListener('submit', function(e) {
                    if (!tiketSelect.value) {
                        e.preventDefault();
                        alert('Silakan pilih tiket terlebih dahulu.');
                    }
                });
            });
        </script>
    @endpush
@endsection
