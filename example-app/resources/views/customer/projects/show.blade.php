<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $project->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Task Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ route('customer.dashboard') }}" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('customer.projects.index') }}" class="nav-link">My Projects</a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">{{ auth()->user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex align-items-start justify-content-between gap-3 mb-4">
            <div>
                <h1 class="mb-1">{{ $project->name }}</h1>
                <p class="text-muted mb-0">{{ $project->description ?? 'No description' }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('customer.projects.tasks.index', $project) }}" class="btn btn-outline-primary">View Tasks</a>
                <a href="{{ route('customer.projects.tasks.create', $project) }}" class="btn btn-primary">Create Task</a>
            </div>
        </div>

        <h3 class="mb-3">Recent Tasks</h3>

        @if ($tasks->isEmpty())
            <div class="alert alert-info">
                No tasks in this project yet.
                <a href="{{ route('customer.projects.tasks.create', $project) }}">Create the first task</a>.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td><span class="badge bg-info">{{ $task->category->label() }}</span></td>
                                <td><span class="badge bg-warning">{{ $task->status }}</span></td>
                                <td>
                                    @if ($task->assignee)
                                        {{ $task->assignee->name }}
                                    @else
                                        <span class="text-muted">Unassigned</span>
                                    @endif
                                </td>
                                <td>{{ $task->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('customer.tasks.show', $task) }}" class="btn btn-sm btn-info">View</a>
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

