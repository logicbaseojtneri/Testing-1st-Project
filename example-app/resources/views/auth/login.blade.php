<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Login to ManageX">
    <meta name="author" content="ManageX Team">
    <title>Login - ManageX</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #001f3f;
            --primary-dark: #001428;
            --white: #ffffff;
            --light-bg: #f8f9fa;
            --text-dark: #1a1a1a;
            --text-muted: #6c757d;
            --border: #e9ecef;
            --danger: #dc3545;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        html, body { height: 100%; width: 100%; }
        
        body {
            background: linear-gradient(180deg, var(--white) 0%, var(--light-bg) 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1rem;
        }
        
        .login-container {
            width: 100%;
            max-width: 420px;
        }
        
        .login-card {
            background: var(--white);
            border: none;
            border-radius: 16px;
            border-top: 6px solid var(--primary);
            box-shadow: 0 8px 25px rgba(0, 31, 63, 0.08);
            overflow: hidden;
            animation: slideUp 0.4s ease;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-header {
            background: var(--white);
            color: var(--primary);
            padding: 2rem 1.5rem 1.5rem;
            text-align: center;
        }
        
        .login-header h1 {
            font-size: 1.8rem;
            font-weight: 800;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }
        
        .login-header p {
            margin: 0.5rem 0 0 0;
            font-size: 0.95rem;
            color: var(--text-muted);
        }
        
        .login-body {
            padding: 2rem 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.25rem;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
        
        .form-control {
            border: 2px solid var(--border);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: var(--white);
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 31, 63, 0.1);
            outline: none;
        }
        
        .form-control::placeholder {
            color: var(--text-muted);
        }
        
        .password-wrapper {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
        }
        
        .password-toggle:hover {
            color: var(--primary);
        }
        
        .form-check {
            margin-bottom: 1.5rem;
        }
        
        .form-check-input {
            border: 2px solid var(--border);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .form-check-label {
            color: var(--text-dark);
            font-weight: 500;
            margin-left: 0.5rem;
            cursor: pointer;
        }
        
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            border: none;
            padding: 0.85rem 1.5rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(0, 31, 63, 0.2);
            margin-bottom: 1rem;
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(0, 31, 63, 0.3);
            color: var(--white);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            gap: 1rem;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background-color: var(--border);
        }
        
        .divider span {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .login-footer {
            text-align: center;
            padding: 1.5rem 1.5rem 2rem;
        }
        
        .login-footer p {
            margin: 0;
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        
        .login-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .login-footer a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        .alert {
            border: none;
            border-radius: 8px;
            border-left: 4px solid var(--danger);
            margin-bottom: 1.5rem;
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger);
        }
        
        .invalid-feedback {
            display: block;
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 0.3rem;
            font-weight: 500;
        }
        
        .demo-info {
            background: linear-gradient(135deg, rgba(0, 31, 63, 0.08) 0%, rgba(0, 31, 63, 0.04) 100%);
            border-left: 4px solid var(--primary);
            padding: 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            color: var(--text-dark);
            margin-top: 1.5rem;
        }
        
        .demo-info i {
            color: var(--primary);
        }
        
        @media (max-width: 576px) {
            .login-header {
                padding: 1.5rem 1rem;
            }
            
            .login-header h1 {
                font-size: 1.4rem;
            }
            
            .login-body {
                padding: 1.5rem 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card card">
            <!-- Header -->
            <div class="login-header">
                <h1><i class="fas fa-tasks"></i> ManageX</h1>
                <p>Sign in to your account</p>
            </div>
            
            <!-- Body -->
            <div class="login-body">
                @if ($errors->any())
                    <div class="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Login Failed</strong>
                        @foreach ($errors->all() as $error)
                            <div style="font-size: 0.9rem; margin-top: 0.3rem;">• {{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label"><i class="fas fa-envelope me-2" style="color: var(--primary);"></i>Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" name="email" value="{{ old('email') }}"
                            placeholder="Enter your email" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label"><i class="fas fa-lock me-2" style="color: var(--primary);"></i>Password</label>
                        <div class="password-wrapper">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password"
                                placeholder="Enter your password" required>
                            <button type="button" class="password-toggle" onclick="togglePasswordVisibility()">
                                <i class="fas fa-eye" id="passwordIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Remember Me -->
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Sign In
                    </button>
                </form>
                
                <!-- Divider -->
                <div class="divider">
                    <span>New to ManageX?</span>
                </div>
                
                <!-- Create Account Link -->
                <p style="text-align: center; margin-bottom: 0;">
                    <a href="{{ route('register') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">
                        Create account
                    </a>
                </p>
                
                <!-- Demo Info -->
                <div class="demo-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Demo:</strong> customer@example.com | Password: password
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Password Toggle Script -->
    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>

