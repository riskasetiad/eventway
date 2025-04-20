@extends('layouts.admin.template')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Daftar Pesan Masuk</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Subjek</th>
                <th>Pesan</th>
                <th>Dikirim Pada</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesans as $pesan)
                <tr>
                    <td>{{ $pesan->nama }}</td>
                    <td>{{ $pesan->email }}</td>
                    <td>{{ $pesan->telepon}}</td>
                    <td>{{ $pesan->subjek }}</td>
                    <td>{{ $pesan->pesan }}</td>
                    <td>{{ $pesan->created_at->format('d M Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $pesans->links() }}
</div>
@endsection
