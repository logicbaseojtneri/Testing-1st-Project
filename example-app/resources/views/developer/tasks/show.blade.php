@extends('developer.layouts.app')

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

    .task-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 31, 63, 0.08);
        margin-bottom: 2rem;
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border: none;
        border-radius: 12px 12px 0 0;
        color: var(--white);
        padding: 2rem;
    }

    .card-header h2 {
        margin: 0;
        font-weight: 700;
        color: var(--white);
    }

    .card-body {
        padding: 2rem;
    }

    .info-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .info-item label {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }

    .info-item p {
        margin: 0;
        color: var(--text-dark);
    }

    h4 {
        color: var(--primary);
        font-weight: 600;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    .divider {
        border: none;
        border-top: 1px solid var(--border);
        margin: 2rem 0;
    }

    .alert {
        border: none;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
    }

    .badge {
        padding: 0.35rem 0.65rem;
        font-weight: 500;
    }
</style>

<div class="task-container py-4">
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-check-circle me-2"></i>{{ $task->title }}</h2>
        </div>
        <div class="card-body">
            <div class="info-row">
                <div class="info-item">
                    <label><i class="fas fa-folder me-2"></i>Project</label>
                    <p><strong>{{ $task->project->name }}</strong></p>
                </div>
                <div class="info-item">
                    <label><i class="fas fa-tag me-2"></i>Category</label>
                    <p><span class="badge" style="background-color: rgba(0, 31, 63, 0.1); color: var(--primary);">{{ $task->category?->value ?? 'N/A' }}</span></p>
                </div>
                <div class="info-item">
                    <label><i class="fas fa-circle-notch me-2"></i>Current Status</label>
                    <p><span class="badge" style="background-color: rgba(0, 31, 63, 0.1); color: var(--primary);">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span></p>
                </div>
            </div>

            <div class="info-row">
                <div class="info-item">
                    <label><i class="fas fa-user me-2"></i>Created By</label>
                    <p>{{ $task->creator->name }}</p>
                </div>
                <div class="info-item">
                    <label><i class="fas fa-calendar me-2"></i>Created</label>
                    <p>{{ $task->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div class="info-item">
                    <label><i class="fas fa-sync me-2"></i>Last Updated</label>
                    <p>{{ $task->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>

            <hr class="divider">

            <h4><i class="fas fa-align-left me-2"></i>Description</h4>
            <p style="line-height: 1.6; color: var(--text-dark);">{{ $task->description ?? 'No description provided' }}</p>

            @if ($task->link || $task->image_path || $task->deadline)
                <hr class="divider">
                <h4><i class="fas fa-paperclip me-2"></i>Task Details</h4>
                
                @if ($task->link)
                    <div class="mb-3">
                        <label style="color: var(--primary); font-weight: 600;"><i class="fas fa-link me-2"></i>Reference Link</label>
                        <p><a href="{{ $task->link }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-external-link-alt me-1"></i>Open Link
                        </a></p>
                    </div>
                @endif

                @if ($task->image_path)
                    <div class="mb-3">
                        <label style="color: var(--primary); font-weight: 600;"><i class="fas fa-image me-2"></i>Task Image</label>
                        <div style="margin-top: 0.5rem;">
                            <img src="{{ asset('storage/' . $task->image_path) }}" alt="{{ $task->title }}" style="max-width: 100%; max-height: 400px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 31, 63, 0.1);">
                        </div>
                    </div>
                @endif

                @if ($task->deadline)
                    <div class="mb-3">
                        <label style="color: var(--primary); font-weight: 600;"><i class="fas fa-calendar-alt me-2"></i>Deadline</label>
                        <p style="font-size: 1.1rem; color: {{ $task->deadline < now() && $task->status !== 'done' ? '#d32f2f' : 'var(--text-dark)' }};">
                            {{ $task->deadline->format('M d, Y \a\t H:i\A') }}
                            @if ($task->deadline < now() && $task->status !== 'done')
                                <span class="badge bg-danger ms-2"><i class="fas fa-exclamation-triangle me-1"></i>Overdue</span>
                            @elseif ($task->deadline->diffInDays(now()) <= 2 && $task->deadline > now() && $task->status !== 'done')
                                <span class="badge bg-warning ms-2"><i class="fas fa-clock me-1"></i>Due Soon</span>
                            @endif
                        </p>
                    </div>
                @endif
            @endif

            <hr class="divider">

            <h4><i class="fas fa-exchange-alt me-2"></i>Update Status</h4>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                </div>
            @endif

            <form action="{{ route('developer.tasks.updateStatus', $task) }}" method="POST" class="mb-3">
                @csrf
                @method('PUT')
                <div class="row g-2 align-items-end">
                    <div class="col-md-8">
                        <label for="status" class="form-label"><strong>Select New Status</strong></label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">Choose a status...</option>
                            <option value="to_do" {{ $task->status === 'to_do' ? 'selected' : '' }}>To Do</option>
                            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Done</option>
                            <option value="review" {{ $task->status === 'review' ? 'selected' : '' }}>Review</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-1"></i>Update Status
                        </button>
                    </div>
                </div>
            </form>

            <hr class="divider">

            <h4><i class="fas fa-paperclip me-2"></i>Add Task Details</h4>
            <form action="{{ route('developer.tasks.updateDetails', $task) }}" method="POST" enctype="multipart/form-data" class="mb-3">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="detail_link" class="form-label"><i class="fas fa-link me-1"></i>Reference Link</label>
                        <input type="url" class="form-control @error('link') is-invalid @enderror" id="detail_link" name="link" value="{{ old('link', $task->link) }}" placeholder="https://example.com/resource">
                        <small class="text-muted">Optional reference link for the task</small>
                        @error('link')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="detail_image" class="form-label"><i class="fas fa-image me-1"></i>Upload Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="detail_image" name="image" accept="image/*">
                        <small class="text-muted">Max 5MB. Supported: JPG, PNG, GIF</small>
                        @error('image')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @if ($task->image_path)
                    <div class="mt-3 mb-3">
                        <small class="text-muted d-block mb-2">Current image:</small>
                        <img src="{{ asset('storage/' . $task->image_path) }}" alt="{{ $task->title }}" style="max-width: 150px; max-height: 150px; border-radius: 8px;">
                    </div>
                @endif
                <button type="submit" class="btn btn-primary mt-2">
                    <i class="fas fa-save me-1"></i>Save Details
                </button>
            </form>

            @if ($task->history()->where('field_name', 'status')->exists())
                <form action="{{ route('developer.tasks.undo', $task) }}" method="POST" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-undo me-1"></i>Undo Last Change
                    </button>
                </form>
            @endif

            @if ($task->history->count() > 0)
                <hr class="divider">
                <h4><i class="fas fa-history me-2"></i>Change History</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Changed By</th>
                                <th>Old Value</th>
                                <th>New Value</th>
                                <th>Date</th>
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
                                    <td style="color: var(--text-muted);">{{ $record->old_value ?? '—' }}</td>
                                    <td style="color: var(--text-muted);">{{ $record->new_value ?? '—' }}</td>
                                    <td style="color: var(--text-muted); font-size: 0.9rem;">{{ $record->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="mt-4 pt-2">
                <a href="{{ route('developer.tasks.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Tasks
                </a>
            </div>
        </div>
    </div>
</div>

@endsection