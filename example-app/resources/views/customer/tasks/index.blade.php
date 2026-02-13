@extends('customer.layouts.app')

@section('title', $project->name . ' – Tasks')

@section('content')
<div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h4 mb-1 fw-600">{{ $project->name }} <span class="text-muted fw-normal">– Tasks</span></h1>
            <p class="text-muted mb-0 small">{{ $project->description ?? 'No description' }}</p>
        </div>
        <a href="{{ route('customer.projects.tasks.create', $project) }}" class="btn btn-primary rounded-3 px-4">
            <i class="fas fa-plus me-2"></i>New Task
        </a>
    </div>

    <div class="card card-customer border-0 overflow-hidden">
        @if ($tasks->isEmpty())
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-tasks fa-2x mb-3 opacity-50"></i>
                <p class="mb-0">No tasks in this project yet. <a href="{{ route('customer.projects.tasks.create', $project) }}" class="link-accent">Create one now</a>.</p>
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
@endsection
