<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Login | EventWay</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tema admin lengkap" />
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
            background-color: rgba(0, 0, 0, 0.564); 
            z-index: 1;
        }

        .login-form-wrapper {
            position: relative;
            z-index: 2;
            padding: 2rem;
            max-width: 400px;
            width: 100%;
            margin: 0 auto;
            border-radius: 8px;
        }

        .login-form-wrapper h3,
        .login-form-wrapper p {
            color: #fff;
        }

        .form-group label {
            color: #fff;
        }

        .d-grid .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .text-muted {
            color: rgba(255, 255, 255, 0.6) !important;
        }

        .text-primary {
            color: #007bff !important;
        }
    </style>
</head>

<body>
    <div class="account-page-bg d-flex align-items-center justify-content-center">
        <div class="login-form-wrapper">

            <div class="text-center mb-4">
                <a href="{{ route('home') }}" class="auth-logo">
                    <img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo-dark" height="50" />
                </a>
                <h3 class="text-light mt-3">Selamat datang kembali</h3>
                <p class="text-light">Silakan masukkan detail Anda</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" class="form-control" placeholder="Email" name="email" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" class="form-control" placeholder="Kata Sandi" name="password" required>
                </div>

                <div class="d-grid mb-3">
                    <button class="btn btn-primary" type="submit">Masuk</button>
                </div>

                <div class="text-center text-muted">
                    <p class="mb-0 text-light">Belum punya akun?
                        <a href="{{ route('register') }}" class="text-primary ms-2 fw-medium">Daftar di sini</a>
                    </p>
                </div>
            </form>

        </div>
    </div>

    <!-- Vendor -->
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
