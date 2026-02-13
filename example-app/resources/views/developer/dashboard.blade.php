<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ManageX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
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
            color: var(--primary);
            font-size: 1.4rem;
        }

        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        h1 {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: var(--text-muted);
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 31, 63, 0.06);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 24px rgba(0, 31, 63, 0.12);
            transform: translateY(-2px);
        }

        .card-body {
            padding: 2rem;
        }

        .card-title {
            color: var(--text-dark);
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .card-text {
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .role-badge {
            display: inline-block;
            background-color: rgba(0, 31, 63, 0.1);
            color: var(--primary);
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="#">
                <i class="fas fa-tasks me-2"></i>TaskFlow
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('developer.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('developer.tasks.index') }}">Tasks</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="mb-4">
            <h1>Welcome, {{ auth()->user()->name }}! 👋</h1>
            <p class="subtitle">
                <span class="role-badge">{{ auth()->user()->role->label() }}</span>
            </p>
        </div>

        <div class="row">
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-tasks text-primary me-2"></i>My Tasks
                        </h5>
                        <p class="card-text">View and manage all tasks assigned to you.</p>
                        <a href="{{ route('developer.tasks.index') }}" class="btn btn-primary">View Tasks</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-chart-bar text-primary me-2"></i>Progress
                        </h5>
                        <p class="card-text">Track your task completion rate and progress.</p>
                        <button type="button" class="btn btn-primary" disabled>Coming Soon</button>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-bell text-primary me-2"></i>Notifications
                        </h5>
                        <p class="card-text">Stay updated with latest task assignments.</p>
                        <button type="button" class="btn btn-primary" disabled>Coming Soon</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

