<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Register | Kadso - Responsive Admin Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />
    <meta name="author" content="Zoyothemes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body class="bg-color">

    <!-- Begin page -->
    <div class="container-fluid">
        <div class="row vh-100">
            <div class="col-12">
                <div class="p-0">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-6 col-xl-6 col-lg-6">
                            <div class="row">
                                <div class="col-md-6 mx-auto">
                                    <div class="mb-0 border-0">
                                        <div class="p-0">
                                            <div class="text-center">
                                                <div class="mb-4">
                                                    <a href="index.html" class="auth-logo">
                                                        <img src="{{ asset('assets/images/logo-dark.png') }}"
                                                            alt="logo-dark" class="mx-auto" height="28" />
                                                    </a>
                                                </div>

                                                <div class="auth-title-section mb-3">
                                                    <h3 class="text-dark fs-20 fw-medium mb-2">Get's started</h3>
                                                    <p class="text-dark text-capitalize fs-14 mb-0">Please enter your
                                                        details.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pt-0">
                                            <form method="POST" action="{{ route('register') }}"
                                                enctype="multipart/form-data">
                                                @csrf

                                                <div class="form-group mb-3">
                                                    <label for="username" class="form-label">Username</label>
                                                    <input type="text" class="form-control" name="name" required
                                                        placeholder="Enter your Username">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="emailaddress" class="form-label">Email address</label>
                                                    <input class="form-control" type="email" name="email" required
                                                        placeholder="Enter your email">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input class="form-control" type="password" name="password" required
                                                        placeholder="Enter your password">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="password_confirmation" class="form-label">Confirm
                                                        Password</label>
                                                    <input class="form-control" type="password"
                                                        name="password_confirmation" required
                                                        placeholder="Confirm your password">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="image" class="form-label">Profile Image</label>
                                                    <input class="form-control" type="file" name="image"
                                                        accept="image/*">
                                                </div>

                                                <div class="form-group d-flex mb-3">
                                                    <div class="col-12">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="checkbox-signin" required>
                                                            <label class="form-check-label" for="checkbox-signin">
                                                                I agree to the <a href="#"
                                                                    class="text-primary fw-medium">Terms and
                                                                    Conditions</a>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-0 row">
                                                    <div class="col-12">
                                                        <div class="d-grid">
                                                            <button class="btn btn-primary"
                                                                type="submit">Register</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <div class="text-center text-muted">
                                                <p class="mb-0">Already have an account?
                                                    <a class='text-primary ms-2 fw-medium' href="{{route('login')}}">Login
                                                        here</a>
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="col-md-6 col-xl-6 col-lg-6 p-0 vh-100 d-flex justify-content-center account-page-bg">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- END wrapper -->

    <!-- Vendor -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>

    <!-- App js-->
    <script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>
