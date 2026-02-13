@extends('customer.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4 px-4">
    <!-- Welcome Banner -->
    <div class="welcome-banner mb-5" style="background: linear-gradient(135deg, #001f3f 0%, #003d6b 100%); border-radius: 12px; padding: 2rem; color: white; box-shadow: 0 4px 12px rgba(0, 31, 63, 0.15);">
        <h1 class="mb-2" style="font-size: 2.5rem; font-weight: 700; letter-spacing: -0.5px; color: #ffffff;">Welcome back, {{ auth()->user()->name }}! 👋</h1>
        <p class="mb-0" style="font-size: 1.1rem; opacity: 0.9; color: #ffffff;">Ready to manage your projects and tasks? Let's get started.</p>
    </div>

    <!-- KPI Cards -->
    <div class="row g-4 mb-5">
        <!-- Total Projects -->
        <div class="col-md-6 col-lg-3">
            <div class="kpi-card" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(0, 31, 63, 0.12); border-left: 6px solid #001f3f; display: flex; flex-direction: column; justify-content: center; transition: all 0.3s ease;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <p style="color: #6c757d; font-size: 0.8rem; margin-bottom: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Total Projects</p>
                        <h2 style="color: #001f3f; font-size: 2.5rem; font-weight: 800; margin: 0; line-height: 1;">{{ $projects->count() }}</h2>
                    </div>
                    <div style="text-align: center;">
                        <i class="fas fa-folder" style="font-size: 3rem; color: #001f3f; opacity: 0.15;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Tasks Created -->
        <div class="col-md-6 col-lg-3">
            <div class="kpi-card" style="background: linear-gradient(135deg, #ffffff 0%, #fffbf0 100%); border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(255, 152, 0, 0.12); border-left: 6px solid #ff9800; display: flex; flex-direction: column; justify-content: center; transition: all 0.3s ease;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <p style="color: #6c757d; font-size: 0.8rem; margin-bottom: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Tasks Created</p>
                        <h2 style="color: #ff9800; font-size: 2.5rem; font-weight: 800; margin: 0; line-height: 1;">{{ $tasks->count() }}</h2>
                    </div>
                    <div style="text-align: center;">
                        <i class="fas fa-tasks" style="font-size: 3rem; color: #ff9800; opacity: 0.15;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks by Status - To Do -->
        <div class="col-md-6 col-lg-3">
            <div class="kpi-card" style="background: linear-gradient(135deg, #ffffff 0%, #f5f5f5 100%); border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(158, 158, 158, 0.12); border-left: 6px solid #9e9e9e; display: flex; flex-direction: column; justify-content: center; transition: all 0.3s ease;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <p style="color: #6c757d; font-size: 0.8rem; margin-bottom: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">To Do</p>
                        <h2 style="color: #6c757d; font-size: 2.5rem; font-weight: 800; margin: 0; line-height: 1;">{{ $tasks->where('status', 'to_do')->count() }}</h2>
                    </div>
                    <div style="text-align: center;">
                        <i class="fas fa-circle" style="font-size: 3rem; color: #9e9e9e; opacity: 0.15;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks by Status - Completed -->
        <div class="col-md-6 col-lg-3">
            <div class="kpi-card" style="background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%); border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(76, 175, 80, 0.12); border-left: 6px solid #4caf50; display: flex; flex-direction: column; justify-content: center; transition: all 0.3s ease;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <p style="color: #6c757d; font-size: 0.8rem; margin-bottom: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Completed</p>
                        <h2 style="color: #4caf50; font-size: 2.5rem; font-weight: 800; margin: 0; line-height: 1;">{{ $tasks->where('status', 'done')->count() }}</h2>
                    </div>
                    <div style="text-align: center;">
                        <i class="fas fa-check-circle" style="font-size: 3rem; color: #4caf50; opacity: 0.15;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects Table -->
    <div class="card card-customer border-0 overflow-hidden" style="box-shadow: 0 2px 8px rgba(0, 31, 63, 0.08);">
        <div class="card-header border-0 bg-white p-4">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0 fw-600" style="color: #001f3f;"><i class="fas fa-list me-2"></i>My Projects</h5>
                <a href="{{ route('customer.projects.create') }}" class="btn btn-primary btn-sm rounded-3">
                    <i class="fas fa-plus me-1"></i>New Project
                </a>
            </div>
        </div>

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
                            <th>Tasks</th>
                            <th>Created</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td class="ps-4 fw-500">{{ $project->name }}</td>
                                <td class="text-muted">{{ Str::limit($project->description, 50) ?: '—' }}</td>
                                <td>
                                    <span class="badge bg-primary rounded-pill">{{ $project->tasks->count() }}</span>
                                </td>
                                <td class="text-muted small">{{ $project->created_at->format('M d, Y') }}</td>
                                <td class="text-end pe-4">
                                    <div class="btn-group gap-1" role="group">
                                        <a href="{{ route('customer.projects.show', $project) }}" class="btn btn-sm btn-primary rounded-3">Open</a>
                                        <a href="{{ route('customer.projects.edit', $project) }}" class="btn btn-sm btn-outline-secondary rounded-3" title="Edit"><i class="fas fa-pen"></i></a>
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-3" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $project->id }}"><i class="fas fa-trash-alt"></i></button>
                                    </div>
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
