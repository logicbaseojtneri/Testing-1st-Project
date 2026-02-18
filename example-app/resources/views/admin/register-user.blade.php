@extends('admin.layouts.app')

@section('title', 'Register User')

@push('styles')
<style>
    .register-card {
        border-radius: 16px;
        overflow: hidden;
    }
    .register-header {
        background: linear-gradient(135deg, #001f3f 0%, #003366 100%);
        padding: 2rem 2.5rem;
        position: relative;
        overflow: hidden;
    }
    .register-header::before {
        content: '';
        position: absolute;
        top: -30px;
        right: -30px;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
    }
    .register-header::after {
        content: '';
        position: absolute;
        bottom: -40px;
        right: 60px;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255,255,255,0.03);
    }
    .register-header h4 {
        color: #fff;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    .register-header p {
        color: rgba(255,255,255,0.7);
        font-size: 0.85rem;
        margin-bottom: 0;
    }
    .form-floating > .form-control,
    .form-floating > .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        height: calc(3.5rem + 4px);
        padding: 1rem 1rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .form-floating > .form-control:focus,
    .form-floating > .form-select:focus {
        border-color: #001f3f;
        box-shadow: 0 0 0 3px rgba(0, 31, 63, 0.1);
    }
    .form-floating > label {
        padding: 1rem;
        color: #6c757d;
    }
    .role-option {
        cursor: pointer;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
        background: #fff;
    }
    .role-option:hover {
        border-color: #001f3f;
        background: rgba(0, 31, 63, 0.02);
    }
    .role-option.selected {
        border-color: #001f3f;
        background: rgba(0, 31, 63, 0.04);
    }
    .role-option .role-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
    }
    .role-option .role-name {
        font-weight: 600;
        color: #1a1a1a;
        font-size: 0.85rem;
    }
    .role-option .role-desc {
        font-size: 0.7rem;
        color: #6c757d;
        margin: 0;
    }
    .password-wrapper {
        position: relative;
    }
    .password-toggle {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #6c757d;
        cursor: pointer;
        z-index: 5;
        padding: 4px;
        font-size: 0.9rem;
    }
    .password-toggle:hover {
        color: #001f3f;
    }
    .password-strength {
        height: 4px;
        border-radius: 2px;
        background: #e9ecef;
        margin-top: 0.5rem;
        overflow: hidden;
    }
    .password-strength-bar {
        height: 100%;
        border-radius: 2px;
        width: 0%;
        transition: width 0.3s ease, background 0.3s ease;
    }
    .btn-register {
        background: linear-gradient(135deg, #001f3f 0%, #003366 100%);
        border: none;
        padding: 0.85rem;
        font-weight: 600;
        font-size: 1rem;
        border-radius: 10px;
        letter-spacing: 0.3px;
        transition: all 0.3s ease;
    }
    .btn-register:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(0, 31, 63, 0.3);
        background: linear-gradient(135deg, #001428 0%, #002952 100%);
    }
    .step-indicator {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }
    .step-indicator .step {
        flex: 1;
        height: 4px;
        border-radius: 2px;
        background: #e9ecef;
        transition: background 0.3s;
    }
    .step-indicator .step.active {
        background: #001f3f;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4 px-4">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-xl-6">

            <!-- Back Link -->
            <div class="mb-4">
                <a href="{{ route('admin.users.index') }}" class="text-decoration-none text-muted" style="font-size: 0.85rem;">
                    <i class="fas fa-arrow-left me-1"></i>Back to Manage Profiles
                </a>
            </div>

            <!-- Registration Card -->
            <div class="card register-card border-0" style="box-shadow: 0 4px 24px rgba(0, 31, 63, 0.1);">

                <!-- Header -->
                <div class="register-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: rgba(255,255,255,0.15);">
                            <i class="fas fa-user-plus text-white" style="font-size: 1.2rem;"></i>
                        </div>
                        <div>
                            <h4>Register New User</h4>
                            <p>Create a new account and assign a role in the system</p>
                        </div>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="card-body p-4 pt-4">

                    <!-- Step Indicator -->
                    <div class="step-indicator">
                        <div class="step active" id="step1"></div>
                        <div class="step" id="step2"></div>
                        <div class="step" id="step3"></div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger d-flex align-items-start gap-2 mb-4" style="border-radius: 10px;">
                            <i class="fas fa-exclamation-triangle mt-1"></i>
                            <div>
                                <strong style="font-size: 0.85rem;">Please fix the following errors:</strong>
                                <ul class="mb-0 ps-3 mt-1" style="font-size: 0.8rem;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin.register-user.store') }}" method="POST" id="registerForm">
                        @csrf

                        <!-- Section: Personal Information -->
                        <div class="mb-4">
                            <h6 class="fw-700 mb-3 d-flex align-items-center gap-2" style="color: #001f3f; font-size: 0.85rem;">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 22px; height: 22px; background: #001f3f; color: #fff; font-size: 0.65rem;">1</span>
                                Personal Information
                            </h6>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name') }}"
                                               placeholder="Full Name" required>
                                        <label for="name"><i class="fas fa-user me-2 text-muted"></i>Full Name</label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               id="email" name="email" value="{{ old('email') }}"
                                               placeholder="email@example.com" required>
                                        <label for="email"><i class="fas fa-envelope me-2 text-muted"></i>Email Address</label>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section: Role Selection -->
                        <div class="mb-4">
                            <h6 class="fw-700 mb-3 d-flex align-items-center gap-2" style="color: #001f3f; font-size: 0.85rem;">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 22px; height: 22px; background: #001f3f; color: #fff; font-size: 0.65rem;">2</span>
                                Select Role
                            </h6>
                            <input type="hidden" id="role" name="role" value="{{ old('role') }}" required>
                            <div class="row g-2">
                                @php
                                    $roleIcons = [
                                        'customer' => ['icon' => 'fa-briefcase', 'color' => '#0d6efd', 'bg' => 'rgba(13,110,253,0.1)', 'desc' => 'Can create projects & tasks'],
                                        'developer' => ['icon' => 'fa-code', 'color' => '#6f42c1', 'bg' => 'rgba(111,66,193,0.1)', 'desc' => 'General developer access'],
                                        'frontend' => ['icon' => 'fa-palette', 'color' => '#0dcaf0', 'bg' => 'rgba(13,202,240,0.1)', 'desc' => 'Frontend development tasks'],
                                        'backend' => ['icon' => 'fa-database', 'color' => '#198754', 'bg' => 'rgba(25,135,84,0.1)', 'desc' => 'Backend development tasks'],
                                        'server_admin' => ['icon' => 'fa-server', 'color' => '#dc3545', 'bg' => 'rgba(220,53,69,0.1)', 'desc' => 'Server & infrastructure'],
                                        'admin' => ['icon' => 'fa-shield-halved', 'color' => '#001f3f', 'bg' => 'rgba(0,31,63,0.1)', 'desc' => 'Full system administrator'],
                                    ];
                                @endphp
                                @foreach ($roles as $value => $label)
                                @php $meta = $roleIcons[$value] ?? ['icon' => 'fa-user', 'color' => '#6c757d', 'bg' => '#f0f0f0', 'desc' => '']; @endphp
                                <div class="col-md-6">
                                    <div class="role-option d-flex align-items-center gap-3 {{ old('role') == $value ? 'selected' : '' }}"
                                         data-role="{{ $value }}" onclick="selectRole('{{ $value }}')">
                                        <div class="role-icon" style="background: {{ $meta['bg'] }}; color: {{ $meta['color'] }};">
                                            <i class="fas {{ $meta['icon'] }}"></i>
                                        </div>
                                        <div>
                                            <div class="role-name">{{ $label }}</div>
                                            <p class="role-desc">{{ $meta['desc'] }}</p>
                                        </div>
                                        <div class="ms-auto">
                                            <i class="fas fa-check-circle" style="color: #001f3f; display: {{ old('role') == $value ? 'block' : 'none' }};"></i>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @error('role')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Section: Security -->
                        <div class="mb-4">
                            <h6 class="fw-700 mb-3 d-flex align-items-center gap-2" style="color: #001f3f; font-size: 0.85rem;">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 22px; height: 22px; background: #001f3f; color: #fff; font-size: 0.65rem;">3</span>
                                Security
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating password-wrapper">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                               id="password" name="password"
                                               placeholder="Password" required>
                                        <label for="password"><i class="fas fa-lock me-2 text-muted"></i>Password</label>
                                        <button type="button" class="password-toggle" onclick="togglePassword('password', this)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="password-strength">
                                        <div class="password-strength-bar" id="strengthBar"></div>
                                    </div>
                                    <small class="text-muted" id="strengthText" style="font-size: 0.7rem;"></small>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating password-wrapper">
                                        <input type="password" class="form-control"
                                               id="password_confirmation" name="password_confirmation"
                                               placeholder="Confirm Password" required>
                                        <label for="password_confirmation"><i class="fas fa-lock me-2 text-muted"></i>Confirm Password</label>
                                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted mt-1 d-block" id="matchText" style="font-size: 0.7rem;"></small>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Actions -->
                        <div class="d-flex gap-3 pt-3" style="border-top: 1px solid #e9ecef;">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary flex-shrink-0 px-4" style="border-radius: 10px;">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-register text-white w-100" id="submitBtn">
                                <i class="fas fa-user-plus me-2"></i>Register User
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Info -->
            <div class="mt-3 text-center">
                <small class="text-muted" style="font-size: 0.75rem;">
                    <i class="fas fa-info-circle me-1"></i>
                    The user will receive their credentials and can log in immediately after registration.
                </small>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Role selection
    function selectRole(role) {
        document.getElementById('role').value = role;
        document.querySelectorAll('.role-option').forEach(el => {
            el.classList.remove('selected');
            el.querySelector('.fa-check-circle').style.display = 'none';
        });
        const selected = document.querySelector(`.role-option[data-role="${role}"]`);
        selected.classList.add('selected');
        selected.querySelector('.fa-check-circle').style.display = 'block';
        updateSteps();
    }

    // Toggle password visibility
    function togglePassword(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // Password strength meter
    document.getElementById('password').addEventListener('input', function() {
        const val = this.value;
        const bar = document.getElementById('strengthBar');
        const text = document.getElementById('strengthText');
        let score = 0;

        if (val.length >= 8) score++;
        if (val.length >= 12) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const levels = [
            { width: '0%', color: '#e9ecef', label: '' },
            { width: '20%', color: '#dc3545', label: 'Very Weak' },
            { width: '40%', color: '#fd7e14', label: 'Weak' },
            { width: '60%', color: '#ffc107', label: 'Fair' },
            { width: '80%', color: '#20c997', label: 'Strong' },
            { width: '100%', color: '#198754', label: 'Very Strong' },
        ];

        bar.style.width = levels[score].width;
        bar.style.background = levels[score].color;
        text.textContent = val.length > 0 ? levels[score].label : '';
        text.style.color = levels[score].color;

        updateSteps();
        checkMatch();
    });

    // Password match check
    document.getElementById('password_confirmation').addEventListener('input', checkMatch);

    function checkMatch() {
        const pw = document.getElementById('password').value;
        const confirm = document.getElementById('password_confirmation').value;
        const text = document.getElementById('matchText');

        if (confirm.length === 0) {
            text.textContent = '';
            return;
        }

        if (pw === confirm) {
            text.textContent = '✓ Passwords match';
            text.style.color = '#198754';
        } else {
            text.textContent = '✗ Passwords do not match';
            text.style.color = '#dc3545';
        }
    }

    // Step indicator
    function updateSteps() {
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const role = document.getElementById('role').value;
        const password = document.getElementById('password').value;

        document.getElementById('step1').classList.toggle('active', name.length > 0 || email.length > 0);
        document.getElementById('step2').classList.toggle('active', role.length > 0);
        document.getElementById('step3').classList.toggle('active', password.length >= 8);
    }

    // Listen to inputs for step updates
    document.getElementById('name').addEventListener('input', updateSteps);
    document.getElementById('email').addEventListener('input', updateSteps);

    // Init steps on page load (for old() values)
    updateSteps();
</script>
@endpush
