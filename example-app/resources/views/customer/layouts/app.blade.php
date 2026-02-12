<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Dashboard') — Task Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --customer-bg: #ffffff;
            --customer-surface: #ffffff;
            --customer-border: #e5e7eb;
            --customer-text: #111827;
            --customer-text-muted: #6b7280;
            --customer-accent: #2563eb;
            --customer-accent-hover: #1d4ed8;
            --customer-accent-light: #eff6ff;
        }
        body { font-family: 'Inter', sans-serif; background: var(--customer-bg); color: var(--customer-text); min-height: 100vh; }
        .navbar-customer { background: var(--customer-surface) !important; border-bottom: 1px solid var(--customer-border); box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
        .navbar-customer .navbar-brand { font-weight: 700; color: var(--customer-accent) !important; }
        .navbar-customer .nav-link { color: var(--customer-text-muted) !important; font-weight: 500; }
        .navbar-customer .nav-link:hover { color: var(--customer-accent) !important; }
        .navbar-customer .navbar-toggler { border-color: var(--customer-border); }
        .navbar-customer .navbar-toggler-icon { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e"); }
        .btn-primary { background: var(--customer-accent); border-color: var(--customer-accent); font-weight: 500; }
        .btn-primary:hover { background: var(--customer-accent-hover); border-color: var(--customer-accent-hover); }
        .btn-outline-primary { color: var(--customer-accent); border-color: var(--customer-accent); }
        .btn-outline-primary:hover { background: var(--customer-accent-light); color: var(--customer-accent-hover); border-color: var(--customer-accent-hover); }
        .btn-customer-primary { background: var(--customer-accent); border-color: var(--customer-accent); color: #fff; font-weight: 500; }
        .btn-outline-customer { color: var(--customer-accent); border-color: var(--customer-accent); font-weight: 500; }
        .btn-outline-customer:hover { background: var(--customer-accent-light); color: var(--customer-accent-hover); border-color: var(--customer-accent-hover); }
        .card-customer { background: var(--customer-surface); border: 1px solid var(--customer-border); border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); }
        .table-customer thead th { background: #f9fafb; color: var(--customer-text); font-weight: 600; font-size: 0.8125rem; text-transform: none; border-bottom: 1px solid var(--customer-border); }
        .table-customer tbody tr:hover { background: var(--customer-accent-light); }
        .badge-customer { background: var(--customer-accent-light); color: var(--customer-accent); font-weight: 500; }
        .text-accent { color: var(--customer-accent); }
        .link-accent { color: var(--customer-accent); text-decoration: none; font-weight: 500; }
        .link-accent:hover { color: var(--customer-accent-hover); }
        .fw-600 { font-weight: 600; }
    </style>
    @stack('styles')
</head>
<body>
    @include('customer.partials.nav')

    <main class="py-4">
        @if (session('success'))
            <div class="container mb-3">
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
