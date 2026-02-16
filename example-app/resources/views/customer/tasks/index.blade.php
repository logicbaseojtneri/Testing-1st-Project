@extends('customer.layouts.app')

@section('title', $project->name . ' – Tasks')

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
    
    .kanban-column.review::before {
        background: linear-gradient(90deg, #7b1fa2 0%, #ab47bc 100%);
    }

    .kanban-column.done::before {
        background: linear-gradient(90deg, #4caf50 0%, #81c784 100%);
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
        color: var(--text-dark);
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
    
    .task-count {
        background-color: var(--text-muted);
        color: var(--white);
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .add-task-btn {
        background-color: var(--white);
        border: 2px dashed var(--border);
        color: var(--text-muted);
        font-weight: 600;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
        text-align: center;
        margin-top: auto;
    }
    
    .add-task-btn:hover {
        background-color: var(--white);
        border-color: var(--primary);
        color: var(--primary);
    }
    
    .tasks-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        flex: 1;
    }
    
    .task-card {
        background-color: var(--light-bg);
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 1px 3px rgba(0, 31, 63, 0.06);
        cursor: pointer;
        transition: all 0.3s ease;
        border-left: 4px solid var(--border);
    }
    
    .task-card:hover {
        box-shadow: 0 4px 12px rgba(0, 31, 63, 0.15);
        transform: translateY(-2px);
    }

    .task-card.task-card-overdue {
        border-left: 4px solid #d32f2f;
        background-color: rgba(244, 67, 54, 0.04);
    }

    .task-info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.35rem;
        font-size: 0.85rem;
    }

    .task-info-label {
        color: var(--text-muted);
        font-weight: 500;
    }

    .task-info-value {
        color: var(--text-dark);
        font-weight: 500;
        text-align: right;
    }

    .task-status {
        display: inline-block;
        padding: 0.2rem 0.6rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: capitalize;
    }

    .task-status.to-do {
        background-color: rgba(158, 158, 158, 0.15);
        color: #616161;
    }

    .task-status.in-progress {
        background-color: rgba(255, 152, 0, 0.15);
        color: #e65100;
    }

    .task-status.review {
        background-color: rgba(123, 31, 162, 0.15);
        color: #7b1fa2;
    }

    .task-status.done {
        background-color: rgba(76, 175, 80, 0.15);
        color: #2e7d32;
    }

    .deadline-value {
        font-size: 0.8rem;
    }

    .deadline-value.overdue-text {
        color: #d32f2f;
        font-weight: 700;
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
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .task-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.75rem;
        font-size: 0.85rem;
        color: var(--text-muted);
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
    
    .page-header {
        margin-bottom: 2rem;
    }
    
    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }
    
    .page-subtitle {
        color: var(--text-muted);
        margin-bottom: 0;
    }
</style>

<div class="container py-4">
    <div class="page-header">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h1 class="page-title">{{ $project->name }}</h1>
                <p class="page-subtitle">{{ $project->description ?? 'Organize and track your project tasks' }}</p>
            </div>
            <a href="{{ route('customer.projects.show', $project) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Project
            </a>
        </div>
    </div>

    @if ($tasks->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-tasks fa-3x mb-3 opacity-25"></i>
                <p class="mb-0">No tasks in this project yet. <a href="{{ route('customer.projects.tasks.create', $project) }}" style="color: var(--primary); font-weight: 600;">Create your first task</a>.</p>
            </div>
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
                        <a href="{{ route('customer.tasks.show', $task) }}" class="task-card {{ $isOverdue ? 'task-card-overdue' : '' }}" style="text-decoration: none; display: block;">
                            <p class="task-title">
                                {{ $task->title }}
                                @if ($isOverdue)
                                    <span class="overdue-badge"><i class="fas fa-exclamation-triangle me-1"></i>Overdue</span>
                                @endif
                            </p>
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
                                <span class="task-info-value"><span class="task-status to-do">To Do</span></span>
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
                            <div class="task-meta">
                                <span>{{ $task->created_at->format('M d') }}</span>
                            </div>
                        </a>
                    @empty
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="fas fa-inbox"></i></div>
                            <p style="margin: 0;">No tasks</p>
                        </div>
                    @endforelse
                </div>
                <a href="{{ route('customer.projects.tasks.create', $project) }}" class="add-task-btn">
                    <i class="fas fa-plus me-2"></i>Add Task
                </a>
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
                        <a href="{{ route('customer.tasks.show', $task) }}" class="task-card {{ $isOverdue ? 'task-card-overdue' : '' }}" style="text-decoration: none; display: block;">
                            <p class="task-title">
                                {{ $task->title }}
                                @if ($isOverdue)
                                    <span class="overdue-badge"><i class="fas fa-exclamation-triangle me-1"></i>Overdue</span>
                                @endif
                            </p>
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
                                <span class="task-info-value"><span class="task-status in-progress">In Progress</span></span>
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
                            <div class="task-meta">
                                <span>{{ $task->created_at->format('M d') }}</span>
                            </div>
                        </a>
                    @empty
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="fas fa-inbox"></i></div>
                            <p style="margin: 0;">No tasks</p>
                        </div>
                    @endforelse
                </div>
                <a href="{{ route('customer.projects.tasks.create', $project) }}" class="add-task-btn">
                    <i class="fas fa-plus me-2"></i>Add Task
                </a>
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
                        <a href="{{ route('customer.tasks.show', $task) }}" class="task-card {{ $isOverdue ? 'task-card-overdue' : '' }}" style="text-decoration: none; display: block;">
                            <p class="task-title">
                                {{ $task->title }}
                                @if ($isOverdue)
                                    <span class="overdue-badge"><i class="fas fa-exclamation-triangle me-1"></i>Overdue</span>
                                @endif
                            </p>
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
                                <span class="task-info-value"><span class="task-status review">Review</span></span>
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
                            <div class="task-meta">
                                <span>{{ $task->created_at->format('M d') }}</span>
                            </div>
                        </a>
                    @empty
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="fas fa-inbox"></i></div>
                            <p style="margin: 0;">No tasks</p>
                        </div>
                    @endforelse
                </div>
                <a href="{{ route('customer.projects.tasks.create', $project) }}" class="add-task-btn">
                    <i class="fas fa-plus me-2"></i>Add Task
                </a>
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
                        <a href="{{ route('customer.tasks.show', $task) }}" class="task-card" style="text-decoration: none; display: block;">
                            <p class="task-title">{{ $task->title }}</p>
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
                                <span class="task-info-value"><span class="task-status done">Done</span></span>
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
                            <div class="task-meta">
                                <span>{{ $task->created_at->format('M d') }}</span>
                            </div>
                        </a>
                    @empty
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="fas fa-inbox"></i></div>
                            <p style="margin: 0;">No tasks</p>
                        </div>
                    @endforelse
                </div>
                <a href="{{ route('customer.projects.tasks.create', $project) }}" class="add-task-btn">
                    <i class="fas fa-plus me-2"></i>Add Task
                </a>
            </div>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
