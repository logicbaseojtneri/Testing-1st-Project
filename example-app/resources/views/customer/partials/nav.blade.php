<nav class="navbar navbar-expand-lg navbar-light navbar-customer py-3">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ route('customer.dashboard') }}">
            <i class="fas fa-tasks me-2"></i>ManageX
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <!-- Dashboard Link -->
                <li class="nav-item">
                    <a class="nav-link px-3" href="{{ route('customer.dashboard') }}">
                        <i class="fas fa-home me-2 opacity-75"></i>Dashboard
                    </a>
                </li>

                <!-- Projects Link -->
                <li class="nav-item">
                    <a class="nav-link px-3" href="{{ route('customer.projects.index') }}">
                        <i class="fas fa-folder me-2 opacity-75"></i>Projects
                    </a>
                </li>

                <!-- All Tasks -->
                <li class="nav-item">
                    <a class="nav-link px-3" href="{{ route('customer.tasks.all') }}">
                        <i class="fas fa-list me-2 opacity-75"></i>All Tasks
                    </a>
                </li>

                <!-- Search -->
                <li class="nav-item">
                    <form class="d-flex search-form" method="GET" action="{{ route('customer.tasks.search') }}" style="width: 250px;">
                        <div class="input-group input-group-sm" style="border-radius: 8px; overflow: hidden; box-shadow: 0 1px 4px rgba(0, 31, 63, 0.08);">
                            <input class="form-control border-0" type="search" name="query" placeholder="Search tasks..." aria-label="Search" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                            <button class="btn btn-outline-secondary border-0" type="submit" style="background-color: #001f3f; color: white; padding: 0.5rem 1rem;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </li>

                <!-- Filter -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-3" href="#" id="filterDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-filter me-2 opacity-75"></i>Filter
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                        <li><h6 class="dropdown-header">Filter by Status</h6></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('customer.tasks.filter', ['status' => 'to_do']) }}">
                                <span class="badge me-2" style="background-color: #9e9e9e; padding: 0.35rem 0.6rem; font-size: 0.75rem;"></span>To Do
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('customer.tasks.filter', ['status' => 'in_progress']) }}">
                                <span class="badge me-2" style="background-color: #ff9800; padding: 0.35rem 0.6rem; font-size: 0.75rem;"></span>In Progress
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('customer.tasks.filter', ['status' => 'done']) }}">
                                <span class="badge me-2" style="background-color: #4caf50; padding: 0.35rem 0.6rem; font-size: 0.75rem;"></span>Done
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('customer.tasks.filter', ['status' => 'pending']) }}">
                                <span class="badge me-2" style="background-color: #f44336; padding: 0.35rem 0.6rem; font-size: 0.75rem;"></span>Pending
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><h6 class="dropdown-header">Filter by Category</h6></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('customer.tasks.filter', ['category' => 'frontend']) }}">
                                <i class="fas fa-code me-2"></i>Frontend Developer
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('customer.tasks.filter', ['category' => 'backend']) }}">
                                <i class="fas fa-database me-2"></i>Backend Developer
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('customer.tasks.filter', ['category' => 'server']) }}">
                                <i class="fas fa-server me-2"></i>Server Administrator
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- User Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-3" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="display: flex; align-items: center;">
                        <i class="fas fa-user-circle" style="font-size: 1.5rem;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <!-- User Info Header -->
                        <li class="dropdown-header" style="border-bottom: 1px solid rgba(0, 31, 63, 0.1); padding: 1rem;">
                            <div style="margin: 0;">
                                <p style="color: #1a1a1a; font-weight: 700; font-size: 1rem; margin: 0 0 0.5rem 0;">{{ auth()->user()->name }}</p>
                                <p style="color: #6c757d; font-size: 0.85rem; margin: 0; word-break: break-word;">{{ auth()->user()->email }}</p>
                            </div>
                        </li>
                        <!-- Logout -->
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
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

<style>
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
    
    .dropdown-menu.show {
        display: block;
    }
    
    .dropdown-item {
        padding: 0.75rem 1rem;
        font-weight: 500;
        color: #1a1a1a;
        transition: all 0.2s ease;
        display: block;
        width: 100%;
        text-align: left;
        clear: both;
        white-space: nowrap;
        cursor: pointer;
        text-decoration: none;
    }
    
    a.dropdown-item {
        color: #1a1a1a;
        text-decoration: none;
        display: block;
        width: 100%;
        padding: 0.75rem 1rem;
    }
    
    a.dropdown-item:hover {
        background-color: rgba(0, 31, 63, 0.05);
        color: #001f3f;
        text-decoration: none;
    }
    
    .dropdown-item:hover {
        background-color: rgba(0, 31, 63, 0.05);
        color: #001f3f;
        text-decoration: none;
    }
    
    .dropdown-item.active, .dropdown-item:active {
        background-color: rgba(0, 31, 63, 0.1);
        color: #001f3f;
    }
    
    .dropdown-header {
        color: #6c757d;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.75rem 1rem 0.5rem;
    }
    
    .dropdown-divider {
        margin: 0.5rem 0;
        border-top: 1px solid rgba(0, 31, 63, 0.1);
    }
    
    .search-form .input-group-sm .form-control {
        font-size: 0.9rem;
    }
    
    .navbar-brand {
        font-weight: 700;
        font-size: 1.3rem;
    }
</style>
