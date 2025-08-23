<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GrainDryer - Auth</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo_gabah.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .tab-switch {
            cursor: pointer;
            font-weight: bold;
            padding: 8px 16px;
            border-bottom: 3px solid transparent;
        }
        .tab-active {
            border-bottom: 3px solid #1E3B8A;
            color: #1E3B8A;
        }
        .alert {
            display: none;
        }
    </style>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
        data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">

                                <!-- Tabs -->
                                <div class="d-flex justify-content-center mb-3">
                                    <div id="tab-register" class="tab-switch tab-active">Registrasi</div>
                                    <div id="tab-login" class="tab-switch">Login</div>
                                </div>

                                <!-- Logo -->
                                <a href="#" class="d-flex align-items-center justify-content-center gap-2 py-3 w-100 text-decoration-none">
                                    <img src="../assets/images/logos/logo_gabah.png" width="40" height="40" alt="">
                                    <span class="mb-0" style="color: #1E3B8A; font-weight: 800; font-size: 23px;">GrainDryer</span>
                                </a>
                                <p class="text-center">Sistem Monitoring Pengeringan Gabah</p>

                                <!-- Alert -->
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                <div id="alert-message" class="alert alert-dismissible fade show" role="alert">
                                    <span id="alert-text"></span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <!-- Form Registrasi -->
                                <form id="form-register" method="POST" action="{{ config('services.api.base_url') }}/register">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="register-name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="register-name" name="name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="register-email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="register-email" name="email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="register-password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="register-password" name="password">
                                    </div>
                                    <div class="mb-4">
                                        <label for="register-password-confirm" class="form-label">Konfirmasi Password</label>
                                        <input type="password" class="form-control" id="register-password-confirm" name="password_confirmation">
                                    </div>
                                    <button type="submit" class="btn w-100 py-2 mb-4 rounded-2"
                                        style="background-color: #1E3B8A; color: #fff; font-weight: 700;">
                                        Registrasi
                                    </button>
                                </form>

                                <!-- Form Login -->
                                <form id="form-login" method="POST" action="{{ route('login.submit') }}" style="display: none;">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                    {{-- <div class="mb-3 text-start">
                                        <a href="#" class="text-decoration-none" style="color: #1E3B8A; font-weight: 600;">
                                            Lupa Password?
                                        </a>
                                    </div> --}}
                                    <button type="submit" class="btn w-100 py-2 mb-4 rounded-2"
                                        style="background-color: #1E3B8A; color: #fff; font-weight: 700;">
                                        Login
                                    </button>
                                </form>

                                <!-- Back link -->
                                <div class="d-flex align-items-center justify-content-center">
                                    <a class="text fw-bold d-inline-flex align-items-center" href="/" style="color: #1E3B8A;">
                                        <i class="bi bi-arrow-left me-2"></i> Kembali
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            // Tab switching
            $("#tab-register").click(function () {
                $(this).addClass("tab-active");
                $("#tab-login").removeClass("tab-active");
                $("#form-register").show();
                $("#form-login").hide();
                $("#alert-message").hide();
            });

            $("#tab-login").click(function () {
                $(this).addClass("tab-active");
                $("#tab-register").removeClass("tab-active");
                $("#form-login").show();
                $("#form-register").hide();
                $("#alert-message").hide();
            });

            // Handle registration form submission with AJAX
            $("#form-register").on('submit', function (e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const csrfToken = $('meta[name="csrf-token"]').attr('content') || 
                    $(this).find('input[name="_token"]').val();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            localStorage.removeItem('token');
                            // Store token and show success message
                            localStorage.setItem('token', response.data.token);
                            $("#alert-message")
                                .removeClass('alert-danger')
                                .addClass('alert-success')
                                .show()
                                .find('#alert-text')
                                .text(response.message);
                            
                            // Redirect after a short delay
                            setTimeout(() => {
                                window.location.href = '/dashboard';
                            }, 1000);
                        }
                    },
                    error: function (xhr) {
                        let errorMessage = 'Terjadi kesalahan';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }
                        $("#alert-message")
                            .removeClass('alert-success')
                            .addClass('alert-danger')
                            .show()
                            .find('#alert-text')
                            .text(errorMessage);
                    }
                });
            });
        });
    </script>
</body>

</html>