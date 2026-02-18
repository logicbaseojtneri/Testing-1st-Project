@extends('admin.layouts.app')

@section('title', 'Trash - Recover Items')

@section('content')
<div class="container-fluid py-4 px-4">

    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-700 mb-1" style="color: #001f3f;">
                <i class="fas fa-trash-restore me-2"></i>Trash
            </h4>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">Recover or permanently delete items</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-sm rounded-3">
            <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
        </a>
    </div>

    <!-- Deleted Projects -->
    <div class="card border-0 mb-4" style="box-shadow: 0 2px 8px rgba(0, 31, 63, 0.08);">
        <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="fw-700 mb-0" style="color: #001f3f;">
                    <i class="fas fa-folder-open me-2 text-warning"></i>Deleted Projects
                    <span class="badge rounded-pill bg-warning text-dark ms-2" style="font-size: 0.7rem;">{{ $projects->total() }}</span>
                </h5>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Project Name</th>
                            <th>Tasks</th>
                            <th>Deleted On</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                        <tr>
                            <td class="ps-4 text-muted">{{ $project->id }}</td>
                            <td>
                                <p class="mb-0 fw-600" style="color: #1a1a1a;">{{ $project->name }}</p>
                                <small class="text-muted">{{ Str::limit($project->description, 50) }}</small>
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-secondary">{{ $project->tasks_count }}</span>
                            </td>
                            <td class="text-muted small">{{ $project->deleted_at->format('M d, Y H:i') }}</td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.projects.restore', $project->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success rounded-3" title="Restore Project">
                                        <i class="fas fa-undo me-1"></i>Restore
                                    </button>
                                </form>
                                <form action="{{ route('admin.projects.force-delete', $project->id) }}" method="POST" class="d-inline ms-1"
                                      onsubmit="return confirm('Permanently delete this project? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Permanently Delete">
                                        <i class="fas fa-times me-1"></i>Delete Forever
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="rounded-circle bg-light d-inline-flex p-3 mb-3">
                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                </div>
                                <p class="text-muted mb-0">No deleted projects</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($projects->hasPages())
        <div class="card-footer bg-white border-0 d-flex justify-content-center py-3">
            {{ $projects->appends(['tasks_page' => request('tasks_page')])->links() }}
        </div>
        @endif
    </div>

    <!-- Deleted Tasks -->
    <div class="card border-0" style="box-shadow: 0 2px 8px rgba(0, 31, 63, 0.08);">
        <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="fw-700 mb-0" style="color: #001f3f;">
                    <i class="fas fa-clipboard-list me-2 text-warning"></i>Deleted Tasks
                    <span class="badge rounded-pill bg-warning text-dark ms-2" style="font-size: 0.7rem;">{{ $tasks->total() }}</span>
                </h5>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Title</th>
                            <th>Project</th>
                            <th>Status</th>
                            <th>Deleted On</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                        <tr>
                            <td class="ps-4 text-muted">{{ $task->id }}</td>
                            <td>
                                <p class="mb-0 fw-600" style="color: #1a1a1a;">{{ Str::limit($task->title, 40) }}</p>
                                @if($task->category)
                                    <span class="badge bg-light text-primary" style="font-size: 0.7rem;">{{ $task->category->value }}</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $task->project->name ?? '—' }}</td>
                            <td>
                                <span class="badge
                                    @if($task->status === 'to_do') bg-secondary
                                    @elseif($task->status === 'in_progress') bg-primary
                                    @elseif($task->status === 'review') bg-warning text-dark
                                    @elseif($task->status === 'done') bg-success
                                    @endif
                                ">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
                            </td>
                            <td class="text-muted small">{{ $task->deleted_at->format('M d, Y H:i') }}</td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.tasks.restore', $task->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success rounded-3" title="Restore Task">
                                        <i class="fas fa-undo me-1"></i>Restore
                                    </button>
                                </form>
                                <form action="{{ route('admin.tasks.force-delete', $task->id) }}" method="POST" class="d-inline ms-1"
                                      onsubmit="return confirm('Permanently delete this task? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Permanently Delete">
                                        <i class="fas fa-times me-1"></i>Delete Forever
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="rounded-circle bg-light d-inline-flex p-3 mb-3">
                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                </div>
                                <p class="text-muted mb-0">No deleted tasks</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($tasks->hasPages())
        <div class="card-footer bg-white border-0 d-flex justify-content-center py-3">
            {{ $tasks->appends(['page' => request('page')])->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
