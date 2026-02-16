<nav class="navbar navbar-expand-lg navbar-light py-3">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ route('developer.dashboard') }}">
            <i class="fas fa-tasks me-2"></i>ManageX
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <!-- Dashboard Link -->
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('developer.dashboard') ? 'active' : '' }}" href="{{ route('developer.dashboard') }}">
                        <i class="fas fa-home me-2 opacity-75"></i>Dashboard
                    </a>
                </li>

                <!-- Projects Link -->
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('developer.projects.*') ? 'active' : '' }}" href="{{ route('developer.projects.index') }}">
                        <i class="fas fa-folder me-2 opacity-75"></i>Projects
                    </a>
                </li>

                <!-- My Tasks -->
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('developer.tasks.*') ? 'active' : '' }}" href="{{ route('developer.tasks.index') }}">
                        <i class="fas fa-list me-2 opacity-75"></i>My Tasks
                    </a>
                </li>

                <!-- Notifications -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-3 position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="display: flex; align-items: center;">
                        <i class="fas fa-bell" style="font-size: 1.2rem;"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationBadge" style="display: none; font-size: 0.65rem; padding: 0.25rem 0.5rem;">
                            0
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="min-width: 360px; max-height: 400px; overflow-y: auto;">
                        <!-- Notifications will be loaded here by JavaScript -->
                        <li class="dropdown-header text-center py-3">
                            <i class="fas fa-spinner fa-spin me-2"></i>Loading notifications...
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
                                <p style="color: #6c757d; font-size: 0.85rem; margin: 0;">Developer</p>
                            </div>
                        </li>

                        <!-- Logout -->
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="display: contents;">
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
