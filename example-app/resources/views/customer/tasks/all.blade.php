@extends('customer.layouts.app')

@section('title', 'All My Tasks')

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

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
        background-color: var(--white);
        box-shadow: 0 1px 4px rgba(0, 31, 63, 0.08);
    }

    .back-btn:hover {
        background-color: var(--primary);
        color: var(--white);
        box-shadow: 0 4px 12px rgba(0, 31, 63, 0.15);
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

    .task-status.review {
        background-color: rgba(123, 31, 162, 0.15);
        color: #7b1fa2;
    }

    .task-status.done {
        background-color: rgba(76, 175, 80, 0.2);
        color: #388e3c;
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

    /* KPI Cards */
    .kpi-container {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 1200px) {
        .kpi-container {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .kpi-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .kpi-card {
        background: var(--white);
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 2px 8px rgba(0, 31, 63, 0.06);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
        border: 1px solid var(--border);
    }

    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 31, 63, 0.1);
    }

    .kpi-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .kpi-icon.projects { background: rgba(0, 31, 63, 0.1); color: var(--primary); }
    .kpi-icon.in-progress { background: rgba(255, 152, 0, 0.15); color: #e68900; }
    .kpi-icon.review { background: rgba(156, 39, 176, 0.12); color: #7b1fa2; }
    .kpi-icon.completed { background: rgba(76, 175, 80, 0.15); color: #388e3c; }
    .kpi-icon.overdue { background: rgba(244, 67, 54, 0.12); color: #d32f2f; }

    .kpi-info {
        display: flex;
        flex-direction: column;
    }

    .kpi-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-dark);
        line-height: 1.2;
    }

    .kpi-label {
        font-size: 0.8rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    /* Filtered results list */
    .filtered-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1rem;
    }

    .clear-filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: #fff;
        color: #d32f2f;
        border: 1px solid #d32f2f;
        padding: 0.4rem 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-left: 1rem;
    }

    .clear-filter-btn:hover {
        background: #d32f2f;
        color: #fff;
    }

    .filter-info {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        background: var(--primary);
        color: #fff;
        padding: 0.35rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
</style>

<div class="container-fluid py-4">
    <!-- Back Button -->
    <a href="{{ route('customer.dashboard') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>

    <div class="page-header">
        <div>
            <h1 class="page-title">
                @if (isset($query))
                    Search Results for "{{ $query }}"
                @elseif (isset($status))
                    Tasks - {{ ucfirst(str_replace('_', ' ', $status)) }}
                @elseif (isset($category))
                    Tasks - {{ ucfirst($category) }} Category
                @else
                    All Tasks
                @endif
            </h1>
            <p class="page-subtitle">
                @if (isset($query))
                    Showing {{ $tasks->count() }} result(s)
                @elseif (isset($status) || isset($category))
                    Filtered view
                @else
                    All your tasks across every project
                @endif
            </p>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="kpi-container">
        <div class="kpi-card">
            <div class="kpi-icon projects"><i class="fas fa-tasks"></i></div>
            <div class="kpi-info">
                <span class="kpi-value">{{ $kpi['total_tasks'] }}</span>
                <span class="kpi-label">Total Tasks</span>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon in-progress"><i class="fas fa-spinner"></i></div>
            <div class="kpi-info">
                <span class="kpi-value">{{ $kpi['in_progress'] }}</span>
                <span class="kpi-label">In Progress</span>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon review"><i class="fas fa-eye"></i></div>
            <div class="kpi-info">
                <span class="kpi-value">{{ $kpi['review'] }}</span>
                <span class="kpi-label">Review</span>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon completed"><i class="fas fa-check-circle"></i></div>
            <div class="kpi-info">
                <span class="kpi-value">{{ $kpi['completed'] }}</span>
                <span class="kpi-label">Completed</span>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon overdue"><i class="fas fa-bell"></i></div>
            <div class="kpi-info">
                <span class="kpi-value">{{ $kpi['overdue'] }}</span>
                <span class="kpi-label">Overdue</span>
            </div>
        </div>
    </div>

    @if (isset($query) || isset($status) || isset($category))
        <!-- Filter/Search Info Bar -->
        <div class="filter-info">
            <span style="color: var(--text-muted); font-size: 0.9rem;">
                <i class="fas fa-filter me-1"></i>Active filter:
            </span>
            @if (isset($query))
                <span class="filter-badge"><i class="fas fa-search"></i> "{{ $query }}"</span>
            @endif
            @if (isset($status))
                <span class="filter-badge"><i class="fas fa-circle" style="font-size: 0.5rem;"></i> {{ ucfirst(str_replace('_', ' ', $status)) }}</span>
            @endif
            @if (isset($category))
                <span class="filter-badge"><i class="fas fa-tag"></i> {{ ucfirst($category) }}</span>
            @endif
            <a href="{{ route('customer.tasks.all') }}" class="clear-filter-btn">
                <i class="fas fa-times"></i> Clear Filter
            </a>
        </div>
    @endif

    @if ($tasks->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                <p class="mb-0">
                    @if (isset($query))
                        No tasks found matching "{{ $query }}"
                    @elseif (isset($status) || isset($category))
                        No tasks match the selected filter
                    @else
                        No tasks to display
                    @endif
                </p>
            </div>
        </div>
    @elseif (isset($query) || isset($status) || isset($category))
        <!-- Filtered/Searched Results - Card Grid -->
        <div class="filtered-list">
            @foreach ($tasks as $task)
                @php $isOverdue = $task->deadline && \Carbon\Carbon::parse($task->deadline)->isPast() && $task->status !== 'done'; @endphp
                <a href="{{ route('customer.tasks.show', $task) }}" class="task-card {{ $isOverdue ? 'task-card-overdue' : '' }}" style="text-decoration: none; display: block;">
                    <p class="task-title">
                        {{ $task->title }}
                        @if ($isOverdue)
                            <span class="overdue-badge"><i class="fas fa-exclamation-triangle me-1"></i>Overdue</span>
                        @endif
                    </p>
                    <div class="task-info-row">
                        <span class="task-info-label">Project:</span>
                        <span class="task-info-value">{{ $task->project->name ?? 'No Project' }}</span>
                    </div>
                    <div class="task-info-row">
                        <span class="task-info-label">Category:</span>
                        <span class="task-info-value"><span class="task-category">{{ $task->category?->value ?? 'N/A' }}</span></span>
                    </div>
                    <div class="task-info-row">
                        <span class="task-info-label">Deadline:</span>
                        <span class="task-info-value"><span class="deadline-value {{ $isOverdue ? 'overdue-text' : '' }}">{{ $task->deadline ? $task->deadline->format('M d, Y') : 'No deadline' }}</span></span>
                    </div>
                    <div class="task-info-row">
                        <span class="task-info-label">Status:</span>
                        <span class="task-info-value"><span class="task-status {{ str_replace('_', '-', $task->status) }}">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span></span>
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
            @endforeach
        </div>
    @else
        <div class="kanban-container">
            <!-- To Do Column -->
            <div class="kanban-column todo">
                <div class="kanban-header">
                    <h3 class="kanban-title">
                        <span class="status-badge status-todo"></span>
                        To Do
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
                                <span class="task-info-label">Project:</span>
                                <span class="task-info-value">{{ $task->project->name ?? 'No Project' }}</span>
                            </div>
                            <div class="task-info-row">
                                <span class="task-info-label">Category:</span>
                                <span class="task-info-value"><span class="task-category">{{ $task->category?->value ?? 'N/A' }}</span></span>
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
                        <a href="{{ route('customer.tasks.show', $task) }}" class="task-card {{ $isOverdue ? 'task-card-overdue' : '' }}" style="text-decoration: none; display: block;">
                            <p class="task-title">
                                {{ $task->title }}
                                @if ($isOverdue)
                                    <span class="overdue-badge"><i class="fas fa-exclamation-triangle me-1"></i>Overdue</span>
                                @endif
                            </p>
                            <div class="task-info-row">
                                <span class="task-info-label">Project:</span>
                                <span class="task-info-value">{{ $task->project->name ?? 'No Project' }}</span>
                            </div>
                            <div class="task-info-row">
                                <span class="task-info-label">Category:</span>
                                <span class="task-info-value"><span class="task-category">{{ $task->category?->value ?? 'N/A' }}</span></span>
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
                        <a href="{{ route('customer.tasks.show', $task) }}" class="task-card {{ $isOverdue ? 'task-card-overdue' : '' }}" style="text-decoration: none; display: block;">
                            <p class="task-title">
                                {{ $task->title }}
                                @if ($isOverdue)
                                    <span class="overdue-badge"><i class="fas fa-exclamation-triangle me-1"></i>Overdue</span>
                                @endif
                            </p>
                            <div class="task-info-row">
                                <span class="task-info-label">Project:</span>
                                <span class="task-info-value">{{ $task->project->name ?? 'No Project' }}</span>
                            </div>
                            <div class="task-info-row">
                                <span class="task-info-label">Category:</span>
                                <span class="task-info-value"><span class="task-category">{{ $task->category?->value ?? 'N/A' }}</span></span>
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
                        <a href="{{ route('customer.tasks.show', $task) }}" class="task-card" style="text-decoration: none; display: block;">
                            <p class="task-title">{{ $task->title }}</p>
                            <div class="task-info-row">
                                <span class="task-info-label">Project:</span>
                                <span class="task-info-value">{{ $task->project->name ?? 'No Project' }}</span>
                            </div>
                            <div class="task-info-row">
                                <span class="task-info-label">Category:</span>
                                <span class="task-info-value"><span class="task-category">{{ $task->category?->value ?? 'N/A' }}</span></span>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
