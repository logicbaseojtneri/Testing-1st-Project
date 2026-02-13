<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $task->title }} - ManageX</title>
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
        .nav-link.active { color: var(--primary) !important; }
        .container { max-width: 900px; padding: 2rem 1rem; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0, 31, 63, 0.08); background-color: var(--white); margin-bottom: 1.5rem; }
        .card-header { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border: none; border-radius: 12px 12px 0 0; color: var(--white); padding: 1.5rem; }
        .card-header h2 { margin: 0; font-weight: 700; font-size: 1.8rem; }
        .card-body { padding: 2rem; }
        h4 { color: var(--primary); font-weight: 600; margin-top: 1.5rem; margin-bottom: 1rem; }
        .badge { padding: 0.5rem 0.75rem; font-weight: 500; border-radius: 6px; }
        .info-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem; }
        .info-item { padding: 1rem; background-color: var(--light-bg); border-radius: 8px; }
        .info-item label { font-weight: 600; color: var(--text-dark); }
        .info-item p { margin: 0.5rem 0 0 0; color: var(--text-muted); }
        .form-control, .form-select { border: 1px solid var(--border); border-radius: 6px; padding: 0.75rem; font-size: 0.95rem; }
        .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(0, 31, 63, 0.1); outline: none; }
        .btn { border-radius: 6px; font-weight: 500; padding: 0.6rem 1.2rem; transition: all 0.3s ease; }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background-color: var(--primary-dark); border-color: var(--primary-dark); }
        .btn-outline-secondary { color: var(--primary); border-color: var(--border); }
        .btn-outline-secondary:hover { background-color: rgba(0, 31, 63, 0.05); border-color: var(--primary); }
        .btn-outline-warning { color: #ff8c00; border-color: #ff8c00; }
        .btn-outline-warning:hover { background-color: #ff8c00; color: var(--white); }
        .alert { border: none; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem; font-weight: 500; }
        .alert-success { background-color: #d1f2eb; color: #0f6b51; }
        .alert-danger { background-color: #ffe0e0; color: #7d2a2a; }
        .alert-danger ul { margin-bottom: 0; }
        .table { border-collapse: collapse; width: 100%; }
        .table thead th { background-color: var(--light-bg); border: none; font-weight: 600; color: var(--text-dark); padding: 1rem; font-size: 0.9rem; }
        .table tbody td { border: 1px solid var(--border); padding: 1rem; }
        .table tbody tr:hover { background-color: rgba(0, 31, 63, 0.02); }
        .divider { border: none; height: 1px; background-color: var(--border); margin: 1.5rem 0; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
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
                        <a href="{{ route('developer.dashboard') }}" class="nav-link">
                            <i class="fas fa-chart-line me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('developer.tasks.index') }}" class="nav-link">
                            <i class="fas fa-list me-1"></i>My Tasks
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>{{ auth()->user()->name }}
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
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-check-circle me-2"></i>{{ $task->title }}</h2>
            </div>
            <div class="card-body">
                <div class="info-row">
                    <div class="info-item">
                        <label><i class="fas fa-folder me-2"></i>Project</label>
                        <p><strong>{{ $task->project->name }}</strong></p>
                    </div>
                    <div class="info-item">
                        <label><i class="fas fa-tag me-2"></i>Category</label>
                        <p><span class="badge" style="background-color: rgba(0, 31, 63, 0.1); color: var(--primary);">{{ $task->category->label() }}</span></p>
                    </div>
                    <div class="info-item">
                        <label><i class="fas fa-circle-notch me-2"></i>Current Status</label>
                        <p><span class="badge" style="background-color: rgba(0, 31, 63, 0.1); color: var(--primary);">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span></p>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-item">
                        <label><i class="fas fa-user me-2"></i>Created By</label>
                        <p>{{ $task->creator->name }}</p>
                    </div>
                    <div class="info-item">
                        <label><i class="fas fa-calendar me-2"></i>Created</label>
                        <p>{{ $task->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div class="info-item">
                        <label><i class="fas fa-sync me-2"></i>Last Updated</label>
                        <p>{{ $task->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>

                <hr class="divider">

                <h4><i class="fas fa-align-left me-2"></i>Description</h4>
                <p style="line-height: 1.6; color: var(--text-dark);">{{ $task->description ?? 'No description provided' }}</p>

                <hr class="divider">

                <h4><i class="fas fa-exchange-alt me-2"></i>Update Status</h4>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('developer.tasks.updateStatus', $task) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PUT')
                    <div class="row g-2 align-items-end">
                        <div class="col-md-8">
                            <label for="status" class="form-label"><strong>Select New Status</strong></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">Choose a status...</option>
                                <option value="to_do" {{ $task->status === 'to_do' ? 'selected' : '' }}>To Do</option>
                                <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Done</option>
                                <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-1"></i>Update Status
                            </button>
                        </div>
                    </div>
                </form>

                @if ($task->history()->where('field_name', 'status')->exists())
                    <form action="{{ route('developer.tasks.undo', $task) }}" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-undo me-1"></i>Undo Last Change
                        </button>
                    </form>
                @endif

                @if ($task->history->count() > 0)
                    <hr class="divider">
                    <h4><i class="fas fa-history me-2"></i>Change History</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Changed By</th>
                                    <th>Old Value</th>
                                    <th>New Value</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($task->history as $record)
                                    <tr>
                                        <td><strong>{{ ucfirst(str_replace('_', ' ', $record->field_name)) }}</strong></td>
                                        <td>{{ $record->changedBy->name ?? 'System' }}</td>
                                        <td style="color: var(--text-muted);">{{ $record->old_value ?? '—' }}</td>
                                        <td style="color: var(--text-muted);">{{ $record->new_value ?? '—' }}</td>
                                        <td style="color: var(--text-muted); font-size: 0.9rem;">{{ $record->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="mt-4 pt-2">
                    <a href="{{ route('developer.tasks.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to Tasks
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
