@extends('customer.layouts.app')

@section('title', 'Edit Task')

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
    .container { max-width: 900px; }
    .card-modern { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0, 31, 63, 0.08); background-color: var(--white); }
    .card-header-gradient { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border: none; border-radius: 12px 12px 0 0; color: var(--white); padding: 2rem; }
    .card-header-gradient h1 { margin: 0; font-weight: 700; font-size: 1.8rem; color: var(--white); }
    h4 { color: var(--primary); font-weight: 600; }
    .form-control, .form-select { border: 1px solid var(--border); border-radius: 8px; padding: 0.75rem; font-size: 0.95rem; }
    .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(0, 31, 63, 0.1); outline: none; }
    .form-label { font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem; }
    .btn { border-radius: 8px; font-weight: 500; padding: 0.6rem 1.2rem; transition: all 0.3s ease; }
    .btn-primary { background-color: var(--primary); border-color: var(--primary); }
    .btn-primary:hover { background-color: var(--primary-dark); border-color: var(--primary-dark); }
    .btn-outline-secondary { color: var(--primary); border-color: var(--border); }
    .btn-outline-secondary:hover { background-color: rgba(0, 31, 63, 0.05); border-color: var(--primary); }
    .alert { border: none; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem; }
    .alert-danger { background-color: #ffe0e0; color: #7d2a2a; }
    .alert-info { background-color: #f0f9ff; color: #0c2340; border-left: 4px solid #3b82f6; }
    .invalid-feedback { display: block; color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem; }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-modern">
                <div class="card-header-gradient">
                    <h1><i class="fas fa-edit me-2"></i>Edit Task</h1>
                    <p class="mb-0" style="color: rgba(255, 255, 255, 0.9);">
                        <a href="{{ route('customer.projects.show', $task->project) }}" style="color: rgba(255, 255, 255, 0.9); text-decoration: none; font-weight: 500;">{{ $task->project->name }}</a>
                    </p>
                </div>
                <div class="p-4 p-md-5">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('customer.tasks.update', $task) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="title" class="form-label">
                                <i class="fas fa-heading me-1" style="color: var(--primary);"></i>Task Title <span style="color: #dc3545;">*</span>
                            </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $task->title) }}" placeholder="e.g. Implement login page" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" class="form-label">
                                <i class="fas fa-align-left me-1" style="color: var(--primary);"></i>Description
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Task details...">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="link" class="form-label">
                                <i class="fas fa-link me-1" style="color: var(--primary);"></i>Link
                            </label>
                            <input type="url" class="form-control @error('link') is-invalid @enderror" id="link" name="link" value="{{ old('link', $task->link) }}" placeholder="https://example.com">
                            @error('link')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="image" class="form-label">
                                <i class="fas fa-image me-1" style="color: var(--primary);"></i>Upload Image
                            </label>
                            @if ($task->image_path)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $task->image_path) }}" alt="{{ $task->title }}" style="max-width: 200px; max-height: 200px; border-radius: 8px;">
                                    <p class="text-muted mb-0 mt-2"><small>Current image</small></p>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                            <small class="text-muted">Max 5MB. Supported: JPG, PNG, GIF. Leave blank to keep current image.</small>
                            @error('image')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="deadline" class="form-label">
                                <i class="fas fa-calendar me-1" style="color: var(--primary);"></i>Deadline
                            </label>
                            <input type="datetime-local" class="form-control @error('deadline') is-invalid @enderror" id="deadline" name="deadline" value="{{ old('deadline', $task->deadline ? $task->deadline->format('Y-m-d\TH:i') : '') }}" min="{{ now()->format('Y-m-d\TH:i') }}">
                            @error('deadline')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="text-muted">Deadline must be in the future</small>
                        </div>
                        <div class="mb-4">
                            <label for="category" class="form-label">
                                <i class="fas fa-tag me-1" style="color: var(--primary);"></i>Category <span style="color: #dc3545;">*</span>
                            </label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="">Select a category...</option>
                                <option value="frontend" {{ old('category', $task->category->value) == 'frontend' ? 'selected' : '' }}>Frontend Developer</option>
                                <option value="backend" {{ old('category', $task->category->value) == 'backend' ? 'selected' : '' }}>Backend Developer</option>
                                <option value="server" {{ old('category', $task->category->value) == 'server' ? 'selected' : '' }}>Server Administrator</option>
                            </select>
                            @error('category')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>All changes to this task will be recorded in the history for reference.</small>
                        </div>

                        <div class="d-flex gap-2 flex-wrap justify-content-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Save Changes
                            </button>
                            <a href="{{ route('customer.tasks.show', $task) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
