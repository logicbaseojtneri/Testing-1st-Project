<nav class="navbar navbar-expand-lg navbar-light navbar-customer py-3">
    <div class="container">
        <a class="navbar-brand" href="{{ route('customer.dashboard') }}">Task Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item">
                    <a class="nav-link px-3" href="{{ route('customer.dashboard') }}"><i class="fas fa-th-large me-2 opacity-75"></i>Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="{{ route('customer.projects.index') }}"><i class="fas fa-folder me-2 opacity-75"></i>Projects</a>
                </li>
                <li class="nav-item">
                    <span class="nav-link px-3 text-muted small">{{ auth()->user()->name }}</span>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link px-3 text-muted"><i class="fas fa-sign-out-alt me-2 opacity-75"></i>Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
