@extends('customer.layouts.app')

@section('title', 'Create Task')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-customer border-0">
                <div class="card-body p-4 p-md-5">
                    <p class="text-muted small mb-2">Project: <span class="fw-500 text-dark">{{ $project->name }}</span></p>
                    <h4 class="fw-600 text-accent mb-4"><i class="fas fa-plus-circle me-2"></i>Create New Task</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('customer.projects.tasks.store', $project) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="form-label fw-500">Task title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg rounded-3 @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Implement login page" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" class="form-label fw-500">Description</label>
                            <textarea class="form-control rounded-3 @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Task details...">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="category" class="form-label fw-500">Category <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg rounded-3 @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="">Select category</option>
                                <option value="frontend" {{ old('category') == 'frontend' ? 'selected' : '' }}>Frontend Developer</option>
                                <option value="backend" {{ old('category') == 'backend' ? 'selected' : '' }}>Backend Developer</option>
                                <option value="server" {{ old('category') == 'server' ? 'selected' : '' }}>Server Administrator</option>
                            </select>
                            @error('category')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary rounded-3 px-4">Create Task</button>
                            <a href="{{ route('customer.projects.tasks.index', $project) }}" class="btn btn-outline-secondary rounded-3">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
