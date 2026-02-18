@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid py-4 px-4">

    <!-- Welcome Banner -->
    <div class="mb-5" style="background: linear-gradient(135deg, #001f3f 0%, #003d6b 100%); border-radius: 12px; padding: 2rem 2.5rem; color: white; box-shadow: 0 4px 16px rgba(0, 31, 63, 0.25);">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <p class="mb-1" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1.5px; opacity: 0.7;"><i class="fas fa-shield-halved me-1"></i>Admin Panel</p>
                <h1 class="mb-2" style="font-size: 2.2rem; font-weight: 800; letter-spacing: -0.5px;">Welcome back, {{ auth()->user()->name }}!</h1>
                <p class="mb-0" style="font-size: 1rem; opacity: 0.8;">System overview and management dashboard</p>
            </div>
            <div class="d-none d-md-block text-end">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-3" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.1);">
                    <i class="fas fa-calendar-alt" style="opacity: 0.7;"></i>
                    <span style="font-size: 0.9rem; font-weight: 500;">{{ now()->format('F d, Y') }}</span>
                </div>
                <p class="mt-2 mb-0" style="font-size: 0.75rem; opacity: 0.5;">ManageX v1.0</p>
            </div>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row g-4 mb-5">
        <!-- Total Users -->
        <div class="col-md-6 col-lg-3">
            <div style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(0, 31, 63, 0.1); border-left: 6px solid #001f3f; transition: all 0.3s ease;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p style="color: #6c757d; font-size: 0.8rem; margin-bottom: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Total Users</p>
                        <h2 style="color: #001f3f; font-size: 2.5rem; font-weight: 800; margin: 0; line-height: 1;">{{ $totalUsers }}</h2>
                    </div>
                    <div><i class="fas fa-users" style="font-size: 3rem; color: #001f3f; opacity: 0.12;"></i></div>
                </div>
            </div>
        </div>
        <!-- Total Projects -->
        <div class="col-md-6 col-lg-3">
            <div style="background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%); border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(16, 185, 129, 0.1); border-left: 6px solid #10b981; transition: all 0.3s ease;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p style="color: #6c757d; font-size: 0.8rem; margin-bottom: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Total Projects</p>
                        <h2 style="color: #10b981; font-size: 2.5rem; font-weight: 800; margin: 0; line-height: 1;">{{ $totalProjects }}</h2>
                    </div>
                    <div><i class="fas fa-folder-open" style="font-size: 3rem; color: #10b981; opacity: 0.12;"></i></div>
                </div>
            </div>
        </div>
        <!-- Total Tasks -->
        <div class="col-md-6 col-lg-3">
            <div style="background: linear-gradient(135deg, #ffffff 0%, #fffbf0 100%); border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(255, 152, 0, 0.1); border-left: 6px solid #ff9800; transition: all 0.3s ease;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p style="color: #6c757d; font-size: 0.8rem; margin-bottom: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Total Tasks</p>
                        <h2 style="color: #ff9800; font-size: 2.5rem; font-weight: 800; margin: 0; line-height: 1;">{{ $totalTasks }}</h2>
                    </div>
                    <div><i class="fas fa-clipboard-list" style="font-size: 3rem; color: #ff9800; opacity: 0.12;"></i></div>
                </div>
            </div>
        </div>
        <!-- Total Developers -->
        <div class="col-md-6 col-lg-3">
            <div style="background: linear-gradient(135deg, #ffffff 0%, #eef2ff 100%); border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(99, 102, 241, 0.1); border-left: 6px solid #6366f1; transition: all 0.3s ease;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p style="color: #6c757d; font-size: 0.8rem; margin-bottom: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Developers</p>
                        <h2 style="color: #6366f1; font-size: 2.5rem; font-weight: 800; margin: 0; line-height: 1;">{{ $totalDevelopers }}</h2>
                    </div>
                    <div><i class="fas fa-code" style="font-size: 3rem; color: #6366f1; opacity: 0.12;"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-5">
        <h6 class="fw-700 text-uppercase mb-3" style="color: #6c757d; letter-spacing: 1px; font-size: 0.75rem;">Quick Actions</h6>
        <div class="row g-3">
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.register-user.form') }}" class="card text-decoration-none h-100" style="border-left: 4px solid #0d6efd;">
                    <div class="card-body d-flex align-items-center gap-3 py-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(13, 110, 253, 0.1);">
                            <i class="fas fa-user-plus" style="color: #0d6efd; font-size: 1.1rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 fw-600" style="color: #1a1a1a; font-size: 0.9rem;">Register User</p>
                            <small class="text-muted">Add new accounts</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.users.index') }}" class="card text-decoration-none h-100" style="border-left: 4px solid #10b981;">
                    <div class="card-body d-flex align-items-center gap-3 py-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(16, 185, 129, 0.1);">
                            <i class="fas fa-users-cog" style="color: #10b981; font-size: 1.1rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 fw-600" style="color: #1a1a1a; font-size: 0.9rem;">Manage Profiles</p>
                            <small class="text-muted">View & edit users</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.projects.index') }}" class="card text-decoration-none h-100" style="border-left: 4px solid #8b5cf6;">
                    <div class="card-body d-flex align-items-center gap-3 py-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(139, 92, 246, 0.1);">
                            <i class="fas fa-folder-open" style="color: #8b5cf6; font-size: 1.1rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 fw-600" style="color: #1a1a1a; font-size: 0.9rem;">Manage Projects</p>
                            <small class="text-muted">All projects</small>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.tasks.index') }}" class="card text-decoration-none h-100" style="border-left: 4px solid #f59e0b;">
                    <div class="card-body d-flex align-items-center gap-3 py-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(245, 158, 11, 0.1);">
                            <i class="fas fa-clipboard-list" style="color: #f59e0b; font-size: 1.1rem;"></i>
                        </div>
                        <div>
                            <p class="mb-0 fw-600" style="color: #1a1a1a; font-size: 0.9rem;">Manage Tasks</p>
                            <small class="text-muted">All tasks</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Overview Cards Row -->
    <div class="row g-4 mb-5">

        <!-- Users Overview -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="fw-700 mb-0" style="color: #001f3f;"><i class="fas fa-users me-2"></i>Users Overview</h6>
                        <span class="badge rounded-pill" style="background: #001f3f;">{{ $totalUsers }}</span>
                    </div>
                </div>
                <div class="card-body px-4">
                    <div class="row text-center g-2 mb-3 py-3" style="background: #f8f9fa; border-radius: 8px;">
                        <div class="col-4">
                            <p class="mb-0" style="font-size: 1.5rem; font-weight: 800; color: #dc2626;">{{ $adminCount }}</p>
                            <small class="text-muted" style="font-size: 0.7rem;">Admins</small>
                        </div>
                        <div class="col-4" style="border-left: 1px solid #e9ecef; border-right: 1px solid #e9ecef;">
                            <p class="mb-0" style="font-size: 1.5rem; font-weight: 800; color: #10b981;">{{ $customerCount }}</p>
                            <small class="text-muted" style="font-size: 0.7rem;">Customers</small>
                        </div>
                        <div class="col-4">
                            <p class="mb-0" style="font-size: 1.5rem; font-weight: 800; color: #0d6efd;">{{ $totalDevelopers }}</p>
                            <small class="text-muted" style="font-size: 0.7rem;">Developers</small>
                        </div>
                    </div>
                    <div id="usersListContainer" style="max-height: 0; overflow: hidden; transition: max-height 0.4s ease;">
                        <h6 class="text-muted mb-2" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Recent Users</h6>
                        @forelse($usersList as $user)
                        <div class="d-flex align-items-center justify-content-between py-2 px-2 rounded-2" style="transition: background 0.2s;" onmouseover="this.style.background='rgba(0,31,63,0.03)'" onmouseout="this.style.background='transparent'">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: #001f3f; color: white; font-size: 0.75rem; font-weight: 700;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="mb-0" style="font-size: 0.85rem; font-weight: 600; color: #1a1a1a;">{{ $user->name }}</p>
                                    <small class="text-muted" style="font-size: 0.75rem;">{{ $user->email }}</small>
                                </div>
                            </div>
                            <span class="badge
                                @if($user->role->value === 'admin') bg-danger
                                @elseif($user->role->value === 'customer') bg-success
                                @elseif($user->role->value === 'frontend') bg-info
                                @elseif($user->role->value === 'backend') bg-primary
                                @elseif($user->role->value === 'server_admin') bg-warning text-dark
                                @else bg-secondary
                                @endif
                            " style="font-size: 0.7rem;">{{ ucfirst(str_replace('_', ' ', $user->role->value)) }}</span>
                        </div>
                        @empty
                        <p class="text-muted text-center py-3 mb-0">No users found</p>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="{{ route('admin.users.index') }}" class="text-decoration-none" style="font-size: 0.85rem; font-weight: 600; color: #001f3f;">View All Users <i class="fas fa-arrow-right ms-1" style="font-size: 0.7rem;"></i></a>
                        <button class="btn btn-sm btn-outline-secondary border-0" onclick="togglePanel('usersListContainer', this)" title="Expand">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects Overview -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="fw-700 mb-0" style="color: #001f3f;"><i class="fas fa-folder-open me-2"></i>Projects Overview</h6>
                        <span class="badge rounded-pill" style="background: #10b981;">{{ $totalProjects }}</span>
                    </div>
                </div>
                <div class="card-body px-4">
                    <div class="text-center py-3 mb-3" style="background: #f8f9fa; border-radius: 8px;">
                        <p class="mb-0" style="font-size: 2.5rem; font-weight: 800; color: #001f3f;">{{ $totalProjects }}</p>
                        <small class="text-muted">Total Projects</small>
                    </div>
                    <div id="projectsListContainer" style="max-height: 0; overflow: hidden; transition: max-height 0.4s ease;">
                        <h6 class="text-muted mb-2" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Recent Projects</h6>
                        @forelse($projectsList as $project)
                        <div class="d-flex align-items-center justify-content-between py-2 px-2 rounded-2" style="transition: background 0.2s;" onmouseover="this.style.background='rgba(0,31,63,0.03)'" onmouseout="this.style.background='transparent'">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: rgba(16, 185, 129, 0.1); color: #10b981; font-size: 0.75rem; font-weight: 700;">
                                    {{ strtoupper(substr($project->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="mb-0" style="font-size: 0.85rem; font-weight: 600; color: #1a1a1a;">{{ Str::limit($project->name, 22) }}</p>
                                    <small class="text-muted" style="font-size: 0.75rem;">{{ $project->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-muted" style="font-size: 0.7rem;"></i>
                        </div>
                        @empty
                        <p class="text-muted text-center py-3 mb-0">No projects found</p>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="{{ route('admin.projects.index') }}" class="text-decoration-none" style="font-size: 0.85rem; font-weight: 600; color: #10b981;">View All Projects <i class="fas fa-arrow-right ms-1" style="font-size: 0.7rem;"></i></a>
                        <button class="btn btn-sm btn-outline-secondary border-0" onclick="togglePanel('projectsListContainer', this)" title="Expand">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Overview -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="fw-700 mb-0" style="color: #001f3f;"><i class="fas fa-clipboard-list me-2"></i>Tasks Overview</h6>
                        <span class="badge rounded-pill" style="background: #ff9800;">{{ $totalTasks }}</span>
                    </div>
                </div>
                <div class="card-body px-4">
                    <div class="row text-center g-2 mb-3 py-3" style="background: #f8f9fa; border-radius: 8px;">
                        <div class="col-3">
                            <p class="mb-0" style="font-size: 1.25rem; font-weight: 800; color: #6c757d;">{{ $toDoTasks }}</p>
                            <small class="text-muted" style="font-size: 0.65rem;">To Do</small>
                        </div>
                        <div class="col-3" style="border-left: 1px solid #e9ecef;">
                            <p class="mb-0" style="font-size: 1.25rem; font-weight: 800; color: #0d6efd;">{{ $inProgressTasks }}</p>
                            <small class="text-muted" style="font-size: 0.65rem;">Progress</small>
                        </div>
                        <div class="col-3" style="border-left: 1px solid #e9ecef;">
                            <p class="mb-0" style="font-size: 1.25rem; font-weight: 800; color: #f59e0b;">{{ $reviewTasks }}</p>
                            <small class="text-muted" style="font-size: 0.65rem;">Review</small>
                        </div>
                        <div class="col-3" style="border-left: 1px solid #e9ecef;">
                            <p class="mb-0" style="font-size: 1.25rem; font-weight: 800; color: #10b981;">{{ $doneTasks }}</p>
                            <small class="text-muted" style="font-size: 0.65rem;">Done</small>
                        </div>
                    </div>
                    <div id="tasksListContainer" style="max-height: 0; overflow: hidden; transition: max-height 0.4s ease;">
                        <h6 class="text-muted mb-2" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Recent Tasks</h6>
                        @forelse($tasksList as $task)
                        <div class="d-flex align-items-center justify-content-between py-2 px-2 rounded-2" style="transition: background 0.2s;" onmouseover="this.style.background='rgba(0,31,63,0.03)'" onmouseout="this.style.background='transparent'">
                            <div class="d-flex align-items-center gap-2">
                                <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px;
                                    @if($task->status === 'to_do') background: #6c757d;
                                    @elseif($task->status === 'in_progress') background: #0d6efd;
                                    @elseif($task->status === 'review') background: #f59e0b;
                                    @elseif($task->status === 'done') background: #10b981;
                                    @endif
                                "></span>
                                <div>
                                    <p class="mb-0" style="font-size: 0.85rem; font-weight: 600; color: #1a1a1a;">{{ Str::limit($task->title, 22) }}</p>
                                    <small class="text-muted" style="font-size: 0.75rem;">{{ $task->project->name ?? 'No Project' }}</small>
                                </div>
                            </div>
                            <span class="badge
                                @if($task->status === 'to_do') bg-secondary
                                @elseif($task->status === 'in_progress') bg-primary
                                @elseif($task->status === 'review') bg-warning text-dark
                                @elseif($task->status === 'done') bg-success
                                @endif
                            " style="font-size: 0.7rem;">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
                        </div>
                        @empty
                        <p class="text-muted text-center py-3 mb-0">No tasks found</p>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="{{ route('admin.tasks.index') }}" class="text-decoration-none" style="font-size: 0.85rem; font-weight: 600; color: #f59e0b;">View All Tasks <i class="fas fa-arrow-right ms-1" style="font-size: 0.7rem;"></i></a>
                        <button class="btn btn-sm btn-outline-secondary border-0" onclick="togglePanel('tasksListContainer', this)" title="Expand">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Developer Team Breakdown -->
    <div class="card mb-5">
        <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="fw-700 mb-1" style="color: #001f3f;"><i class="fas fa-code me-2"></i>Developer Team</h6>
                    <small class="text-muted">Breakdown by specialization</small>
                </div>
                <span class="badge rounded-pill" style="background: #001f3f; font-size: 0.8rem; padding: 0.5rem 1rem;">
                    <i class="fas fa-users me-1"></i>{{ $totalDevelopers }} Total
                </span>
            </div>
        </div>
        <div class="card-body px-4">
            <div class="row g-3">
                <div class="col-md-3 col-6">
                    <div class="text-center p-3 rounded-3" style="background: rgba(13, 110, 253, 0.06); border: 1px solid rgba(13, 110, 253, 0.12);">
                        <i class="fas fa-laptop-code mb-2" style="font-size: 1.5rem; color: #0d6efd;"></i>
                        <h3 style="font-weight: 800; color: #0d6efd; margin-bottom: 0;">{{ $frontendCount }}</h3>
                        <small class="text-muted" style="font-weight: 600;">Frontend</small>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="text-center p-3 rounded-3" style="background: rgba(16, 185, 129, 0.06); border: 1px solid rgba(16, 185, 129, 0.12);">
                        <i class="fas fa-server mb-2" style="font-size: 1.5rem; color: #10b981;"></i>
                        <h3 style="font-weight: 800; color: #10b981; margin-bottom: 0;">{{ $backendCount }}</h3>
                        <small class="text-muted" style="font-weight: 600;">Backend</small>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="text-center p-3 rounded-3" style="background: rgba(245, 158, 11, 0.06); border: 1px solid rgba(245, 158, 11, 0.12);">
                        <i class="fas fa-network-wired mb-2" style="font-size: 1.5rem; color: #f59e0b;"></i>
                        <h3 style="font-weight: 800; color: #f59e0b; margin-bottom: 0;">{{ $serverAdminCount }}</h3>
                        <small class="text-muted" style="font-weight: 600;">Server Admin</small>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="text-center p-3 rounded-3" style="background: rgba(139, 92, 246, 0.06); border: 1px solid rgba(139, 92, 246, 0.12);">
                        <i class="fas fa-terminal mb-2" style="font-size: 1.5rem; color: #8b5cf6;"></i>
                        <h3 style="font-weight: 800; color: #8b5cf6; margin-bottom: 0;">{{ $developerCount }}</h3>
                        <small class="text-muted" style="font-weight: 600;">General</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Status Breakdown -->
    <div class="card mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
            <h6 class="fw-700 mb-1" style="color: #001f3f;"><i class="fas fa-chart-bar me-2"></i>Task Status Breakdown</h6>
            <small class="text-muted">Current status distribution</small>
        </div>
        <div class="card-body px-4">
            <div class="row g-3">
                <div class="col">
                    <div class="text-center p-3 rounded-3" style="background: linear-gradient(135deg, #001f3f, #003d6b); color: white;">
                        <i class="fas fa-list-check mb-2" style="font-size: 1.3rem; opacity: 0.8;"></i>
                        <h3 style="font-weight: 800; margin-bottom: 0;">{{ $totalTasks }}</h3>
                        <small style="opacity: 0.8;">Total</small>
                    </div>
                </div>
                <div class="col">
                    <div class="text-center p-3 rounded-3" style="background: rgba(108, 117, 125, 0.06); border: 1px solid rgba(108, 117, 125, 0.12);">
                        <i class="fas fa-circle mb-2" style="font-size: 1.3rem; color: #6c757d;"></i>
                        <h3 style="font-weight: 800; color: #1a1a1a; margin-bottom: 0;">{{ $toDoTasks }}</h3>
                        <small class="text-muted">To Do</small>
                    </div>
                </div>
                <div class="col">
                    <div class="text-center p-3 rounded-3" style="background: rgba(13, 110, 253, 0.06); border: 1px solid rgba(13, 110, 253, 0.12);">
                        <i class="fas fa-spinner mb-2" style="font-size: 1.3rem; color: #0d6efd;"></i>
                        <h3 style="font-weight: 800; color: #0d6efd; margin-bottom: 0;">{{ $inProgressTasks }}</h3>
                        <small class="text-muted">In Progress</small>
                    </div>
                </div>
                <div class="col">
                    <div class="text-center p-3 rounded-3" style="background: rgba(245, 158, 11, 0.06); border: 1px solid rgba(245, 158, 11, 0.12);">
                        <i class="fas fa-eye mb-2" style="font-size: 1.3rem; color: #f59e0b;"></i>
                        <h3 style="font-weight: 800; color: #f59e0b; margin-bottom: 0;">{{ $reviewTasks }}</h3>
                        <small class="text-muted">In Review</small>
                    </div>
                </div>
                <div class="col">
                    <div class="text-center p-3 rounded-3" style="background: rgba(16, 185, 129, 0.06); border: 1px solid rgba(16, 185, 129, 0.12);">
                        <i class="fas fa-check-circle mb-2" style="font-size: 1.3rem; color: #10b981;"></i>
                        <h3 style="font-weight: 800; color: #10b981; margin-bottom: 0;">{{ $doneTasks }}</h3>
                        <small class="text-muted">Completed</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePanel(containerId, btn) {
        const container = document.getElementById(containerId);
        const icon = btn.querySelector('i');
        if (container.style.maxHeight === '0px' || container.style.maxHeight === '') {
            container.style.maxHeight = '500px';
            container.style.overflow = 'auto';
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        } else {
            container.style.maxHeight = '0px';
            container.style.overflow = 'hidden';
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    }
</script>
@endpush
