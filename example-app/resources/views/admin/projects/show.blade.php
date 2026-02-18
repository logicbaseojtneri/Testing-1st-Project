@extends('admin.layouts.app')

@section('title', $project->name)

@section('content')
<div class="container-fluid py-4 px-4">

    <!-- Back Link -->
    <div class="mb-4">
        <a href="{{ route('admin.projects.index') }}" class="text-decoration-none text-muted" style="font-size: 0.85rem;">
            <i class="fas fa-arrow-left me-1"></i>Back to Projects
        </a>
    </div>

    <!-- Project Header -->
    <div class="card mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <h4 class="fw-700 mb-1" style="color: #001f3f;">{{ $project->name }}</h4>
                    <p class="text-muted mb-0">{{ $project->description ?: 'No description provided' }}</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge rounded-pill" style="background: #001f3f; font-size: 0.8rem; padding: 0.5rem 1rem;">
                        {{ $project->tasks->count() }} Tasks
                    </span>
                    <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-outline-warning rounded-3" title="Edit Project">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Delete this project? It can be recovered from Trash.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Delete Project">
                            <i class="fas fa-trash me-1"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Team & Details -->
    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="fw-700 mb-0" style="color: #001f3f;"><i class="fas fa-users me-2"></i>Team</h6>
                        <form action="{{ route('admin.projects.auto-assign', $project) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Auto-assign all roles to the least-loaded developers?');">
                            @csrf
                            <button type="submit" class="btn btn-sm text-white rounded-3" style="background: #001f3f; font-size: 0.75rem;">
                                <i class="fas fa-magic me-1"></i>Auto-Assign All
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body px-4">

                    <!-- Frontend Developer -->
                    <div class="mb-3 pb-3" style="border-bottom: 1px solid #e9ecef;">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                <span class="d-inline-block rounded-circle me-1" style="width: 6px; height: 6px; background: #0d6efd;"></span>
                                Frontend Developer
                            </small>
                            <form action="{{ route('admin.projects.assign-role', $project) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="role_slot" value="frontend_dev_id">
                                <input type="hidden" name="auto" value="1">
                                <button type="submit" class="btn btn-link btn-sm text-primary p-0" style="font-size: 0.7rem;" title="Auto-assign">
                                    <i class="fas fa-magic"></i>
                                </button>
                            </form>
                        </div>
                        <form action="{{ route('admin.projects.assign-role', $project) }}" method="POST">
                            @csrf
                            <input type="hidden" name="role_slot" value="frontend_dev_id">
                            <div class="input-group input-group-sm">
                                <select class="form-select form-select-sm" name="user_id" style="font-size: 0.8rem;">
                                    <option value="">— Not Assigned —</option>
                                    @foreach($frontendDevs as $dev)
                                        <option value="{{ $dev->id }}" {{ $project->frontend_dev_id == $dev->id ? 'selected' : '' }}>
                                            {{ $dev->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-sm btn-outline-primary" title="Assign">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Backend Developer -->
                    <div class="mb-3 pb-3" style="border-bottom: 1px solid #e9ecef;">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                <span class="d-inline-block rounded-circle me-1" style="width: 6px; height: 6px; background: #198754;"></span>
                                Backend Developer
                            </small>
                            <form action="{{ route('admin.projects.assign-role', $project) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="role_slot" value="backend_dev_id">
                                <input type="hidden" name="auto" value="1">
                                <button type="submit" class="btn btn-link btn-sm text-success p-0" style="font-size: 0.7rem;" title="Auto-assign">
                                    <i class="fas fa-magic"></i>
                                </button>
                            </form>
                        </div>
                        <form action="{{ route('admin.projects.assign-role', $project) }}" method="POST">
                            @csrf
                            <input type="hidden" name="role_slot" value="backend_dev_id">
                            <div class="input-group input-group-sm">
                                <select class="form-select form-select-sm" name="user_id" style="font-size: 0.8rem;">
                                    <option value="">— Not Assigned —</option>
                                    @foreach($backendDevs as $dev)
                                        <option value="{{ $dev->id }}" {{ $project->backend_dev_id == $dev->id ? 'selected' : '' }}>
                                            {{ $dev->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-sm btn-outline-success" title="Assign">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Server Administrator -->
                    <div class="mb-3 pb-3" style="border-bottom: 1px solid #e9ecef;">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                <span class="d-inline-block rounded-circle me-1" style="width: 6px; height: 6px; background: #dc3545;"></span>
                                Server Administrator
                            </small>
                            <form action="{{ route('admin.projects.assign-role', $project) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="role_slot" value="server_admin_id">
                                <input type="hidden" name="auto" value="1">
                                <button type="submit" class="btn btn-link btn-sm text-danger p-0" style="font-size: 0.7rem;" title="Auto-assign">
                                    <i class="fas fa-magic"></i>
                                </button>
                            </form>
                        </div>
                        <form action="{{ route('admin.projects.assign-role', $project) }}" method="POST">
                            @csrf
                            <input type="hidden" name="role_slot" value="server_admin_id">
                            <div class="input-group input-group-sm">
                                <select class="form-select form-select-sm" name="user_id" style="font-size: 0.8rem;">
                                    <option value="">— Not Assigned —</option>
                                    @foreach($serverAdmins as $dev)
                                        <option value="{{ $dev->id }}" {{ $project->server_admin_id == $dev->id ? 'selected' : '' }}>
                                            {{ $dev->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Assign">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div>
                        <small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Created</small>
                        <p class="mb-0 fw-600">{{ $project->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-700 mb-0" style="color: #001f3f;"><i class="fas fa-clipboard-list me-2"></i>Tasks</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Title</th>
                                    <th>Status</th>
                                    <th>Assigned To</th>
                                    <th>Due Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($project->tasks as $task)
                                <tr>
                                    <td class="ps-4 fw-600">{{ $task->title }}</td>
                                    <td>
                                        <span class="badge
                                            @if($task->status === 'to_do') bg-secondary
                                            @elseif($task->status === 'in_progress') bg-primary
                                            @elseif($task->status === 'review') bg-warning text-dark
                                            @elseif($task->status === 'done') bg-success
                                            @endif
                                        ">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
                                    </td>
                                    <td class="text-muted">{{ $task->assignee->name ?? 'Unassigned' }}</td>
                                    <td class="text-muted small">{{ $task->due_date ? $task->due_date->format('M d, Y') : '—' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No tasks for this project</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
