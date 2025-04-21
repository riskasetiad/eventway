<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Registrasi | Kadso - Template Dashboard Admin Responsif</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Template admin lengkap yang dapat digunakan untuk membangun CRM, CMS, dll." />
    <meta name="author" content="Zoyothemes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Favicon Aplikasi -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- CSS Aplikasi -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .account-page-bg {
            position: relative;
            background-image: url('{{ asset('assets/images/bg-auth.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            width: 100%;
            overflow: hidden;
        }

        .account-page-bg::before {
            content: "";
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.564); /* Mengurangi efek gelap */
            z-index: 1;
        }

        .form-wrapper {
            position: relative;
            z-index: 2;
            padding: 2rem;
            max-width: 500px; /* Lebar form lebih lebar */
            width: 100%;
            margin: 0 auto;
            border-radius: 8px; /* Menambahkan sedikit border radius */
        }

        .form-wrapper h3,
        .form-wrapper p {
            color: #fff;
        }

        /* Menambahkan padding bawah agar form tidak terlalu mepet bawah */
        .account-page-bg .d-flex {
            padding-bottom: 5rem; /* Memberikan ruang tambahan di bawah */
        }
    </style>
</head>

<body class="bg-auth">

    <div class="account-page-bg">
        <div class="d-flex align-items-center justify-content-center min-vh-100">
            <div class="form-wrapper">

                <div class="text-center mb-2">
                    <a href="#" class="auth-logo d-block mb-2">
                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo-dark" height="70" />
                    </a>
                    <h3 class="text-light">Mulai Sekarang</h3>
                    <p class="text-light">Silakan masukkan detail Anda.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label text-light">Nama Pengguna</label>
                            <input type="text" class="form-control" name="name" required
                                placeholder="Masukkan nama pengguna">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label text-light">Alamat Email</label>
                            <input class="form-control" type="email" name="email" required
                                placeholder="Masukkan alamat email">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label text-light">Kata Sandi</label>
                            <input class="form-control" type="password" name="password" required
                                placeholder="Masukkan kata sandi">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label text-light">Konfirmasi Kata Sandi</label>
                            <input class="form-control" type="password" name="password_confirmation" required
                                placeholder="Konfirmasi kata sandi">
                        </div>

                        <div class="col-12 mb-2">
                            <label class="form-label text-light">Gambar Profil</label>
                            <input class="form-control" type="file" name="image" accept="image/*">
                        </div>

                        <div class="col-12 mb-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-signin" required>
                                <label class="form-check-label text-light" for="checkbox-signin">
                                    Saya setuju dengan <a href="#" class="text-primary fw-medium">Syarat dan Ketentuan</a>
                                </label>
                            </div>
                        </div>

                        <div class="col-12 mb-2">
                            <div class="d-grid">
                                <button class="btn btn-primary" type="submit">Daftar</button>
                            </div>
                        </div>

                        <div class="col-12 text-center text-muted">
                            <p class="mb-0 text-light">Sudah punya akun?
                                <a class='text-primary ms-2 fw-medium' href="{{ route('login') }}">Masuk di sini</a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>
