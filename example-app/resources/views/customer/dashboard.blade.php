@extends('customer.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h4 mb-1 fw-600">Welcome, {{ auth()->user()->name }}</h1>
            <p class="text-muted mb-0 small">Manage your projects and tasks</p>
        </div>
        <a href="{{ route('customer.projects.create') }}" class="btn btn-primary rounded-3 px-4">
            <i class="fas fa-plus me-2"></i>New Project
        </a>
    </div>

    <div class="card card-customer border-0">
        <div class="card-body p-4">
            <h5 class="card-title mb-0 fw-600 text-accent"><i class="fas fa-folder me-2"></i>My Projects</h5>
        </div>
        <div class="card-body pt-0">
            @if ($projects->isEmpty())
                <div class="text-center py-5">
                    <div class="rounded-circle bg-light d-inline-flex p-4 mb-3">
                        <i class="fas fa-folder-open fa-2x text-muted"></i>
                    </div>
                    <p class="text-muted mb-3">You don't have any projects yet.</p>
                    <a href="{{ route('customer.projects.create') }}" class="btn btn-primary rounded-3">Create your first project</a>
                </div>
            @else
                <div class="row g-3">
                    @foreach ($projects as $project)
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-customer h-100 border-0">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start gap-2">
                                        <div class="min-w-0 flex-grow-1">
                                            <h6 class="fw-600 text-accent mb-1">{{ $project->name }}</h6>
                                            <p class="small text-muted mb-2">{{ Str::limit($project->description, 60) ?: '—' }}</p>
                                            <small class="text-muted">{{ $project->created_at->format('M d, Y') }}</small>
                                        </div>
                                        <div class="d-flex gap-1 flex-shrink-0">
                                            <a href="{{ route('customer.projects.edit', $project) }}" class="btn btn-sm btn-outline-primary rounded-3 px-2" title="Edit"><i class="fas fa-pen"></i></a>
                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-3 px-2" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $project->id }}"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                    <div class="mt-3 pt-3 border-top border-light d-flex gap-2">
                                        <a href="{{ route('customer.projects.show', $project) }}" class="btn btn-sm btn-primary rounded-3">Open</a>
                                        <a href="{{ route('customer.projects.tasks.create', $project) }}" class="btn btn-sm btn-outline-primary rounded-3">New Task</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="deleteModal-{{ $project->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg rounded-3">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title fw-600 text-danger">Delete project?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-muted">
                                        This will permanently delete <strong class="text-dark">{{ $project->name }}</strong> and all its tasks.
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('customer.projects.destroy', $project) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger rounded-3">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
