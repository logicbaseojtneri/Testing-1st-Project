<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tasks - ManageX</title>
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
        body { background-color: var(--white); }
        .navbar { background-color: var(--white); border-bottom: 1px solid var(--border); box-shadow: 0 2px 8px rgba(0, 31, 63, 0.06); }
        .navbar-brand { font-weight: 700; color: var(--primary); font-size: 1.4rem; }
        .nav-link { color: var(--text-dark) !important; font-weight: 500; }
        .nav-link:hover { color: var(--primary) !important; }
        .container { max-width: 1200px; padding: 2rem 1rem; }
        h1 { color: var(--primary); font-weight: 700; margin-bottom: 1rem; }
        .table-responsive { border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0, 31, 63, 0.06); }
        .table { background-color: var(--white); margin-bottom: 0; }
        .table thead th { background-color: var(--light-bg); border: none; font-weight: 600; color: var(--text-dark); padding: 1.25rem 1rem; font-size: 0.9rem; }
        .table tbody td { border: none; padding: 1rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
        .table tbody tr:hover { background-color: rgba(0, 31, 63, 0.02); }
        .status-select { border: 1px solid var(--border); border-radius: 6px; padding: 0.4rem 0.6rem; font-size: 0.9rem; font-weight: 500; cursor: pointer; transition: all 0.3s ease; max-width: 140px; }
        .status-select:hover { border-color: var(--primary); }
        .status-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(0, 31, 63, 0.1); outline: none; }
        .btn-info { background-color: var(--primary); border-color: var(--primary); }
        .btn-info:hover { background-color: var(--primary-dark); border-color: var(--primary-dark); }
        .badge { padding: 0.5rem 0.75rem; font-weight: 500; border-radius: 6px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('developer.dashboard') }}">
                <i class="fas fa-tasks me-2"></i>ManageX
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
                        <a class="nav-link active" href="{{ route('developer.tasks.index') }}">My Tasks</a>
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
        <h1>
            <i class="fas fa-tasks me-2"></i>My Assigned Tasks
        </h1>
        <p class="text-muted">Role: {{ auth()->user()->role->label() }}</p>

        @if ($tasks->isEmpty())
            <div class="alert" style="background-color: #f0f9ff; border-left: 4px solid #3b82f6; color: #0c2340;">
                <i class="fas fa-info-circle me-2"></i>
                You don't have any assigned tasks yet. Check back soon!
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Project</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td><strong>{{ $task->title }}</strong></td>
                                <td>{{ Str::limit($task->description, 50) }}</td>
                                <td><span class="badge" style="background-color: rgba(0, 31, 63, 0.1); color: var(--primary);">{{ $task->category->label() }}</span></td>
                                <td>
                                    <form action="{{ route('developer.tasks.updateStatus', $task) }}" method="POST" class="d-inline" onchange="this.submit()">
                                        @csrf
                                        @method('PUT')
                                        <select class="status-select" name="status">
                                            <option value="to_do" {{ $task->status === 'to_do' ? 'selected' : '' }}>To Do</option>
                                            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Done</option>
                                            <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        </select>
                                    </form>
                                </td>
                                <td>{{ $task->project->name }}</td>
                                <td class="text-muted small">{{ $task->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('developer.tasks.show', $task) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye me-1"></i>View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
