<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
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
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="card-title">{{ $task->title }}</h2>
                        <p class="text-muted">Project: <strong>{{ $task->project->name }}</strong></p>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Category:</strong>
                                <span class="badge bg-info">{{ $task->category->label() }}</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Status:</strong>
                                <span class="badge bg-warning">{{ $task->status }}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Assigned to:</strong>
                                @if ($task->assignee)
                                    {{ $task->assignee->name }}
                                @else
                                    <span class="text-muted">Not yet assigned</span>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <h4>Description</h4>
                        <p>{{ $task->description ?? 'No description provided' }}</p>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <strong>Created:</strong>
                                {{ $task->created_at->format('M d, Y H:i') }}
                            </div>
                            <div class="col-md-6">
                                <strong>Last Updated:</strong>
                                {{ $task->updated_at->format('M d, Y H:i') }}
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('customer.projects.tasks.index', $task->project) }}" class="btn btn-secondary">Back to Project Tasks</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
