@extends('customer.layouts.app')

@section('title', 'Create Project')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-customer border-0">
                <div class="card-body p-4 p-md-5">
                    <h4 class="fw-600 text-accent mb-4"><i class="fas fa-folder-plus me-2"></i>Create New Project</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('customer.projects.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="form-label fw-500">Project name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg rounded-3 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Website Redesign" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" class="form-label fw-500">Description</label>
                            <textarea class="form-control rounded-3 @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Brief description of the project">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary rounded-3 px-4">Create Project</button>
                            <a href="{{ route('customer.projects.index') }}" class="btn btn-outline-secondary rounded-3">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
