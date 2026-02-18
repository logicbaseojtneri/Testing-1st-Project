@extends('admin.layouts.app')

@section('title', $task->title)

@section('content')
<div class="container-fluid py-4 px-4">

    <!-- Back Link -->
    <div class="mb-4">
        <a href="{{ route('admin.tasks.index') }}" class="text-decoration-none text-muted" style="font-size: 0.85rem;">
            <i class="fas fa-arrow-left me-1"></i>Back to Tasks
        </a>
    </div>

    <div class="row g-4">
        <!-- Task Details -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="fw-700 mb-0" style="color: #001f3f;">{{ $task->title }}</h5>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge
                                @if($task->status === 'to_do') bg-secondary
                                @elseif($task->status === 'in_progress') bg-primary
                                @elseif($task->status === 'review') bg-warning text-dark
                                @elseif($task->status === 'done') bg-success
                                @endif
                            " style="font-size: 0.8rem;">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
                            <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-sm btn-outline-warning rounded-3" title="Edit Task">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this task? It can be recovered from Trash.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Delete Task">
                                    <i class="fas fa-trash me-1"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pt-3">
                    <p class="text-muted mb-4">{{ $task->description ?: 'No description provided' }}</p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Project</small>
                            <p class="mb-0 fw-600">{{ $task->project->name ?? '—' }}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Category</small>
                            <p class="mb-0 fw-600">{{ $task->category ? $task->category->value : '—' }}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Created By</small>
                            <p class="mb-0 fw-600">{{ $task->creator->name ?? '—' }}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Assigned To</small>
                            <p class="mb-0 fw-600">{{ $task->assignee->name ?? 'Unassigned' }}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Due Date</small>
                            <p class="mb-0 fw-600">{{ $task->due_date ? $task->due_date->format('M d, Y') : '—' }}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Created</small>
                            <p class="mb-0 fw-600">{{ $task->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Task History -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-700 mb-0" style="color: #001f3f;"><i class="fas fa-history me-2"></i>History</h6>
                </div>
                <div class="card-body px-4">
                    @forelse($task->history as $entry)
                    <div class="d-flex gap-2 mb-3 pb-3" style="border-bottom: 1px solid #e9ecef;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px; background: rgba(0, 31, 63, 0.08); color: #001f3f;">
                            <i class="fas fa-circle" style="font-size: 0.35rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0" style="font-size: 0.85rem; font-weight: 600; color: #1a1a1a;">{{ $entry->action ?? $entry->description ?? 'Update' }}</p>
                            <small class="text-muted" style="font-size: 0.75rem;">{{ $entry->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center py-3 mb-0">No history available</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
