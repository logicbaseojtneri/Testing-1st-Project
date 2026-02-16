@extends('developer.layouts.app')

@section('title', 'Dashboard')

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
        --success: #4caf50;
        --warning: #ff9800;
        --danger: #f44336;
    }

    .welcome-section {
        margin-bottom: 2rem;
    }

    .welcome-section h1 {
        color: var(--primary);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .role-badge {
        display: inline-block;
        background-color: rgba(0, 31, 63, 0.1);
        color: var(--primary);
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .kpi-card {
        background: linear-gradient(135deg, var(--white) 0%, #f5f5f5 100%);
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 2px 8px rgba(0, 31, 63, 0.06);
        border-left: 4px solid;
        text-align: center;
        transition: all 0.3s ease;
    }

    .kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 31, 63, 0.12);
    }

    .kpi-card.total { border-left-color: var(--primary); }
    .kpi-card.in-progress { border-left-color: var(--warning); }
    .kpi-card.overdue { border-left-color: var(--danger); }
    .kpi-card.completed { border-left-color: var(--success); }

    .kpi-icon {
        font-size: 1.5rem;
        margin-bottom: 0.75rem;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 50px;
        height: 50px;
        border-radius: 10px;
        margin: 0 auto 0.75rem;
        color: var(--white);
    }

    .kpi-card.total .kpi-icon { background-color: var(--primary); }
    .kpi-card.in-progress .kpi-icon { background-color: var(--warning); }
    .kpi-card.overdue .kpi-icon { background-color: var(--danger); }
    .kpi-card.completed .kpi-icon { background-color: var(--success); }

    .kpi-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .kpi-label {
        color: var(--text-muted);
        font-weight: 500;
        font-size: 0.8rem;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title i {
        color: var(--primary);
    }

    .project-card {
        background-color: var(--white);
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 2px 8px rgba(0, 31, 63, 0.06);
        border: 1px solid var(--border);
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
        display: block;
    }

    .project-card:hover {
        box-shadow: 0 8px 20px rgba(0, 31, 63, 0.12);
        transform: translateY(-4px);
        border-color: var(--primary);
        text-decoration: none;
        color: inherit;
    }

    .project-name {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

    .project-desc {
        color: var(--text-muted);
        font-size: 0.85rem;
        margin: 0.5rem 0 0 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .project-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border);
    }

    .project-meta i {
        color: var(--primary);
        width: 14px;
    }

    .tasks-container {
        background-color: var(--white);
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 31, 63, 0.06);
        border: 1px solid var(--border);
        overflow: hidden;
    }

    .task-item {
        padding: 1rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
        cursor: pointer;
        width: 100%;
        text-decoration: none;
        color: inherit;
        background-color: var(--white);
    }

    .task-item:last-child {
        border-bottom: none;
    }

    .task-item:hover {
        background-color: rgba(0, 31, 63, 0.02);
        padding-left: 1.25rem;
    }

    .task-item.task-item-overdue {
        border-left: 4px solid #d32f2f;
        background-color: rgba(244, 67, 54, 0.04);
    }

    .task-item.task-item-overdue:hover {
        background-color: rgba(244, 67, 54, 0.08);
    }

    .overdue-badge {
        display: inline-block;
        background-color: rgba(244, 67, 54, 0.15);
        color: #d32f2f;
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
        font-size: 0.65rem;
        font-weight: 700;
        margin-left: 0.4rem;
    }

    .task-info {
        flex: 1;
    }

    .task-title {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
        font-size: 0.95rem;
    }

    .task-project {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .attachment-icons {
        display: inline-flex;
        gap: 0.4rem;
        margin-left: 0.5rem;
    }

    .attachment-icon {
        display: inline-flex;
        align-items: center;
        gap: 0.2rem;
        font-size: 0.7rem;
        color: #6b7280;
        background: #f3f4f6;
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
    }

    .attachment-icon i {
        font-size: 0.65rem;
    }

    .task-item:hover .attachment-icon {
        background: rgba(0,0,0,0.08);
    }

    .task-status {
        display: inline-block;
        padding: 0.3rem 0.7rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: capitalize;
        white-space: nowrap;
        margin-left: 1rem;
    }

    .task-status.to-do { background-color: rgba(158, 158, 158, 0.15); color: #4a4a4a; }
    .task-status.in-progress { background-color: rgba(255, 152, 0, 0.2); color: #e68900; }
    .task-status.done { background-color: rgba(76, 175, 80, 0.2); color: #388e3c; }
    .task-status.review { background-color: rgba(123, 31, 162, 0.15); color: #7b1fa2; }

    .empty-message {
        padding: 2rem;
        text-align: center;
        color: var(--text-muted);
    }

    .empty-message i {
        font-size: 2rem;
        opacity: 0.2;
        margin-bottom: 1rem;
        display: block;
    }

    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="py-4">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <h1>Welcome, {{ auth()->user()->name }}! </h1>
        <span class="role-badge">Developer</span>
    </div>

    <!-- KPI Cards -->
    <div class="kpi-grid">
        <!-- Total Tasks -->
        <div class="kpi-card total">
            <div class="kpi-icon">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="kpi-number">{{ $kpis['total'] }}</div>
            <div class="kpi-label">Total Tasks</div>
        </div>

        <!-- In Progress -->
        <div class="kpi-card in-progress">
            <div class="kpi-icon">
                <i class="fas fa-hourglass-start"></i>
            </div>
            <div class="kpi-number">{{ $kpis['in_progress'] }}</div>
            <div class="kpi-label">In Progress</div>
        </div>

        <!-- Overdue -->
        <div class="kpi-card overdue">
            <div class="kpi-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="kpi-number">{{ $kpis['overdue'] }}</div>
            <div class="kpi-label">Overdue</div>
        </div>

        <!-- Completed -->
        <div class="kpi-card completed">
            <div class="kpi-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="kpi-number">{{ $kpis['completed'] }}</div>
            <div class="kpi-label">Completed</div>
        </div>
    </div>

    <!-- Content Grid: Projects (Left) and Recent Tasks (Right) -->
    <div class="content-grid">
        <!-- Projects -->
        <div>
            <h2 class="section-title">
                <i class="fas fa-folder"></i>My Projects
            </h2>

            @if ($projects->isEmpty())
                <div class="empty-message">
                    <i class="fas fa-inbox"></i>
                    <p>No projects yet</p>
                </div>
            @else
                @foreach ($projects as $project)
                    <a href="{{ route('developer.projects.show', $project) }}" class="project-card">
                        <div class="project-name">{{ $project->name }}</div>
                        <p class="project-desc">{{ $project->description ?? 'No description' }}</p>
                        <div class="project-meta">
                            <span>
                                <i class="fas fa-tasks"></i>
                                {{ $project->assigned_task_count }} task{{ $project->assigned_task_count !== 1 ? 's' : '' }}
                            </span>
                            <span style="margin-left: auto;">
                                <i class="fas fa-calendar"></i>
                                {{ $project->created_at->format('M d') }}
                            </span>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>

        <!-- Recent Tasks -->
        <div>
            <h2 class="section-title">
                <i class="fas fa-clock"></i>Recent Tasks
            </h2>

            @if ($recentTasks->isEmpty())
                <div class="empty-message">
                    <i class="fas fa-inbox"></i>
                    <p>No tasks yet</p>
                </div>
            @else
                <div class="tasks-container">
                    @foreach ($recentTasks as $task)
                        @php $isOverdue = $task->deadline && \Carbon\Carbon::parse($task->deadline)->isPast() && $task->status !== 'done'; @endphp
                        <a href="{{ route('developer.tasks.show', $task) }}" class="task-item {{ $isOverdue ? 'task-item-overdue' : '' }}">
                            <div class="task-info">
                                <div class="task-title">
                                    {{ $task->title }}
                                    @if ($isOverdue)
                                        <span class="overdue-badge"><i class="fas fa-exclamation-triangle me-1"></i>Overdue</span>
                                    @endif
                                    @if ($task->link || $task->image_path)
                                        <span class="attachment-icons">
                                            @if ($task->link)
                                                <span class="attachment-icon"><i class="fas fa-link"></i> Link</span>
                                            @endif
                                            @if ($task->image_path)
                                                <span class="attachment-icon"><i class="fas fa-image"></i> Image</span>
                                            @endif
                                        </span>
                                    @endif
                                </div>
                                <div class="task-project">
                                    <i class="fas fa-folder-open"></i>
                                    {{ $task->project->name ?? 'No Project' }}
                                </div>
                                <div class="task-project">
                                    <i class="fas fa-calendar"></i>
                                    {{ $task->deadline ? $task->deadline->format('M d, Y') : 'No deadline' }}
                                </div>
                            </div>
                            <span class="task-status {{ str_replace('_', '-', $task->status) }}">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
