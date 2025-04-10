@extends('layouts.admin.template')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Form Tambah Order</h2>

        <form action="{{ route('admin.pembayaran.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="event_id" class="form-label">Pilih Event</label>
                <select id="eventSelect" class="form-select" required>
                    <option value="">-- Pilih Event --</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}">{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="tiket_id" class="form-label">Pilih Tiket</label>
                <select name="tiket_id" id="tiketSelect" class="form-select" required>
                    <option value="">-- Pilih Tiket --</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" value="laki-laki" required>
                    <label class="form-check-label">Laki-laki</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" value="perempuan">
                    <label class="form-check-label">Perempuan</label>
                </div>
            </div>

            <div class="mb-3">
                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label">Harga Tiket</label>
                <input type="number" id="hargaTiket" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label for="jumlahTiket" class="form-label">Jumlah Tiket</label>
                <input type="number" name="jumlah" id="jumlahTiket" class="form-control" value="1" min="1">
            </div>

            <div class="mb-3">
                <label for="total_harga" class="form-label">Total Harga</label>
                <input type="number" name="total_harga" class="form-control" readonly>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
    <script>
        // Ambil data event dan tiket dari Blade
        const events = @json($events);

        // Elemen form yang perlu diupdate
        const eventSelect = document.getElementById('eventSelect');
        const tiketSelect = document.getElementById('tiketSelect');
        const hargaTiketInput = document.getElementById('hargaTiket');
        const jumlahTiketInput = document.getElementById('jumlahTiket');
        const totalHargaInput = document.querySelector('input[name="total_harga"]');

        // Menambahkan event listener untuk event select (pilih event)
        eventSelect.addEventListener('change', function() {
            const eventId = this.value;
            tiketSelect.innerHTML = '<option value="">-- Pilih Tiket --</option>';

            // Mencari event yang dipilih
            const selectedEvent = events.find(event => event.id == eventId);
            if (selectedEvent) {
                // Menambahkan tiket yang tersedia ke dalam dropdown tiket
                selectedEvent.tikets.forEach(tiket => {
                    if (tiket.status === 'tersedia') { // Memastikan tiket yang tersedia yang dipilih
                        const option = document.createElement('option');
                        option.value = tiket.id;
                        option.textContent = tiket.title;
                        option.dataset.harga = tiket.harga; // Menyimpan harga tiket di data atribut
                        tiketSelect.appendChild(option);
                    }
                });
            }

            // Reset harga dan total harga
            hargaTiketInput.value = '';
            totalHargaInput.value = '';
        });

        // Fungsi untuk menghitung harga total berdasarkan tiket yang dipilih dan jumlah tiket
        function updateHargaDanTotal() {
            const selectedTiket = tiketSelect.options[tiketSelect.selectedIndex];
            const harga = parseInt(selectedTiket?.dataset?.harga || 0); // Mengambil harga tiket dari data atribut
            const jumlah = parseInt(jumlahTiketInput.value || 0); // Mengambil jumlah tiket yang diinputkan

            // Update harga tiket
            hargaTiketInput.value = harga ? harga : ''; // Menampilkan harga tiket jika ada

            // Hitung dan tampilkan total harga
            if (harga > 0 && jumlah > 0) {
                totalHargaInput.value = harga * jumlah; // Total harga = harga tiket * jumlah tiket
            } else {
                totalHargaInput.value = ''; // Kosongkan jika harga atau jumlah tidak valid
            }
        }

        // Menambahkan event listener untuk perubahan pada pilihan tiket dan jumlah tiket
        tiketSelect.addEventListener('change', updateHargaDanTotal);
        jumlahTiketInput.addEventListener('input', updateHargaDanTotal);
    </script>
@endsection
