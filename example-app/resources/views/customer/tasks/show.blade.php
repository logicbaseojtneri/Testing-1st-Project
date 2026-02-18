@extends('customer.layouts.app')

@section('title', $task->title)

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
    
    .container { max-width: 700px; margin: 0 auto; padding: 0 1rem; }
    
    /* Header Styles */
    .header-section {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: 12px;
        padding: 2rem 1.5rem;
        color: var(--white);
        margin-bottom: 2rem;
        box-shadow: 0 2px 12px rgba(0, 31, 63, 0.1);
        position: relative;
    }
    
    @media (min-width: 768px) {
        .header-section {
            padding: 2.5rem;
        }
    }
    
    .task-title-main {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0 0 0.75rem 0;
        line-height: 1.2;
        color: var(--white);
    }
    
    @media (min-width: 768px) {
        .task-title-main {
            font-size: 2.8rem;
        }
    }
    
    .task-breadcrumb {
        color: rgba(255, 255, 255, 0.85);
        font-size: 1.1rem;
        margin: 0;
    }
    
    .task-breadcrumb a {
        color: rgba(255, 255, 255, 0.95);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .close-btn {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        background-color: rgba(255, 255, 255, 0.2);
        border: none;
        color: var(--white);
        width: 40px;
        height: 40px;
        border-radius: 8px;
        font-size: 1.5rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .close-btn:hover {
        background-color: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
        color: var(--white);
    }
    
    /* Status Badge */
    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: capitalize;
        margin-top: 1rem;
    }
    
    .status-to-do {
        background-color: rgba(158, 158, 158, 0.2);
        color: #9e9e9e;
    }
    
    .status-in-progress {
        background-color: rgba(255, 152, 0, 0.2);
        color: #ff9800;
    }
    
    .status-done {
        background-color: rgba(76, 175, 80, 0.2);
        color: #4caf50;
    }
    
    .status-review {
        background-color: rgba(123, 31, 162, 0.2);
        color: #7b1fa2;
    }

    /* Overdue Styles */
    .header-section.header-overdue {
        background: linear-gradient(135deg, #c62828 0%, #b71c1c 100%);
    }

    .overdue-banner {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background-color: #fff;
        color: #d32f2f;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 800;
        margin-top: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        animation: pulse-overdue 2s ease-in-out infinite;
    }

    .overdue-banner i {
        font-size: 1.1rem;
    }

    @keyframes pulse-overdue {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .meta-item.meta-overdue {
        border-left: 4px solid #d32f2f;
        background-color: rgba(244, 67, 54, 0.06);
    }

    .meta-item.meta-overdue .meta-value {
        color: #d32f2f;
        font-weight: 700;
    }
    
    .card-modern {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 31, 63, 0.08);
        background-color: var(--white);
        margin-bottom: 2rem;
        overflow: hidden;
    }
    
    .card-section {
        padding: 1.75rem;
    }
    
    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary);
        margin: 0 0 1.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .section-title i {
        font-size: 1.25rem;
    }
    
    /* Meta Information */
    .meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .meta-item {
        padding: 1rem;
        background-color: var(--light-bg);
        border-radius: 8px;
        border-left: 4px solid var(--primary);
    }
    
    .meta-label {
        font-weight: 600;
        color: var(--text-muted);
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .meta-value {
        font-size: 0.95rem;
        color: var(--text-dark);
        font-weight: 500;
    }
    
    /* Description Box */
    .description-box {
        background-color: var(--light-bg);
        padding: 1.5rem;
        border-radius: 8px;
        border-left: 4px solid var(--primary);
        line-height: 1.7;
        color: var(--text-dark);
    }
    
    /* Badge */
    .badge-modern {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        font-weight: 600;
        border-radius: 6px;
        background-color: rgba(0, 31, 63, 0.1);
        color: var(--primary);
        font-size: 0.85rem;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        padding: 1.75rem;
        border-radius: 12px;
        justify-content: center;
    }
    
    .btn {
        border-radius: 6px;
        font-weight: 500;
        padding: 0.5rem 0.8rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-primary {
        background-color: var(--primary);
        color: var(--white);
    }
    
    .btn-primary:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
    }
    
    .btn-outline-secondary {
        background-color: var(--white);
        color: var(--primary);
        border: 1.5px solid var(--border);
    }
    
    .btn-outline-secondary:hover {
        background-color: rgba(0, 31, 63, 0.05);
        border-color: var(--primary);
    }
    
    .btn-danger {
        background-color: #f44336;
        color: var(--white);
    }
    
    .btn-danger:hover {
        background-color: #e53935;
        transform: translateY(-2px);
    }
    
    /* History Table */
    .table {
        background-color: var(--white);
        margin: 0;
    }
    
    .table thead th {
        background-color: var(--light-bg);
        border: none;
        font-weight: 700;
        color: var(--text-dark);
        padding: 1rem;
        font-size: 0.9rem;
        border-bottom: 2px solid var(--border);
    }
    
    .table tbody td {
        border: 1px solid var(--border);
        padding: 0.9rem 1rem;
        color: var(--text-dark);
    }
    
    .table tbody tr:hover {
        background-color: rgba(0, 31, 63, 0.02);
    }
    
    /* Modal */
    .modal-content {
        border: none;
        border-radius: 12px;
    }
    
    .modal-header {
        border-bottom: 1px solid var(--border);
        background-color: var(--light-bg);
    }
    
    .modal-footer {
        border-top: 1px solid var(--border);
    }
</style>

@php
    $isOverdue = $task->deadline && \Carbon\Carbon::parse($task->deadline)->isPast() && $task->status !== 'done';
@endphp

<div class="container py-4">
    <!-- Header Section -->
    <div class="header-section {{ $isOverdue ? 'header-overdue' : '' }}">
        <a href="{{ route('customer.projects.tasks.index', $task->project) }}" class="close-btn">
            <i class="fas fa-times"></i>
        </a>
        <h1 class="task-title-main"><i class="fas fa-check-circle me-2"></i>{{ $task->title }}</h1>
        <p class="task-breadcrumb">
            <i class="fas fa-folder me-1"></i>
            <a href="{{ route('customer.projects.show', $task->project) }}">{{ $task->project->name }}</a>
        </p>
        <div class="status-badge status-{{ str_replace('_', '-', $task->status) }}">
            {{ str_replace('_', ' ', $task->status) }}
        </div>
        @if ($isOverdue)
            <div class="overdue-banner">
                <i class="fas fa-bell" style="color: #d32f2f;"></i> Overdue
            </div>
        @endif
    </div>

    <!-- Main Content Card -->
    <div class="card-modern">
        
        <!-- Meta Information Section -->
        <div class="card-section">
            <h3 class="section-title">
                <i class="fas fa-info-circle"></i>Task Overview
            </h3>
            <div class="meta-grid">
                <div class="meta-item">
                    <div class="meta-label">
                        <i class="fas fa-tag" style="color: var(--primary);"></i>Category
                    </div>
                    <div class="meta-value">
                        <span class="badge-modern">{{ $task->category->label() }}</span>
                    </div>
                </div>
                <div class="meta-item {{ $isOverdue ? 'meta-overdue' : '' }}">
                    <div class="meta-label">
                        <i class="fas fa-clock" style="color: {{ $isOverdue ? '#d32f2f' : 'var(--primary)' }};"></i>Deadline
                    </div>
                    <div class="meta-value">
                        @if ($task->deadline)
                            {{ $task->deadline->format('M d, Y \a\t h:i A') }}
                        @else
                            No deadline set
                        @endif
                    </div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">
                        <i class="fas fa-calendar" style="color: var(--primary);"></i>Created
                    </div>
                    <div class="meta-value">{{ $task->created_at->format('M d, Y \a\t h:i A') }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">
                        <i class="fas fa-sync" style="color: var(--primary);"></i>Last Updated
                    </div>
                    <div class="meta-value">{{ $task->updated_at->format('M d, Y \a\t h:i A') }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">
                        <i class="fas fa-info-circle" style="color: var(--primary);"></i>Status
                    </div>
                    <div class="meta-value">
                        <span class="status-badge status-{{ str_replace('_', '-', $task->status) }}" style="margin-top: 0;">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description Section -->
        <div class="card-section">
            <h3 class="section-title">
                <i class="fas fa-align-left"></i>Description
            </h3>
            <div class="description-box">
                {{ $task->description ?? 'No description provided.' }}
            </div>
        </div>

        <!-- Attachments Section -->
        @if ($task->link || $task->image_path)
            <div class="card-section">
                <h3 class="section-title">
                    <i class="fas fa-paperclip"></i>Attachments
                </h3>
                @if ($task->link)
                    <div style="margin-bottom: 1rem;">
                        <div class="meta-label" style="margin-bottom: 0.5rem;">
                            <i class="fas fa-link" style="color: var(--primary);"></i>Reference Link
                        </div>
                        <a href="{{ $task->link }}" target="_blank" style="color: var(--primary); font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; background-color: var(--light-bg); padding: 0.6rem 1rem; border-radius: 8px; transition: all 0.3s ease;">
                            <i class="fas fa-external-link-alt"></i>{{ Str::limit($task->link, 50) }}
                        </a>
                    </div>
                @endif
                @if ($task->image_path)
                    <div>
                        <div class="meta-label" style="margin-bottom: 0.5rem;">
                            <i class="fas fa-image" style="color: var(--primary);"></i>Task Image
                        </div>
                        <img src="{{ asset('storage/' . $task->image_path) }}" alt="{{ $task->title }}" style="max-width: 100%; max-height: 400px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 31, 63, 0.1);">
                    </div>
                @endif
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="card-section">
            <div class="action-buttons">
                <a href="{{ route('customer.tasks.edit', $task) }}" class="btn btn-primary">
                    <i class="fas fa-pen"></i>Edit Task
                </a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fas fa-trash-alt"></i>Delete Task
                </button>
            </div>
        </div>

        <!-- Change History Section -->
        @if ($task->history->count() > 0)
            <div class="card-section">
                <h3 class="section-title">
                    <i class="fas fa-history"></i>Change History
                </h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Changed By</th>
                                <th>Previous Value</th>
                                <th>New Value</th>
                                <th>Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($task->history as $record)
                                <tr>
                                    <td><strong>{{ ucfirst(str_replace('_', ' ', $record->field_name)) }}</strong></td>
                                    <td>
                                        @if(auth()->check() && auth()->user()->isAdmin())
                                            {{ $record->changedBy->name ?? 'System' }}
                                        @else
                                            <em>Hidden</em>
                                        @endif
                                    </td>
                                    <td style="color: var(--text-muted); font-size: 0.9rem;">{{ $record->old_value ?? '—' }}</td>
                                    <td style="color: var(--text-muted); font-size: 0.9rem;">{{ $record->new_value ?? '—' }}</td>
                                    <td style="color: var(--text-muted); font-size: 0.9rem;">{{ $record->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title fw-600" style="color: #dc3545;">
                    <i class="fas fa-trash-alt me-2"></i>Delete Task?
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="color: var(--text-muted);">
                This will permanently delete <strong class="text-dark">{{ $task->title }}</strong>. This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('customer.tasks.destroy', $task) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Task</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
