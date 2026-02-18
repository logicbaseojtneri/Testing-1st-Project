<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') — ManageX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary: #001f3f;
            --primary-dark: #001428;
            --accent: #0d6efd;
            --white: #ffffff;
            --light-bg: #f8f9fa;
            --text-dark: #1a1a1a;
            --text-muted: #6c757d;
            --border: #e9ecef;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        /* Navbar */
        .navbar-admin {
            background-color: var(--primary);
            border-bottom: 3px solid var(--accent);
            box-shadow: 0 2px 12px rgba(0, 31, 63, 0.25);
        }

        .navbar-admin .navbar-brand {
            font-weight: 700;
            color: var(--white) !important;
            font-size: 1.4rem;
        }

        .navbar-admin .nav-link {
            color: rgba(255,255,255,0.85) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            margin: 0 0.15rem;
            border-radius: 6px;
            padding: 0.5rem 0.85rem !important;
            font-size: 0.9rem;
        }

        .navbar-admin .nav-link:hover,
        .navbar-admin .nav-link.active {
            color: var(--white) !important;
            background-color: rgba(255,255,255,0.12);
        }

        .navbar-admin .navbar-toggler {
            border-color: rgba(255,255,255,0.3);
        }

        .navbar-admin .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.85%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Main */
        main {
            padding: 2rem 0;
            min-height: calc(100vh - 70px);
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
            font-weight: 500;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: var(--white);
            border-color: var(--primary);
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 31, 63, 0.06);
            background-color: var(--white);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 16px rgba(0, 31, 63, 0.1);
        }

        /* Tables */
        .table {
            background-color: var(--white);
        }

        .table thead th {
            background-color: var(--primary);
            border: none;
            font-weight: 600;
            color: var(--white);
            padding: 1rem;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            border: none;
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: rgba(0, 31, 63, 0.03);
        }

        /* Badges */
        .badge {
            padding: 0.5rem 0.75rem;
            font-weight: 600;
            border-radius: 6px;
            font-size: 0.75rem;
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: 8px;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        .alert-warning {
            background-color: #fef3c7;
            color: #92400e;
            border-left: 4px solid #f59e0b;
        }

        .alert-info {
            background-color: #dbeafe;
            color: #1e40af;
            border-left: 4px solid #3b82f6;
        }

        /* Dropdown */
        .dropdown-menu {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 31, 63, 0.15);
            margin-top: 0.5rem;
            min-width: 200px;
            z-index: 1050;
            background-color: #ffffff;
            border: 1px solid rgba(0, 31, 63, 0.08);
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-dark);
            transition: background-color 0.2s ease;
            border-radius: 4px;
            margin: 2px 6px;
        }

        .dropdown-item:hover {
            background-color: rgba(0, 31, 63, 0.06);
            color: var(--primary);
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
        }

        /* Links */
        a {
            color: var(--primary);
            text-decoration: none;
        }

        a:hover {
            color: var(--primary-dark);
        }

        /* Pagination override */
        .pagination .page-link {
            color: var(--primary);
            border-color: var(--border);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
            color: var(--white);
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--light-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .fw-500 { font-weight: 500; }
        .fw-600 { font-weight: 600; }
        .fw-700 { font-weight: 700; }
        .fw-800 { font-weight: 800; }
    </style>
    @stack('styles')
</head>
<body>
    @include('admin.partials.nav')

    <main>
        <div class="container-fluid px-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- Undo Delete Toast --}}
    @if(session('deleted_user'))
    <div id="undoToast" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1090;">
        <div class="toast show border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" style="min-width: 340px; border-radius: 12px; overflow: hidden; background: #001f3f;">
            <div class="d-flex align-items-center px-3 pt-3 pb-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px; background: rgba(255,255,255,0.15); flex-shrink: 0;">
                    <i class="fas fa-trash-alt text-white" style="font-size: 0.85rem;"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="text-white fw-600" style="font-size: 0.85rem;">User Deleted</div>
                    <div class="text-white-50" style="font-size: 0.78rem;">
                        <strong class="text-white">{{ session('deleted_user')['name'] }}</strong> has been removed
                    </div>
                </div>
                <form id="undoForm" action="{{ route('admin.users.restore', session('deleted_user')['id']) }}" method="POST" class="ms-2">
                    @csrf
                    <button type="submit" class="btn btn-sm fw-600" style="background: rgba(255,255,255,0.15); color: #5dade2; border: 1px solid rgba(93,173,226,0.4); border-radius: 8px; font-size: 0.78rem; padding: 4px 14px; white-space: nowrap;">
                        <i class="fas fa-undo me-1"></i>Undo
                    </button>
                </form>
            </div>
            {{-- Countdown progress bar --}}
            <div class="px-3 pb-2 pt-1">
                <div style="height: 3px; background: rgba(255,255,255,0.1); border-radius: 3px; overflow: hidden;">
                    <div id="undoProgress" style="height: 100%; width: 100%; background: #5dade2; border-radius: 3px; transition: width linear;"></div>
                </div>
                <div class="d-flex justify-content-between mt-1">
                    <span class="text-white-50" style="font-size: 0.7rem;">Auto-dismissing in <span id="undoCountdown">10</span>s</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Notification badge polling --}}
    <script>
    (function() {
        const badge = document.getElementById('navNotifBadge');
        if (!badge) return;

        function pollNotifications() {
            fetch('/api/notifications/unread', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.count > 0) {
                    badge.textContent = data.count > 99 ? '99+' : data.count;
                    badge.classList.remove('d-none');
                } else {
                    badge.classList.add('d-none');
                }
            })
            .catch(() => {});
        }

        // Poll every 30 seconds
        setInterval(pollNotifications, 30000);
    })();
    </script>

    @stack('scripts')

    @if(session('deleted_user'))
    <script>
    (function() {
        const duration = 10;
        let remaining = duration;
        const progressBar = document.getElementById('undoProgress');
        const countdownEl = document.getElementById('undoCountdown');
        const toastEl = document.getElementById('undoToast');

        progressBar.style.transition = 'none';
        progressBar.style.width = '100%';

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                progressBar.style.transition = `width ${duration}s linear`;
                progressBar.style.width = '0%';
            });
        });

        const interval = setInterval(() => {
            remaining--;
            countdownEl.textContent = remaining;
            if (remaining <= 0) {
                clearInterval(interval);
                toastEl.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                toastEl.style.opacity = '0';
                toastEl.style.transform = 'translateY(20px)';
                setTimeout(() => toastEl.remove(), 500);
            }
        }, 1000);
    })();
    </script>
    @endif
</body>
</html>
