@extends('admin.layouts.app')

@section('title', 'Manage Projects')

@section('content')
<div class="container-fluid py-4 px-4">

    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-700 mb-1" style="color: #001f3f;">All Projects</h4>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">{{ $projects->total() }} total projects in the system</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-sm rounded-3">
            <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
        </a>
    </div>

    <!-- Projects Table Card -->
    <div class="card border-0 overflow-hidden" style="box-shadow: 0 2px 8px rgba(0, 31, 63, 0.08);">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Project Name</th>
                        <th>Tasks</th>
                        <th>Frontend Dev</th>
                        <th>Backend Dev</th>
                        <th>Server Admin</th>
                        <th>Created</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                    <tr>
                        <td class="ps-4 text-muted">{{ $project->id }}</td>
                        <td>
                            <a href="{{ route('admin.projects.show', $project) }}" class="text-decoration-none">
                                <p class="mb-0 fw-600" style="color: #1a1a1a;">{{ $project->name }}</p>
                            </a>
                            <small class="text-muted">{{ Str::limit($project->description, 50) }}</small>
                        </td>
                        <td>
                            <span class="badge rounded-pill" style="background: #001f3f;">{{ $project->tasks_count }}</span>
                        </td>
                        <td class="text-muted">{{ $project->frontendDeveloper->name ?? '—' }}</td>
                        <td class="text-muted">{{ $project->backendDeveloper->name ?? '—' }}</td>
                        <td class="text-muted">{{ $project->serverAdmin->name ?? '—' }}</td>
                        <td class="text-muted small">{{ $project->created_at->format('M d, Y') }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-sm btn-outline-primary rounded-3 me-1" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-outline-warning rounded-3 me-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this project? It can be recovered from Trash.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="rounded-circle bg-light d-inline-flex p-4 mb-3">
                                <i class="fas fa-folder-open fa-2x text-muted"></i>
                            </div>
                            <p class="text-muted mb-0">No projects found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($projects->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $projects->links() }}
    </div>
    @endif
</div>
@endsection
