@extends('customer.layouts.app')

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
    .card-modern { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0, 31, 63, 0.08); background-color: var(--white); }
    .card-header-gradient { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border: none; border-radius: 12px 12px 0 0; color: var(--white); padding: 2rem; }
    .card-header-gradient h1 { margin: 0; font-weight: 700; font-size: 1.8rem; color: var(--white); }
    .btn { border-radius: 6px; font-weight: 500; padding: 0.6rem 1.2rem; transition: all 0.3s ease; }
    .btn-primary { background-color: var(--primary); border-color: var(--primary); }
    .btn-primary:hover { background-color: var(--primary-dark); border-color: var(--primary-dark); }
    .btn-outline-secondary { color: var(--primary); border-color: var(--border); }
    .btn-outline-secondary:hover { background-color: rgba(0, 31, 63, 0.05); border-color: var(--primary); }
    .btn-danger { background-color: #dc3545; border-color: #dc3545; }
    .btn-danger:hover { background-color: #c82333; }
    .badge-modern { padding: 0.5rem 0.75rem; font-weight: 500; border-radius: 6px; background-color: rgba(0, 31, 63, 0.1); color: var(--primary); }
    .table { background-color: var(--white); }
    .table thead th { background-color: var(--light-bg); border: none; font-weight: 600; color: var(--text-dark); padding: 1rem; font-size: 0.9rem; }
    .table tbody td { border: 1px solid var(--border); padding: 1rem; }
    .table tbody tr:hover { background-color: rgba(0, 31, 63, 0.02); }
    .modal-content { border: none; border-radius: 12px; }
    .modal-header { border-bottom: 1px solid var(--border); }
    .modal-footer { border-top: 1px solid var(--border); }
</style>

<div class="container py-4">
    <div class="card-modern mb-4">
        <div class="card-header-gradient">
            <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
                <div>
                    <h1><i class="fas fa-folder me-2"></i>{{ $project->name }}</h1>
                    <p class="mb-0" style="color: rgba(255, 255, 255, 0.9);">{{ $project->description ?? 'No description' }}</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('customer.projects.tasks.create', $project) }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Create Task
                    </a>
                    <a href="{{ route('customer.projects.edit', $project) }}" class="btn btn-outline-secondary" title="Edit project" style="background-color: rgba(255, 255, 255, 0.1); border-color: rgba(255, 255, 255, 0.3); color: var(--white);">
                        <i class="fas fa-pen me-1"></i>Edit
                    </a>
                    <button type="button" class="btn" title="Delete project" data-bs-toggle="modal" data-bs-target="#deleteModal" style="background-color: rgba(220, 53, 69, 0.8); border-color: transparent; color: var(--white);">
                        <i class="fas fa-trash-alt me-1"></i>Delete
                    </button>
                    <a href="{{ route('customer.dashboard') }}" class="btn" title="Go back to dashboard" style="background-color: rgba(255, 255, 255, 0.1); border-color: rgba(255, 255, 255, 0.3); color: var(--white);">
                        <i class="fas fa-times me-1"></i>Close
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .kanban-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            padding: 1.5rem 0;
        }
        
        .kanban-column {
            background-color: var(--white);
            border-radius: 12px;
            padding: 1.5rem;
            min-height: 600px;
            display: flex;
            flex-direction: column;
            border-top: 6px solid var(--border);
            box-shadow: 0 2px 12px rgba(0, 31, 63, 0.08);
            position: relative;
            overflow: hidden;
        }
        
        .kanban-column::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background-size: 100% 100%;
        }
        
        .kanban-column.todo::before {
            background: linear-gradient(90deg, #9e9e9e 0%, #bdbdbd 100%);
        }
        
        .kanban-column.in-progress::before {
            background: linear-gradient(90deg, #ff9800 0%, #ffb74d 100%);
        }
        
        .kanban-column.done::before {
            background: linear-gradient(90deg, #4caf50 0%, #81c784 100%);
        }
        
        .kanban-column.review::before {
            background: linear-gradient(90deg, #7b1fa2 0%, #ab47bc 100%);
        }
        
        .kanban-column.todo,
        .kanban-column.in-progress,
        .kanban-column.review,
        .kanban-column.done {
            border-top: transparent;
        }
        
        .kanban-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }
        
        .kanban-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: #1a1a1a !important;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .status-badge {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
        
        .status-todo { background-color: #9e9e9e; }
        .status-in-progress { background-color: #ff9800; }
        .status-review { background-color: #7b1fa2; }
        .status-done { background-color: #4caf50; }
        
        .task-count {
            background-color: var(--text-muted);
            color: var(--white);
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .tasks-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            flex: 1;
        }
        
        .task-card {
            background-color: var(--white);
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 1px 3px rgba(0, 31, 63, 0.06);
            cursor: pointer;
            transition: all 0.3s ease;
            border-left: 4px solid var(--border);
            text-decoration: none !important;
        }
        
        .task-card:hover {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            box-shadow: 0 4px 12px rgba(0, 31, 63, 0.15);
            transform: translateY(-2px);
        }

        .task-card.task-card-overdue {
            border-left: 4px solid #d32f2f;
            background-color: rgba(244, 67, 54, 0.04);
        }

        .task-card.task-card-overdue:hover {
            background: linear-gradient(135deg, #c62828 0%, #b71c1c 100%);
        }

        .deadline-value {
            font-size: 0.8rem;
        }

        .deadline-value.overdue-text {
            color: #d32f2f;
            font-weight: 700;
        }

        .task-card:hover .deadline-value.overdue-text {
            color: #ff8a80;
        }

        .attachment-icons {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.5rem;
            flex-wrap: wrap;
        }

        .attachment-icon {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            background-color: rgba(0, 31, 63, 0.07);
            color: var(--primary);
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.72rem;
            font-weight: 500;
        }

        .task-card:hover .attachment-icon {
            background-color: rgba(255, 255, 255, 0.2);
            color: var(--white);
        }
        
        .task-title {
            font-weight: 700;
            color: var(--primary);
            margin: 0 0 0.75rem 0;
            font-size: 1rem;
            line-height: 1.3;
        }
        
        .task-card:hover .task-title {
            color: var(--white);
        }
        
        .task-info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
        }
        
        .task-info-label {
            font-weight: 600;
            color: var(--text-muted);
            margin-right: 0.5rem;
        }
        
        .task-card:hover .task-info-label {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .task-info-value {
            color: var(--primary);
            flex: 1;
            text-align: right;
        }
        
        .task-card:hover .task-info-value {
            color: var(--white);
        }
        
        .task-category {
            display: inline-block;
            background-color: rgba(0, 31, 63, 0.1);
            color: var(--primary);
            padding: 0.25rem 0.6rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .task-card:hover .task-category {
            background-color: rgba(255, 255, 255, 0.2);
            color: var(--white);
        }
        
        .task-status {
            display: inline-block;
            padding: 0.4rem 0.85rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: capitalize;
        }
        
        .task-status.to-do {
            background-color: rgba(109, 109, 109, 0.15);
            color: #4a4a4a;
        }
        
        .task-status.in-progress {
            background-color: rgba(255, 152, 0, 0.2);
            color: #e68900;
        }
        
        .task-status.done {
            background-color: rgba(76, 175, 80, 0.2);
            color: #388e3c;
        }
        
        .task-status.review {
            background-color: rgba(123, 31, 162, 0.15);
            color: #7b1fa2;
        }
        
        .task-card:hover .task-status.to-do {
            background-color: rgba(158, 158, 158, 0.2);
            color: #4a4a4a;
        }
        
        .task-card:hover .task-status.in-progress {
            background-color: rgba(255, 152, 0, 0.2);
            color: #e68900;
        }
        
        .task-card:hover .task-status.done {
            background-color: rgba(76, 175, 80, 0.2);
            color: #388e3c;
        }
        
        .task-card:hover .task-status.review {
            background-color: rgba(123, 31, 162, 0.2);
            color: #7b1fa2;
        }

        .overdue-badge {
            display: inline-block;
            background-color: rgba(244, 67, 54, 0.15);
            color: #d32f2f;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 700;
            margin-left: 0.5rem;
        }

        .task-card:hover .overdue-badge {
            background-color: rgba(244, 67, 54, 0.3);
            color: #ff8a80;
        }
        
        .empty-state {
            text-align: center;
            padding: 2rem 1rem;
            color: var(--text-muted);
        }
        
        .empty-state-icon {
            font-size: 2rem;
            opacity: 0.3;
            margin-bottom: 1rem;
        }
    </style>

    @if ($tasks->isEmpty())
        <div style="text-align: center; padding: 3rem 1rem; background-color: var(--white); border-radius: 12px; box-shadow: 0 2px 12px rgba(0, 31, 63, 0.08);">
            <i class="fas fa-clipboard-list" style="font-size: 3rem; opacity: 0.3; color: var(--text-muted); display: block; margin-bottom: 1rem;"></i>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">No tasks yet.</p>
            <a href="{{ route('customer.projects.tasks.create', $project) }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Create the first task
            </a>
        </div>
    @else
        <div class="kanban-container">
            <!-- To Do Column -->
            <div class="kanban-column todo">
                <div class="kanban-header">
                    <h3 class="kanban-title">
                        <span class="status-badge status-todo"></span>
                        To do
                    </h3>
                    <span class="task-count">{{ $tasks->where('status', 'to_do')->count() }}</span>
                </div>
                <div class="tasks-list">
                    @forelse ($tasks->where('status', 'to_do') as $task)
                        @php $isOverdue = $task->deadline && \Carbon\Carbon::parse($task->deadline)->isPast() && $task->status !== 'done'; @endphp
                        <a href="{{ route('customer.tasks.show', $task) }}" class="task-card {{ $isOverdue ? 'task-card-overdue' : '' }}">
                            <p class="task-title">
                                {{ $task->title }}
                                @if ($isOverdue)
                                    <span class="overdue-badge"><i class="fas fa-exclamation-triangle me-1"></i>Overdue</span>
                                @endif
                            </p>
                            <div class="task-info-row">
                                <span class="task-info-label">Project:</span>
                                <span class="task-info-value">{{ $task->project->name }}</span>
                            </div>
                            <div class="task-info-row">
                                <span class="task-info-label">Category:</span>
                                <span class="task-info-value"><span class="task-category">{{ $task->category->label() }}</span></span>
                            </div>
                            <div class="task-info-row">
                                <span class="task-info-label">Deadline:</span>
                                <span class="task-info-value"><span class="deadline-value {{ $isOverdue ? 'overdue-text' : '' }}">{{ $task->deadline ? $task->deadline->format('M d, Y') : 'No deadline' }}</span></span>
                            </div>
                            <div class="task-info-row">
                                <span class="task-info-label">Status:</span>
                                <span class="task-info-value"><span class="task-status to-do">{{ str_replace('_', ' ', $task->status) }}</span></span>
                            </div>
                            @if ($task->link || $task->image_path)
                                <div class="attachment-icons">
                                    @if ($task->link)
                                        <span class="attachment-icon"><i class="fas fa-link"></i> Link</span>
                                    @endif
                                    @if ($task->image_path)
                                        <span class="attachment-icon"><i class="fas fa-image"></i> Image</span>
                                    @endif
                                </div>
                            @endif
                        </a>
                    @empty
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="fas fa-inbox"></i></div>
                            <p style="margin: 0;">No tasks</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- In Progress Column -->
            <div class="kanban-column in-progress">
                <div class="kanban-header">
                    <h3 class="kanban-title">
                        <span class="status-badge status-in-progress"></span>
                        In Progress
                    </h3>
                    <span class="task-count">{{ $tasks->where('status', 'in_progress')->count() }}</span>
                </div>
                <div class="tasks-list">
                    @forelse ($tasks->where('status', 'in_progress') as $task)
                        @php $isOverdue = $task->deadline && \Carbon\Carbon::parse($task->deadline)->isPast() && $task->status !== 'done'; @endphp
                        <a href="{{ route('customer.tasks.show', $task) }}" class="task-card {{ $isOverdue ? 'task-card-overdue' : '' }}">
                            <p class="task-title">
                                {{ $task->title }}
                                @if ($isOverdue)
                                    <span class="overdue-badge"><i class="fas fa-exclamation-triangle me-1"></i>Overdue</span>
                                @endif
                            </p>
                            <div class="task-info-row">
                                <span class="task-info-label">Project:</span>
                                <span class="task-info-value">{{ $task->project->name }}</span>
                            </div>
                            <div class="task-info-row">
                                <span class="task-info-label">Category:</span>
                                <span class="task-info-value"><span class="task-category">{{ $task->category->label() }}</span></span>
                            </div>
                            <div class="task-info-row">
                                <span class="task-info-label">Deadline:</span>
                                <span class="task-info-value"><span class="deadline-value {{ $isOverdue ? 'overdue-text' : '' }}">{{ $task->deadline ? $task->deadline->format('M d, Y') : 'No deadline' }}</span></span>
                            </div>
                            <div class="task-info-row">
                                <span class="task-info-label">Status:</span>
                                <span class="task-info-value"><span class="task-status in-progress">{{ str_replace('_', ' ', $task->status) }}</span></span>
                            </div>
                            @if ($task->link || $task->image_path)
                                <div class="attachment-icons">
                                    @if ($task->link)
                                        <span class="attachment-icon"><i class="fas fa-link"></i> Link</span>
                                    @endif
                                    @if ($task->image_path)
                                        <span class="attachment-icon"><i class="fas fa-image"></i> Image</span>
                                    @endif
                                </div>
                            @endif
                        </a>
                    @empty
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="fas fa-inbox"></i></div>
                            <p style="margin: 0;">No tasks</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Review Column -->
            <div class="kanban-column review">
                <div class="kanban-header">
                    <h3 class="kanban-title">
                        <span class="status-badge status-review"></span>
                        Review
                    </h3>
                    <span class="task-count">{{ $tasks->where('status', 'review')->count() }}</span>
                </div>
                <div class="tasks-list">
                    @forelse ($tasks->where('status', 'review') as $task)
                        @php $isOverdue = $task->deadline && \Carbon\Carbon::parse($task->deadline)->isPast() && $task->status !== 'done'; @endphp
                        <a href="{{ route('customer.tasks.show', $task) }}" class="task-card {{ $isOverdue ? 'task-card-overdue' : '' }}">
                            <p class="task-title">
                                {{ $task->title }}
                                @if ($isOverdue)
                                    <span class="overdue-badge"><i class="fas fa-exclamation-triangle me-1"></i>Overdue</span>
                                @endif
                            </p>
                            <div class="task-info-row">
                                <span class="task-info-label">Project:</span>
                                <span class="task-info-value">{{ $task->project->name }}</span>
                            </div>
                            <div class="task-info-row">
                                <span class="task-info-label">Category:</span>
                                <span class="task-info-value"><span class="task-category">{{ $task->category->label() }}</span></span>
                            </div>
                            <div class="task-info-row">
                                <span class="task-info-label">Deadline:</span>
                                <span class="task-info-value"><span class="deadline-value {{ $isOverdue ? 'overdue-text' : '' }}">{{ $task->deadline ? $task->deadline->format('M d, Y') : 'No deadline' }}</span></span>
                            </div>
                            <div class="task-info-row">
                                <span class="task-info-label">Status:</span>
                                <span class="task-info-value"><span class="task-status review">{{ str_replace('_', ' ', $task->status) }}</span></span>
                            </div>
                            @if ($task->link || $task->image_path)
                                <div class="attachment-icons">
                                    @if ($task->link)
                                        <span class="attachment-icon"><i class="fas fa-link"></i> Link</span>
                                    @endif
                                    @if ($task->image_path)
                                        <span class="attachment-icon"><i class="fas fa-image"></i> Image</span>
                                    @endif
                                </div>
                            @endif
                        </a>
                    @empty
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="fas fa-inbox"></i></div>
                            <p style="margin: 0;">No tasks</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Done Column -->
            <div class="kanban-column done">
                <div class="kanban-header">
                    <h3 class="kanban-title">
                        <span class="status-badge status-done"></span>
                        Done
                    </h3>
                    <span class="task-count">{{ $tasks->where('status', 'done')->count() }}</span>
                </div>
                <div class="tasks-list">
                    @forelse ($tasks->where('status', 'done') as $task)
                        <a href="{{ route('customer.tasks.show', $task) }}" class="task-card">
                            <p class="task-title">{{ $task->title }}</p>
                            <div class="task-info-row">
                                <span class="task-info-label">Project:</span>
                                <span class="task-info-value">{{ $task->project->name }}</span>
                            </div>
                            <div class="task-info-row">
                                <span class="task-info-label">Category:</span>
                                <span class="task-info-value"><span class="task-category">{{ $task->category->label() }}</span></span>
                            </div>
                            <div class="task-info-row">
                                <span class="task-info-label">Deadline:</span>
                                <span class="task-info-value"><span class="deadline-value">{{ $task->deadline ? $task->deadline->format('M d, Y') : 'No deadline' }}</span></span>
                            </div>
                            <div class="task-info-row">
                                <span class="task-info-label">Status:</span>
                                <span class="task-info-value"><span class="task-status done">{{ str_replace('_', ' ', $task->status) }}</span></span>
                            </div>
                            @if ($task->link || $task->image_path)
                                <div class="attachment-icons">
                                    @if ($task->link)
                                        <span class="attachment-icon"><i class="fas fa-link"></i> Link</span>
                                    @endif
                                    @if ($task->image_path)
                                        <span class="attachment-icon"><i class="fas fa-image"></i> Image</span>
                                    @endif
                                </div>
                            @endif
                        </a>
                    @empty
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="fas fa-inbox"></i></div>
                            <p style="margin: 0;">No tasks</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
</div>

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title fw-600" style="color: #dc3545;">
                    <i class="fas fa-trash-alt me-2"></i>Delete Project?
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="color: var(--text-muted);">
                This will permanently delete <strong class="text-dark">{{ $project->name }}</strong> and all its associated tasks.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('customer.projects.destroy', $project) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Project</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
