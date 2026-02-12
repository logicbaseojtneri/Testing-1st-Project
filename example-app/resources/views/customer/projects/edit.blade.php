@extends('customer.layouts.app')

@section('title', 'Edit Project')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-customer border-0">
                <div class="card-body p-4 p-md-5">
                    <h4 class="fw-600 text-accent mb-4"><i class="fas fa-pen me-2"></i>Edit Project</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('customer.projects.update', $project) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <label for="name" class="form-label fw-500">Project name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg rounded-3" id="name" name="name" value="{{ old('name', $project->name) }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="form-label fw-500">Description</label>
                            <textarea class="form-control rounded-3" id="description" name="description" rows="4">{{ old('description', $project->description) }}</textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary rounded-3 px-4">Save changes</button>
                            <a href="{{ route('customer.projects.show', $project) }}" class="btn btn-outline-secondary rounded-3">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
