@extends('developer.layouts.app')

@section('title', 'Projects')

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

    .projects-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        padding: 1.5rem 0;
    }

    .project-card {
        background-color: var(--white);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 31, 63, 0.06);
        transition: all 0.3s ease;
        border: 1px solid var(--border);
        cursor: pointer;
        display: flex;
        flex-direction: column;
    }

    .project-card:hover {
        box-shadow: 0 8px 24px rgba(0, 31, 63, 0.12);
        transform: translateY(-4px);
        border-color: var(--primary);
    }

    .project-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .project-icon {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 1.5rem;
    }

    .project-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
        word-break: break-word;
    }

    .project-card:hover .project-name {
        color: var(--primary);
    }

    .project-description {
        color: var(--text-muted);
        font-size: 0.9rem;
        line-height: 1.5;
        margin: 0.75rem 0;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .project-meta {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border);
        font-size: 0.85rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-muted);
    }

    .meta-item i {
        color: var(--primary);
        width: 16px;
        text-align: center;
    }

    .badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        background-color: rgba(0, 31, 63, 0.1);
        color: var(--primary);
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .project-card-link {
        text-decoration: none;
        color: inherit;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--text-muted);
    }

    .empty-state-icon {
        font-size: 3rem;
        opacity: 0.2;
        margin-bottom: 1rem;
    }

    .empty-state-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .empty-state-text {
        margin-bottom: 0;
    }
</style>

<div class="container-fluid py-4">
    <div class="page-header">
        <div>
            <h1 class="page-title">
                <i class="fas fa-folder me-2"></i>My Projects
            </h1>
            <p class="page-subtitle">
                Projects with tasks assigned to you
            </p>
        </div>
    </div>

    @if ($projects->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <h3 class="empty-state-title">No Projects</h3>
                    <p class="empty-state-text">
                        You don't have any projects with assigned tasks yet. Check back soon!
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="projects-grid">
            @foreach ($projects as $project)
                <a href="{{ route('developer.projects.show', $project) }}" class="project-card-link">
                    <div class="project-card">
                        <div class="project-card-header">
                            <div>
                                <h3 class="project-name">{{ $project->name }}</h3>
                            </div>
                            <div class="project-icon">
                                <i class="fas fa-folder"></i>
                            </div>
                        </div>

                        @if ($project->description)
                            <p class="project-description">{{ $project->description }}</p>
                        @else
                            <p class="project-description text-muted" style="font-style: italic;">No description provided</p>
                        @endif

                        <div class="project-meta">
                            <div class="meta-item">
                                <i class="fas fa-tasks"></i>
                                <span>
                                    <strong>{{ $project->assigned_task_count }}</strong>
                                    @if ($project->assigned_task_count === 1)
                                        task assigned
                                    @else
                                        tasks assigned
                                    @endif
                                </span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $project->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>

@endsection
