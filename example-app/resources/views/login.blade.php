<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Font Awesome CDN fallback so visibility icon displays -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        .password-input-wrap {
            position: relative;
            overflow: visible;
        }
        /* increase padding so the toggle doesn't overlap the input text */
        .password-input-wrap .form-control-user {
            padding-right: 4rem;
        }
        .password-toggle-btn {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background: #ffffff;
            border: 1px solid #d1d3e2;
            box-shadow: 0 2px 6px rgba(78,115,223,0.12);
            cursor: pointer;
            z-index: 999;
            padding: 0;
            margin: 0;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            flex-shrink: 0;
        }
        /* stronger hover for visibility */
        .password-toggle-btn:hover {
            background: #4e73df;
            border-color: #4e73df;
        }
        .password-toggle-btn:hover svg { fill: #ffffff; }
        .password-toggle-btn svg {
            width: 18px;
            height: 18px;
            fill: #4e73df;
            pointer-events: none;
            display: block;
        }
    </style>

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Task Management System</h1>
                                        <p class="text-muted">Login to your account</p>
                                    </div>

                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Login Failed!</strong>
                                            @foreach ($errors->all() as $error)
                                                <div>{{ $error }}</div>
                                            @endforeach
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif

                                    <form action="{{ route('login') }}" method="POST" class="user">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                                                id="email" name="email"
                                                value="{{ old('email') }}"
                                                placeholder="Enter Email Address..."
                                                required>
                                            @error('email')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                            <div class="form-group">
                                            <div class="password-input-wrap">
                                                <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                                    id="password" name="password"
                                                    placeholder="Password"
                                                    required>
                                                <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility()" id="passwordIconBtn" title="Show password" aria-label="Show password">
                                                    <svg id="passwordIconShow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                                                    <svg id="passwordIconHide" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" style="display: none;"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/></svg>
                                                </button>
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                                <label class="custom-control-label" for="remember">Remember Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                        <hr>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('register') }}">Create an Account!</a>
                                    </div>

                                    <div class="alert alert-info mt-3" role="alert">
                                        <strong>Demo Credentials:</strong><br>
                                        <small>
                                            <strong>Customer:</strong><br>
                                            Email: customer@example.com<br>
                                            Password: password<br><br>
                                            <strong>Frontend Developer:</strong><br>
                                            Email: mara@example.com<br>
                                            Password: password<br><br>
                                            <strong>Backend Developer:</strong><br>
                                            Email: arianne@example.com<br>
                                            Password: password<br><br>
                                            <strong>Server Administrator:</strong><br>
                                            Email: margaret@example.com<br>
                                            Password: password
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Password Toggle Script -->
    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const iconShow = document.getElementById('passwordIconShow');
            const iconHide = document.getElementById('passwordIconHide');
            const btn = document.getElementById('passwordIconBtn');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                iconShow.style.display = 'none';
                iconHide.style.display = 'block';
                btn.setAttribute('title', 'Hide password');
                btn.setAttribute('aria-label', 'Hide password');
            } else {
                passwordField.type = 'password';
                iconShow.style.display = 'block';
                iconHide.style.display = 'none';
                btn.setAttribute('title', 'Show password');
                btn.setAttribute('aria-label', 'Show password');
            }
        }
    </script>

</body>

</html>