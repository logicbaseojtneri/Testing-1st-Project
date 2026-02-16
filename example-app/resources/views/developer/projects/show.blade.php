@extends('developer.layouts.app')

@section('title', $project->name)

@section('content')
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

    .project-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: var(--white);
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 12px;
    }

    .project-header-content {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .project-header-icon {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        background-color: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }

    .project-header-info h1 {
        color: var(--white);
        font-weight: 700;
        font-size: 2rem;
        margin: 0 0 0.5rem 0;
    }

    .project-header-meta {
        display: flex;
        gap: 2rem;
        margin-top: 1rem;
        font-size: 0.95rem;
    }

    .header-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .back-button {
        display: inline-block;
        margin-bottom: 1.5rem;
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .back-button:hover {
        color: var(--primary-dark);
        transform: translateX(-4px);
    }

    .tasks-section {
        margin-top: 2rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border);
    }

    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 31, 63, 0.06);
    }

    .table {
        background-color: var(--white);
        margin-bottom: 0;
    }

    .table thead th {
        background-color: var(--light-bg);
        border: none;
        font-weight: 600;
        color: var(--text-dark);
        padding: 1.25rem 1rem;
        font-size: 0.9rem;
    }

    .table tbody td {
        border: none;
        padding: 1rem;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: rgba(0, 31, 63, 0.02);
    }

    .task-title {
        font-weight: 600;
        color: var(--text-dark);
    }

    .status-badge {
        display: inline-block;
        padding: 0.4rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .status-to-do {
        background-color: rgba(158, 158, 158, 0.15);
        color: #4a4a4a;
    }

    .status-in-progress {
        background-color: rgba(255, 152, 0, 0.2);
        color: #e68900;
    }

    .status-done {
        background-color: rgba(76, 175, 80, 0.2);
        color: #388e3c;
    }

    .status-pending {
        background-color: rgba(244, 67, 54, 0.2);
        color: #d32f2f;
    }

    .category-badge {
        display: inline-block;
        background-color: rgba(0, 31, 63, 0.1);
        color: var(--primary);
        padding: 0.25rem 0.6rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        font-weight: 500;
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--text-muted);
    }

    .empty-state-icon {
        font-size: 2rem;
        opacity: 0.2;
        margin-bottom: 1rem;
    }

    .description-box {
        background-color: var(--light-bg);
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        border-left: 4px solid var(--primary);
    }

    .description-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .description-text {
        color: var(--text-muted);
        margin: 0;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .status-dropdown {
        padding: 0.5rem 0.75rem;
        border: 1px solid var(--border);
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        background-color: var(--white);
        color: var(--text-dark);
        transition: all 0.3s ease;
    }

    .status-dropdown:hover {
        border-color: var(--border);
        background-color: var(--white);
        color: var(--text-dark);
    }

    .status-dropdown:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 31, 63, 0.1);
    }
</style>

<div class="container-fluid py-4">
    <a href="{{ route('developer.projects.index') }}" class="back-button">
        <i class="fas fa-arrow-left me-2"></i>Back to Projects
    </a>

    <div class="project-header">
        <div class="project-header-content">
            <div class="project-header-icon">
                <i class="fas fa-folder"></i>
            </div>
            <div class="project-header-info">
                <h1>{{ $project->name }}</h1>
                <div class="project-header-meta">
                    <div class="header-meta-item">
                        <i class="fas fa-tasks"></i>
                        <span>{{ $tasks->count() }} tasks assigned to you</span>
                    </div>
                    <div class="header-meta-item">
                        <i class="fas fa-calendar"></i>
                        <span>Created {{ $project->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($project->description)
        <div class="description-box">
            <p class="description-label">Project Description</p>
            <p class="description-text">{{ $project->description }}</p>
        </div>
    @endif

    <div class="tasks-section">
        <h2 class="section-title">
            <i class="fas fa-tasks me-2"></i>Your Tasks
        </h2>

        @if ($tasks->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <p>No tasks assigned to you in this project</p>
                    </div>
                </div>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td><strong class="task-title">{{ $task->title }}</strong></td>
                                <td><span class="text-muted small">{{ Str::limit($task->description, 50) }}</span></td>
                                <td>
                                    <span class="category-badge">{{ $task->category?->value ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ str_replace('_', '-', $task->status) }}">
                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                    </span>
                                </td>
                                <td><span class="text-muted small">{{ $task->created_at->format('M d, Y') }}</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <form action="{{ route('developer.tasks.updateStatus', $task) }}" method="POST" class="d-inline" onchange="this.submit()">
                                            @csrf
                                            @method('PUT')
                                            <select class="status-dropdown" name="status" title="Update task status">
                                                <option value="to_do" {{ $task->status === 'to_do' ? 'selected' : '' }}>To Do</option>
                                                <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Done</option>
                                                <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            </select>
                                        </form>
                                        <a href="{{ route('developer.tasks.show', $task) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                    </div>
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
