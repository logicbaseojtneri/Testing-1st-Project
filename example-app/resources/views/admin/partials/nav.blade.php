<nav class="navbar navbar-expand-lg navbar-admin py-2">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-shield-halved me-2"></i>ManageX <span class="badge bg-light text-primary ms-1" style="font-size: 0.6rem; vertical-align: middle;">ADMIN</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav ms-auto align-items-center gap-1">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                    </a>
                </li>

                <!-- Register User -->
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('admin.register-user.*') ? 'active' : '' }}" href="{{ route('admin.register-user.form') }}">
                        <i class="fas fa-user-plus me-1"></i>Register User
                    </a>
                </li>

                <!-- Manage Profiles -->
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users-cog me-1"></i>Manage Profiles
                    </a>
                </li>

                <!-- Manage Projects -->
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}" href="{{ route('admin.projects.index') }}">
                        <i class="fas fa-folder-open me-1"></i>Manage Projects
                    </a>
                </li>

                <!-- Manage Tasks -->
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}" href="{{ route('admin.tasks.index') }}">
                        <i class="fas fa-clipboard-list me-1"></i>Manage Tasks
                    </a>
                </li>

                <!-- Trash -->
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('admin.trash') ? 'active' : '' }}" href="{{ route('admin.trash') }}">
                        <i class="fas fa-trash-restore me-1"></i>Trash
                    </a>
                </li>

                <!-- Notifications -->
                <li class="nav-item">
                    <a class="nav-link px-3 position-relative {{ request()->routeIs('admin.notifications') ? 'active' : '' }}" href="{{ route('admin.notifications') }}" id="navNotifLink">
                        <i class="fas fa-bell me-1"></i>Notifications
                        @if(auth()->user()->unreadNotifications()->count() > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="navNotifBadge" style="font-size: 0.6rem; min-width: 18px; padding: 3px 5px;">
                            {{ auth()->user()->unreadNotifications()->count() }}
                        </span>
                        @else
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none" id="navNotifBadge" style="font-size: 0.6rem; min-width: 18px; padding: 3px 5px;">0</span>
                        @endif
                    </a>
                </li>

                <!-- Admin Profile Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-3" href="#" id="adminUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="display: flex; align-items: center;">
                        <i class="fas fa-user-shield me-1" style="font-size: 1.1rem;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminUserDropdown">
                        <li class="dropdown-header" style="border-bottom: 1px solid rgba(0, 31, 63, 0.1); padding: 1rem;">
                            <div>
                                <p style="color: #1a1a1a; font-weight: 700; font-size: 1rem; margin: 0 0 0.35rem 0;">{{ auth()->user()->name }}</p>
                                <p style="color: #6c757d; font-size: 0.8rem; margin: 0 0 0.15rem 0;">{{ auth()->user()->email }}</p>
                                <span class="badge" style="background-color: var(--primary); color: white; font-size: 0.7rem;">Administrator</span>
                            </div>
                        </li>
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
