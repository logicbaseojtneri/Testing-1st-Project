<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Create your ManageX account">
    <meta name="author" content="ManageX Team">

    <title>Register - ManageX</title>

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
            --success: #28a745;
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
        
        .register-container {
            width: 100%;
            max-width: 450px;
        }
        
        .register-card {
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
        
        .register-header {
            background: var(--white);
            color: var(--primary);
            padding: 2rem 1.5rem 1.5rem;
            text-align: center;
        }
        
        .register-header h1 {
            font-size: 1.8rem;
            font-weight: 800;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }
        
        .register-header p {
            margin: 0.5rem 0 0 0;
            font-size: 0.95rem;
            color: var(--text-muted);
        }
        
        .register-body {
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
        
        .form-select {
            border: 2px solid var(--border);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: var(--white);
            cursor: pointer;
        }
        
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 31, 63, 0.1);
            outline: none;
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
        
        .alert {
            border: none;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        
        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }
        
        .btn-register {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            border: none;
            padding: 0.85rem 1.5rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
            box-shadow: 0 8px 20px rgba(0, 31, 63, 0.2);
        }
        
        .btn-register:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(0, 31, 63, 0.3);
            color: var(--white);
        }
        
        .btn-register:active {
            transform: translateY(0);
        }
        
        .register-footer {
            border-top: 1px solid var(--border);
            padding-top: 1.5rem;
            text-align: center;
        }
        
        .register-footer p {
            color: var(--text-muted);
            margin-bottom: 0;
            font-size: 0.95rem;
        }
        
        .register-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .register-footer a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        .role-hint {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 0.3rem;
        }
        
        .password-requirements {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 0.3rem;
        }
        
        .invalid-feedback {
            display: block;
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 0.3rem;
            font-weight: 500;
        }
        
        @media (max-width: 576px) {
            .register-header {
                padding: 1.5rem 1rem;
            }
            
            .register-header h1 {
                font-size: 1.4rem;
            }
            
            .register-body {
                padding: 1.5rem 1rem;
            }
        }
    </style>
</head>

<body>

    <div class="register-container">
        <div class="register-card">
            <!-- Header -->
            <div class="register-header">
                <h1><i class="fas fa-tasks"></i> ManageX</h1>
                <p>Create Your Account</p>
            </div>

            <!-- Body -->
            <div class="register-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-exclamation-circle me-2"></i>Registration Failed!</strong>
                        @foreach ($errors->all() as $error)
                            <div style="font-size: 0.9rem; margin-top: 0.3rem;">• {{ $error }}</div>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <!-- Full Name -->
                    <div class="form-group">
                        <label for="name" class="form-label"><i class="fas fa-user me-2" style="color: var(--primary);"></i>Full Name</label>
                        <input 
                            type="text" 
                            class="form-control @error('name') is-invalid @enderror"
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}"
                            placeholder="Enter your full name"
                            required
                            autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label"><i class="fas fa-envelope me-2" style="color: var(--primary);"></i>Email Address</label>
                        <input 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror"
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            placeholder="Enter your email"
                            required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Role Selection -->
                    <div class="form-group">
                        <label for="role" class="form-label"><i class="fas fa-briefcase me-2" style="color: var(--primary);"></i>Select Role</label>
                        <select 
                            class="form-select @error('role') is-invalid @enderror"
                            id="role" 
                            name="role" 
                            required>
                            <option value="">-- Choose your role --</option>
                            <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer (Project Manager)</option>
                            <option value="frontend" {{ old('role') == 'frontend' ? 'selected' : '' }}>Frontend Developer</option>
                            <option value="backend" {{ old('role') == 'backend' ? 'selected' : '' }}>Backend Developer</option>
                            <option value="server_admin" {{ old('role') == 'server_admin' ? 'selected' : '' }}>Server Administrator</option>
                        </select>
                        <div class="role-hint">Choose the role that best describes your position</div>
                        @error('role')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label"><i class="fas fa-lock me-2" style="color: var(--primary);"></i>Password</label>
                        <div class="password-wrapper">
                            <input 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror"
                                id="password" 
                                name="password"
                                placeholder="Create a strong password"
                                required>
                            <button 
                                type="button" 
                                class="password-toggle" 
                                onclick="togglePasswordVisibility('password')">
                                <i class="fas fa-eye" id="passwordIcon"></i>
                            </button>
                        </div>
                        <div class="password-requirements">At least 8 characters with mix of letters, numbers & symbols</div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label"><i class="fas fa-lock me-2" style="color: var(--primary);"></i>Confirm Password</label>
                        <div class="password-wrapper">
                            <input 
                                type="password" 
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" 
                                name="password_confirmation"
                                placeholder="Confirm your password"
                                required>
                            <button 
                                type="button" 
                                class="password-toggle" 
                                onclick="togglePasswordVisibility('password_confirmation')">
                                <i class="fas fa-eye" id="passwordConfirmIcon"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-register">
                        <i class="fas fa-user-plus me-2"></i>Create Account
                    </button>
                </form>

                <!-- Footer -->
                <div class="register-footer">
                    <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Password Toggle Script -->
    <script>
        function togglePasswordVisibility(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const iconId = fieldId === 'password' ? 'passwordIcon' : 'passwordConfirmIcon';
            const passwordIcon = document.getElementById(iconId);
            
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
