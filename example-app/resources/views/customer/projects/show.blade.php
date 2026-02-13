@extends('customer.layouts.app')

@section('title', $project->name)

@section('content')
<div class="container">
    <div class="card card-customer border-0 mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
                <div>
                    <h1 class="h4 fw-600 text-accent mb-1">{{ $project->name }}</h1>
                    <p class="text-muted mb-0">{{ $project->description ?? 'No description' }}</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('customer.projects.edit', $project) }}" class="btn btn-outline-primary rounded-3 px-3" title="Edit project"><i class="fas fa-pen me-1"></i>Edit</a>
                    <button type="button" class="btn btn-outline-danger rounded-3 px-3" title="Delete project" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fas fa-trash-alt me-1"></i>Delete</button>
                    <a href="{{ route('customer.projects.tasks.index', $project) }}" class="btn btn-outline-primary rounded-3">View Tasks</a>
                    <a href="{{ route('customer.projects.tasks.create', $project) }}" class="btn btn-primary rounded-3">Create Task</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-customer border-0 overflow-hidden">
        <div class="card-body p-4 border-bottom bg-light">
            <h5 class="mb-0 fw-600 text-accent"><i class="fas fa-tasks me-2"></i>Recent Tasks</h5>
        </div>
        <div class="card-body p-0">
            @if ($tasks->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-clipboard-list fa-2x mb-2 opacity-50"></i>
                    <p class="mb-0">No tasks yet. <a href="{{ route('customer.projects.tasks.create', $project) }}" class="link-accent">Create the first task</a>.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-customer table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Assigned To</th>
                                <th>Created</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class="ps-4 fw-500">{{ $task->title }}</td>
                                    <td><span class="badge badge-customer">{{ $task->category->label() }}</span></td>
                                    <td><span class="badge bg-light text-dark border">{{ $task->status }}</span></td>
                                    <td class="text-muted">
                                        {{ $task->category->label() }}
                                        @if ($task->assignee)
                                            – {{ $task->assignee->name }}
                                        @endif
                                    </td>
                                    <td class="text-muted small">{{ $task->created_at->format('M d, Y') }}</td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('customer.tasks.show', $task) }}" class="btn btn-sm btn-primary rounded-3">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-600 text-danger">Delete project?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-muted">
                This will permanently delete <strong class="text-dark">{{ $project->name }}</strong> and all its tasks.
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('customer.projects.destroy', $project) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded-3">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
