<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Dashboard') — ManageX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="{{ asset('css/modern.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary: #001f3f;
            --primary-dark: #001428;
            --white: #ffffff;
            --light-bg: #f8f9fa;
            --text-dark: #1a1a1a;
            --text-muted: #6c757d;
            --border: #e9ecef;
        }

        body {
            background-color: var(--white);
        }

        .navbar {
            background-color: var(--white);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0, 31, 63, 0.06);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary) !important;
            font-size: 1.4rem;
        }

        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            margin: 0 0.25rem;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-toggler:focus {
            box-shadow: none;
            outline: 1px solid var(--border);
        }

        main {
            padding: 2rem 0;
        }

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

        .table {
            background-color: var(--white);
        }

        .table thead th {
            background-color: var(--light-bg);
            border: none;
            font-weight: 600;
            color: var(--text-dark);
            padding: 1rem;
        }

        .table tbody td {
            border: none;
            padding: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .table tbody tr:hover {
            background-color: rgba(0, 31, 63, 0.02);
        }

        .badge {
            padding: 0.5rem 0.75rem;
            font-weight: 500;
            border-radius: 6px;
        }

        .badge-primary {
            background-color: rgba(0, 31, 63, 0.1);
            color: var(--primary);
        }

        .alert {
            border: none;
            border-radius: 8px;
            border-left: 4px solid;
        }

        .alert-success {
            background-color: #f0f8f4;
            border-left-color: #10b981;
            color: #065f46;
        }

        .link-accent {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .link-accent:hover {
            color: var(--primary-dark);
        }

        .fw-600 {
            font-weight: 600;
        }

        .text-accent {
            color: var(--primary);
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('customer.partials.nav')

    <main>
        <div class="container-fluid px-4">
            @if (session('success'))
                <div class="mb-4">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

