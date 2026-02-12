<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <card class="card shadow">
                    <div class="card-body">
                        <h2 class="card-title mb-2">Create New Task</h2>
                        <p class="text-muted mb-4">Project: <strong>{{ $project->name }}</strong></p>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Please fix the following errors:</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('customer.projects.tasks.store', $project) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Task Title *</label>
                                <input 
                                    type="text" 
                                    class="form-control @error('title') is-invalid @enderror" 
                                    id="title" 
                                    name="title"
                                    value="{{ old('title') }}"
                                    required>
                                @error('title')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea 
                                    class="form-control @error('description') is-invalid @enderror" 
                                    id="description" 
                                    name="description"
                                    rows="5">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Task Category *</label>
                                <select 
                                    class="form-control @error('category') is-invalid @enderror" 
                                    id="category" 
                                    name="category"
                                    required>
                                    <option value="">-- Select Category --</option>
                                    <option value="frontend" {{ old('category') == 'frontend' ? 'selected' : '' }}>Frontend</option>
                                    <option value="backend" {{ old('category') == 'backend' ? 'selected' : '' }}>Backend</option>
                                    <option value="server" {{ old('category') == 'server' ? 'selected' : '' }}>Server</option>
                                </select>
                                @error('category')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Create Task</button>
                                <a href="{{ route('customer.projects.tasks.index', $project) }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </card>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
