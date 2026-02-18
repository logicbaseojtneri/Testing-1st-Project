@extends('admin.layouts.app')

@section('title', 'Edit Project')

@section('content')
<div class="container-fluid py-4 px-4">

    <!-- Back Link -->
    <div class="mb-4">
        <a href="{{ route('admin.projects.show', $project) }}" class="text-decoration-none text-muted" style="font-size: 0.85rem;">
            <i class="fas fa-arrow-left me-1"></i>Back to Project
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0" style="box-shadow: 0 2px 8px rgba(0, 31, 63, 0.08);">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h5 class="fw-700 mb-1" style="color: #001f3f;">
                        <i class="fas fa-edit me-2"></i>Edit Project
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 0.85rem;">Update project details and team assignments</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.projects.update', $project) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Project Name -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-600" style="color: #001f3f; font-size: 0.85rem;">
                                Project Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $project->name) }}"
                                   placeholder="Enter project name" required>
                            @error('name')
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
                                      placeholder="Enter project description">{{ old('description', $project->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-700 mb-0" style="color: #001f3f;">
                                <i class="fas fa-users me-2"></i>Team Assignments
                            </h6>
                        </div>
                        <div class="alert alert-light border d-flex align-items-center gap-2 mb-4" style="font-size: 0.85rem;">
                            <i class="fas fa-info-circle text-primary"></i>
                            <span>Choose a developer manually or use <strong>Auto-Assign All</strong> to let the system pick the least-loaded developers.</span>
                            <form action="{{ route('admin.projects.auto-assign', $project) }}" method="POST" class="ms-auto flex-shrink-0"
                                  onsubmit="return confirm('This will auto-assign all 3 roles. Continue?');">
                                @csrf
                                <button type="submit" class="btn btn-sm text-white" style="background: #001f3f;">
                                    <i class="fas fa-magic me-1"></i>Auto-Assign All
                                </button>
                            </form>
                        </div>

                        <!-- Frontend Developer -->
                        <div class="mb-4">
                            <label for="frontend_dev_id" class="form-label fw-600" style="color: #001f3f; font-size: 0.85rem;">
                                <span class="d-inline-block rounded-circle me-1" style="width: 8px; height: 8px; background: #0d6efd;"></span>
                                Frontend Developer
                            </label>
                            <select class="form-select @error('frontend_dev_id') is-invalid @enderror"
                                    id="frontend_dev_id" name="frontend_dev_id">
                                <option value="">— Not Assigned —</option>
                                @foreach($frontendDevs as $dev)
                                    <option value="{{ $dev->id }}" {{ old('frontend_dev_id', $project->frontend_dev_id) == $dev->id ? 'selected' : '' }}>
                                        {{ $dev->name }} ({{ $dev->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('frontend_dev_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Backend Developer -->
                        <div class="mb-4">
                            <label for="backend_dev_id" class="form-label fw-600" style="color: #001f3f; font-size: 0.85rem;">
                                <span class="d-inline-block rounded-circle me-1" style="width: 8px; height: 8px; background: #198754;"></span>
                                Backend Developer
                            </label>
                            <select class="form-select @error('backend_dev_id') is-invalid @enderror"
                                    id="backend_dev_id" name="backend_dev_id">
                                <option value="">— Not Assigned —</option>
                                @foreach($backendDevs as $dev)
                                    <option value="{{ $dev->id }}" {{ old('backend_dev_id', $project->backend_dev_id) == $dev->id ? 'selected' : '' }}>
                                        {{ $dev->name }} ({{ $dev->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('backend_dev_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Server Admin -->
                        <div class="mb-4">
                            <label for="server_admin_id" class="form-label fw-600" style="color: #001f3f; font-size: 0.85rem;">
                                <span class="d-inline-block rounded-circle me-1" style="width: 8px; height: 8px; background: #dc3545;"></span>
                                Server Administrator
                            </label>
                            <select class="form-select @error('server_admin_id') is-invalid @enderror"
                                    id="server_admin_id" name="server_admin_id">
                                <option value="">— Not Assigned —</option>
                                @foreach($serverAdmins as $dev)
                                    <option value="{{ $dev->id }}" {{ old('server_admin_id', $project->server_admin_id) == $dev->id ? 'selected' : '' }}>
                                        {{ $dev->name }} ({{ $dev->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('server_admin_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-between align-items-center pt-3" style="border-top: 1px solid #e9ecef;">
                            <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-outline-secondary">
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
