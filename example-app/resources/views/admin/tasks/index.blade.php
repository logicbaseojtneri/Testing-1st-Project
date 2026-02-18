@extends('admin.layouts.app')

@section('title', 'Manage Tasks')

@section('content')
<div class="container-fluid py-4 px-4">

    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-700 mb-1" style="color: #001f3f;">All Tasks</h4>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">{{ $tasks->total() }} total tasks in the system</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-sm rounded-3">
            <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
        </a>
    </div>

    <!-- Tasks Table Card -->
    <div class="card border-0 overflow-hidden" style="box-shadow: 0 2px 8px rgba(0, 31, 63, 0.08);">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Title</th>
                        <th>Project</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Assigned To</th>
                        <th>Due Date</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                    <tr>
                        <td class="ps-4 text-muted">{{ $task->id }}</td>
                        <td>
                            <a href="{{ route('admin.tasks.show', $task) }}" class="text-decoration-none">
                                <p class="mb-0 fw-600" style="color: #1a1a1a;">{{ Str::limit($task->title, 40) }}</p>
                            </a>
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
                            ">
                                <i class="fas fa-circle me-1" style="font-size: 0.4rem; vertical-align: middle;"></i>
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $task->creator->name ?? '—' }}</td>
                        <td class="text-muted">{{ $task->assignee->name ?? 'Unassigned' }}</td>
                        <td class="text-muted small">{{ $task->due_date ? $task->due_date->format('M d, Y') : '—' }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.tasks.show', $task) }}" class="btn btn-sm btn-outline-primary rounded-3 me-1" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-sm btn-outline-warning rounded-3 me-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this task? It can be recovered from Trash.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="rounded-circle bg-light d-inline-flex p-4 mb-3">
                                <i class="fas fa-clipboard fa-2x text-muted"></i>
                            </div>
                            <p class="text-muted mb-0">No tasks found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($tasks->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $tasks->links() }}
    </div>
    @endif
</div>
@endsection
