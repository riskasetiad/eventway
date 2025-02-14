@extends('layouts.admin.template')

@section('content')
    <div class="container p-4">
        <h4 class="mb-4">Daftar Penyelenggara</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center align-middle">#</th>
                    <th class="text-center align-middle">Nama</th>
                    <th class="text-center align-middle">Email</th>
                    <th class="text-center align-middle">Role</th>
                    <th class="text-center align-middle">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $key => $user)
                    <tr>
                        <td class="text-center align-middle">{{ $key + 1 }}</td>
                        <td class="text-center align-middle">{{ $user->name }}</td>
                        <td class="text-center align-middle">{{ $user->email }}</td>
                        <td class="text-center align-middle">
                            @if ($user->getRoleNames()->first() === 'User')
                                Penyelenggara
                            @else
                                {{ $user->getRoleNames()->first() }}
                            @endif
                        </td>
                        <td class="text-center align-middle"> <button class="btn btn-danger btn-sm"
                                onclick="hapusPenyelenggara({{ $user->id }})">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function hapusPenyelenggara(userId) {
            Swal.fire({
                title: "Yakin ingin menghapus?",
                text: "Data tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Hapus!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/admin/penyelenggara/delete/" + userId;
                }
            });
        }
    </script>
@endsection
