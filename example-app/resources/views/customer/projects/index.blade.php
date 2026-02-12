@extends('customer.layouts.app')

@section('title', 'My Projects')

@section('content')
<div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h4 mb-1 fw-600">My Projects</h1>
            <p class="text-muted mb-0 small">Create a project, then add tasks inside it.</p>
        </div>
        <a href="{{ route('customer.projects.create') }}" class="btn btn-primary rounded-3 px-4">
            <i class="fas fa-plus me-2"></i>New Project
        </a>
    </div>

    <div class="card card-customer border-0 overflow-hidden">
        @if ($projects->isEmpty())
            <div class="card-body text-center py-5">
                <div class="rounded-circle bg-light d-inline-flex p-4 mb-3">
                    <i class="fas fa-folder-open fa-2x text-muted"></i>
                </div>
                <p class="text-muted mb-3">You don't have any projects yet.</p>
                <a href="{{ route('customer.projects.create') }}" class="btn btn-primary rounded-3">Create your first project</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-customer table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Name</th>
                            <th>Description</th>
                            <th>Created</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td class="ps-4 fw-500">{{ $project->name }}</td>
                                <td class="text-muted">{{ Str::limit($project->description, 50) ?: '—' }}</td>
                                <td class="text-muted small">{{ $project->created_at->format('M d, Y') }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('customer.projects.show', $project) }}" class="btn btn-sm btn-primary rounded-3 me-1">Open</a>
                                    <a href="{{ route('customer.projects.tasks.create', $project) }}" class="btn btn-sm btn-outline-primary rounded-3 me-1">New Task</a>
                                    <a href="{{ route('customer.projects.edit', $project) }}" class="btn btn-sm btn-outline-primary rounded-3 px-2" title="Edit"><i class="fas fa-pen"></i></a>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-3 px-2" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $project->id }}"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
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
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
