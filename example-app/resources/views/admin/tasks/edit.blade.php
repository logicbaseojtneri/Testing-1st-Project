@extends('admin.layouts.app')

@section('title', 'Edit Task')

@section('content')
<div class="container-fluid py-4 px-4">

    <!-- Back Link -->
    <div class="mb-4">
        <a href="{{ route('admin.tasks.show', $task) }}" class="text-decoration-none text-muted" style="font-size: 0.85rem;">
            <i class="fas fa-arrow-left me-1"></i>Back to Task
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0" style="box-shadow: 0 2px 8px rgba(0, 31, 63, 0.08);">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h5 class="fw-700 mb-1" style="color: #001f3f;">
                        <i class="fas fa-edit me-2"></i>Edit Task
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 0.85rem;">Update task details, deadline, status, and assignment</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.tasks.update', $task) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-600" style="color: #001f3f; font-size: 0.85rem;">
                                Task Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title', $task->title) }}"
                                   placeholder="Enter task title" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-600" style="color: #001f3f; font-size: 0.85rem;">
                                Description
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4"
                                      placeholder="Enter task description">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Project -->
                            <div class="col-md-6">
                                <label for="project_id" class="form-label fw-600" style="color: #001f3f; font-size: 0.85rem;">
                                    Project <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('project_id') is-invalid @enderror"
                                        id="project_id" name="project_id" required>
                                    <option value="">— Select Project —</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="col-md-6">
                                <label for="category" class="form-label fw-600" style="color: #001f3f; font-size: 0.85rem;">
                                    Category
                                </label>
                                <select class="form-select @error('category') is-invalid @enderror"
                                        id="category" name="category">
                                    <option value="">— No Category —</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->value }}" {{ old('category', $task->category?->value) == $cat->value ? 'selected' : '' }}>
                                            {{ $cat->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Status -->
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-600" style="color: #001f3f; font-size: 0.85rem;">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status" name="status" required>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ old('status', $task->status) == $status ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Assigned To -->
                            <div class="col-md-6">
                                <label for="assigned_to" class="form-label fw-600" style="color: #001f3f; font-size: 0.85rem;">
                                    Assigned To
                                </label>
                                <select class="form-select @error('assigned_to') is-invalid @enderror"
                                        id="assigned_to" name="assigned_to">
                                    <option value="">— Unassigned —</option>
                                    @foreach($developers as $dev)
                                        <option value="{{ $dev->id }}" {{ old('assigned_to', $task->assigned_to) == $dev->id ? 'selected' : '' }}>
                                            {{ $dev->name }} ({{ $dev->role->label() }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('assigned_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">
                        <h6 class="fw-700 mb-3" style="color: #001f3f;">
                            <i class="fas fa-calendar-alt me-2"></i>Dates
                        </h6>

                        <div class="row g-3 mb-4">
                            <!-- Due Date -->
                            <div class="col-md-6">
                                <label for="due_date" class="form-label fw-600" style="color: #001f3f; font-size: 0.85rem;">
                                    Due Date
                                </label>
                                <input type="date" class="form-control @error('due_date') is-invalid @enderror"
                                       id="due_date" name="due_date"
                                       value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Deadline -->
                            <div class="col-md-6">
                                <label for="deadline" class="form-label fw-600" style="color: #001f3f; font-size: 0.85rem;">
                                    Deadline
                                </label>
                                <input type="date" class="form-control @error('deadline') is-invalid @enderror"
                                       id="deadline" name="deadline"
                                       value="{{ old('deadline', $task->deadline?->format('Y-m-d')) }}">
                                @error('deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-between align-items-center pt-3" style="border-top: 1px solid #e9ecef;">
                            <a href="{{ route('admin.tasks.show', $task) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn text-white px-4" style="background: #001f3f;">
                                <i class="fas fa-save me-1"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
