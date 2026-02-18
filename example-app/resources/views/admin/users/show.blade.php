@extends('admin.layouts.app')

@section('title', $user->name . ' — User Profile')

@push('styles')
<style>
    .profile-header {
        background: linear-gradient(135deg, #001f3f 0%, #003366 100%);
        border-radius: 16px;
        padding: 2.5rem;
        position: relative;
        overflow: hidden;
    }
    .profile-header::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
    }
    .profile-header::after {
        content: '';
        position: absolute;
        bottom: -30px;
        right: 100px;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,0.03);
    }
    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        background: rgba(255,255,255,0.15);
        color: #fff;
        flex-shrink: 0;
    }
    .profile-name {
        color: #fff;
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 0.15rem;
    }
    .profile-email {
        color: rgba(255,255,255,0.7);
        font-size: 0.9rem;
    }
    .role-badge-lg {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .stat-card {
        border: none;
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 31, 63, 0.12) !important;
    }
    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #001f3f;
        line-height: 1;
    }
    .stat-label {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 2px;
    }
    .info-label {
        font-size: 0.75rem;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .info-value {
        font-size: 0.9rem;
        color: #1a1a1a;
        font-weight: 500;
    }
    .section-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0, 31, 63, 0.06);
    }
    .section-title {
        font-weight: 700;
        color: #001f3f;
        font-size: 0.95rem;
    }
    .project-item {
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 0.85rem 1rem;
        transition: all 0.2s ease;
    }
    .project-item:hover {
        border-color: #001f3f;
        background: rgba(0, 31, 63, 0.01);
    }
    .task-item {
        border-left: 3px solid;
        padding: 0.75rem 1rem;
        border-radius: 0 8px 8px 0;
        background: #f8f9fa;
        transition: all 0.2s;
    }
    .task-item:hover {
        background: #f0f1f3;
    }
    .delete-zone {
        border: 2px dashed #dc3545;
        border-radius: 14px;
        padding: 1.5rem;
        background: rgba(220, 53, 69, 0.02);
    }
    .btn-action {
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.5rem 1.25rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4 px-4">

    <!-- Back Link -->
    <div class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="text-decoration-none text-muted" style="font-size: 0.85rem;">
            <i class="fas fa-arrow-left me-1"></i>Back to Manage Profiles
        </a>
    </div>

    @php
        $roleColors = [
            'admin'        => ['bg' => '#dc3545', 'light' => 'rgba(220,53,69,0.1)'],
            'customer'     => ['bg' => '#198754', 'light' => 'rgba(25,135,84,0.1)'],
            'developer'    => ['bg' => '#6f42c1', 'light' => 'rgba(111,66,193,0.1)'],
            'frontend'     => ['bg' => '#0dcaf0', 'light' => 'rgba(13,202,240,0.15)'],
            'backend'      => ['bg' => '#0d6efd', 'light' => 'rgba(13,110,253,0.1)'],
            'server_admin' => ['bg' => '#fd7e14', 'light' => 'rgba(253,126,20,0.1)'],
        ];
        $roleIcons = [
            'admin'        => 'fa-shield-halved',
            'customer'     => 'fa-briefcase',
            'developer'    => 'fa-code',
            'frontend'     => 'fa-palette',
            'backend'      => 'fa-database',
            'server_admin' => 'fa-server',
        ];
        $rc = $roleColors[$user->role->value] ?? ['bg' => '#6c757d', 'light' => '#f0f0f0'];
        $ri = $roleIcons[$user->role->value] ?? 'fa-user';
    @endphp

    <!-- Profile Header -->
    <div class="profile-header mb-4">
        <div class="d-flex align-items-center gap-4 position-relative" style="z-index: 1;">
            <div class="profile-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2">
                    <div class="profile-name">{{ $user->name }}</div>
                    @if($user->isSuperAdmin())
                    <span class="badge rounded-pill" style="background: rgba(255,215,0,0.2); color: #ffd700; font-size: 0.7rem;">
                        <i class="fas fa-crown me-1"></i>Super Admin
                    </span>
                    @endif
                    @if(!$user->is_active)
                    <span class="badge rounded-pill bg-danger" style="font-size: 0.7rem;">
                        <i class="fas fa-ban me-1"></i>Disabled
                    </span>
                    @else
                    <span class="badge rounded-pill" style="background: rgba(25,135,84,0.2); color: #4ade80; font-size: 0.7rem;">
                        <i class="fas fa-check-circle me-1"></i>Active
                    </span>
                    @endif
                </div>
                <div class="profile-email mb-2">{{ $user->email }}</div>
                <span class="role-badge-lg" style="background: {{ $rc['light'] }}; color: {{ $rc['bg'] }};">
                    <i class="fas {{ $ri }}" style="font-size: 0.75rem;"></i>
                    {{ $user->role->label() }}
                </span>
            </div>
            <div class="d-flex gap-2 flex-wrap justify-content-end">
                @if(!$user->isSuperAdmin())
                <button class="btn btn-sm btn-action text-white" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25);" data-bs-toggle="modal" data-bs-target="#editRoleModal">
                    <i class="fas fa-pen me-1"></i>Change Role
                </button>
                @if(auth()->user()->isSuperAdmin() && $user->id !== auth()->id())
                <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    @if($user->is_active)
                    <button type="submit" class="btn btn-sm btn-action" style="background: rgba(255,193,7,0.2); color: #ffc107; border: 1px solid rgba(255,193,7,0.35);" onclick="return confirm('Disable this user? They will not be able to log in.');">
                        <i class="fas fa-ban me-1"></i>Disable
                    </button>
                    @else
                    <button type="submit" class="btn btn-sm btn-action" style="background: rgba(25,135,84,0.2); color: #4ade80; border: 1px solid rgba(25,135,84,0.35);" onclick="return confirm('Enable this user account?');">
                        <i class="fas fa-check-circle me-1"></i>Enable
                    </button>
                    @endif
                </form>
                @endif
                @if($user->id !== auth()->id() && (auth()->user()->isSuperAdmin() || $user->role->value !== 'admin'))
                <button class="btn btn-sm btn-action" style="background: rgba(220,53,69,0.15); color: #ff6b6b; border: 1px solid rgba(220,53,69,0.25);" data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                    <i class="fas fa-trash-alt me-1"></i>Delete
                </button>
                @endif
                @else
                <span class="btn btn-sm btn-action text-white" style="background: rgba(255,215,0,0.15); border: 1px solid rgba(255,215,0,0.25); cursor: default;">
                    <i class="fas fa-lock me-1"></i>Protected Account
                </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card p-3" style="box-shadow: 0 2px 10px rgba(0,31,63,0.06);">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background: rgba(13,110,253,0.1); color: #0d6efd;">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $projects->count() }}</div>
                        <div class="stat-label">Projects</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card p-3" style="box-shadow: 0 2px 10px rgba(0,31,63,0.06);">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background: rgba(111,66,193,0.1); color: #6f42c1;">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $user->assigned_tasks_count ?? 0 }}</div>
                        <div class="stat-label">Assigned Tasks</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card p-3" style="box-shadow: 0 2px 10px rgba(0,31,63,0.06);">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background: rgba(25,135,84,0.1); color: #198754;">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $user->created_tasks_count ?? 0 }}</div>
                        <div class="stat-label">Created Tasks</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card p-3" style="box-shadow: 0 2px 10px rgba(0,31,63,0.06);">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background: rgba(253,126,20,0.1); color: #fd7e14;">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ $user->created_at->diffInDays(now()) }}</div>
                        <div class="stat-label">Days Active</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column: Details & Projects -->
        <div class="col-lg-5">

            <!-- User Details -->
            <div class="card section-card mb-4">
                <div class="card-body p-4">
                    <h6 class="section-title mb-3"><i class="fas fa-id-card me-2"></i>User Details</h6>
                    <div class="d-flex flex-column gap-3">
                        <div>
                            <div class="info-label">Full Name</div>
                            <div class="info-value">{{ $user->name }}</div>
                        </div>
                        <div>
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $user->email }}</div>
                        </div>
                        <div>
                            <div class="info-label">Role</div>
                            <div class="info-value">
                                <span class="badge rounded-pill" style="background: {{ $rc['bg'] }}; font-size: 0.75rem;">
                                    <i class="fas {{ $ri }} me-1"></i>{{ $user->role->label() }}
                                </span>
                            </div>
                        </div>
                        <div class="d-flex gap-4">
                            <div>
                                <div class="info-label">Joined</div>
                                <div class="info-value">{{ $user->created_at->format('M d, Y') }}</div>
                            </div>
                            <div>
                                <div class="info-label">Last Updated</div>
                                <div class="info-value">{{ $user->updated_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                        <div>
                            <div class="info-label">User ID</div>
                            <div class="info-value text-muted">#{{ $user->id }}</div>
                        </div>
                        <div>
                            <div class="info-label">Account Status</div>
                            <div class="info-value">
                                @if($user->is_active)
                                <span class="badge rounded-pill bg-success" style="font-size: 0.75rem;">
                                    <i class="fas fa-check-circle me-1"></i>Active
                                </span>
                                @else
                                <span class="badge rounded-pill bg-danger" style="font-size: 0.75rem;">
                                    <i class="fas fa-ban me-1"></i>Disabled
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Projects -->
            <div class="card section-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="section-title mb-0"><i class="fas fa-folder-open me-2"></i>Projects ({{ $projects->count() }})</h6>
                    </div>
                    @if($projects->count())
                        <div class="d-flex flex-column gap-2">
                            @foreach($projects as $project)
                            <a href="{{ route('admin.projects.show', $project) }}" class="text-decoration-none">
                                <div class="project-item d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: rgba(0,31,63,0.06); color: #001f3f; font-size: 0.8rem;">
                                            <i class="fas fa-folder"></i>
                                        </div>
                                        <div>
                                            <div class="fw-600" style="color: #001f3f; font-size: 0.85rem;">{{ $project->name }}</div>
                                            @if($project->pivot && $project->pivot->role)
                                            <small class="text-muted">{{ ucfirst(str_replace('_', ' ', $project->pivot->role)) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted" style="font-size: 0.7rem;"></i>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2" style="width: 48px; height: 48px; background: #f0f0f0;">
                                <i class="fas fa-folder-open text-muted"></i>
                            </div>
                            <p class="text-muted mb-0" style="font-size: 0.85rem;">No projects assigned</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Recent Tasks & Danger Zone -->
        <div class="col-lg-7">

            <!-- Recent Assigned Tasks -->
            <div class="card section-card mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="section-title mb-0"><i class="fas fa-tasks me-2"></i>Recent Assigned Tasks</h6>
                        <span class="badge rounded-pill" style="background: rgba(0,31,63,0.08); color: #001f3f; font-size: 0.75rem;">
                            Last 5
                        </span>
                    </div>
                    @if($recentTasks->count())
                        <div class="d-flex flex-column gap-2">
                            @foreach($recentTasks as $task)
                            @php
                                $statusColors = [
                                    'pending' => '#ffc107',
                                    'in_progress' => '#0d6efd',
                                    'completed' => '#198754',
                                    'cancelled' => '#dc3545',
                                ];
                                $sc = $statusColors[$task->status] ?? '#6c757d';
                            @endphp
                            <a href="{{ route('admin.tasks.show', $task) }}" class="text-decoration-none">
                                <div class="task-item" style="border-left-color: {{ $sc }};">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="fw-600" style="color: #1a1a1a; font-size: 0.85rem;">{{ $task->title }}</div>
                                            <div class="d-flex align-items-center gap-2 mt-1">
                                                @if($task->project)
                                                <small class="text-muted"><i class="fas fa-folder me-1"></i>{{ $task->project->name }}</small>
                                                @endif
                                                <small class="text-muted">•</small>
                                                <small style="color: {{ $sc }}; font-weight: 600;">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</small>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            @if($task->due_date)
                                            <small class="text-muted d-block"><i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2" style="width: 48px; height: 48px; background: #f0f0f0;">
                                <i class="fas fa-clipboard-list text-muted"></i>
                            </div>
                            <p class="text-muted mb-0" style="font-size: 0.85rem;">No tasks assigned yet</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Danger Zone -->
            @if(!$user->isSuperAdmin() && $user->id !== auth()->id() && (auth()->user()->isSuperAdmin() || $user->role->value !== 'admin'))
            <div class="delete-zone">
                <div class="d-flex align-items-start gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width: 42px; height: 42px; background: rgba(220,53,69,0.1);">
                        <i class="fas fa-exclamation-triangle text-danger"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="fw-700 text-danger mb-1" style="font-size: 0.9rem;">Danger Zone</h6>
                        <p class="text-muted mb-3" style="font-size: 0.8rem;">
                            Delete this user account. You'll have 10 seconds to undo this action after confirming.
                            Tasks created by this user will remain but become unassigned.
                        </p>
                        <button class="btn btn-outline-danger btn-sm btn-action" data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                            <i class="fas fa-trash-alt me-1"></i>Delete User Account
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-700" id="editRoleModalLabel" style="color: #001f3f;">
                    <i class="fas fa-user-tag me-2"></i>Change User Role
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <p class="text-muted mb-3" style="font-size: 0.85rem;">
                    Update the role for <strong>{{ $user->name }}</strong>. Current role: <span class="badge rounded-pill" style="background: {{ $rc['bg'] }};">{{ $user->role->label() }}</span>
                </p>
                <form action="{{ route('admin.users.update-role', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @php
                        $roleIconsModal = [
                            'customer'     => ['icon' => 'fa-briefcase',      'color' => '#198754'],
                            'developer'    => ['icon' => 'fa-code',           'color' => '#6f42c1'],
                            'frontend'     => ['icon' => 'fa-palette',        'color' => '#0dcaf0'],
                            'backend'      => ['icon' => 'fa-database',       'color' => '#0d6efd'],
                            'server_admin' => ['icon' => 'fa-server',         'color' => '#fd7e14'],
                            'admin'        => ['icon' => 'fa-shield-halved',  'color' => '#dc3545'],
                        ];
                    @endphp
                    <div class="d-flex flex-column gap-2 mb-4">
                        @foreach($roles as $value => $label)
                        @php $rm = $roleIconsModal[$value] ?? ['icon' => 'fa-user', 'color' => '#6c757d']; @endphp
                        <label class="d-flex align-items-center gap-3 p-2 rounded-3 role-radio-opt" style="cursor: pointer; border: 2px solid {{ $user->role->value === $value ? $rm['color'] : '#e9ecef' }}; transition: all 0.2s;">
                            <input type="radio" name="role" value="{{ $value }}" class="form-check-input m-0" {{ $user->role->value === $value ? 'checked' : '' }} style="flex-shrink: 0;">
                            <i class="fas {{ $rm['icon'] }}" style="color: {{ $rm['color'] }}; width: 18px; text-align: center;"></i>
                            <span class="fw-600" style="font-size: 0.85rem; color: #1a1a1a;">{{ $label }}</span>
                            @if($user->role->value === $value)
                            <span class="badge bg-secondary ms-auto" style="font-size: 0.65rem;">Current</span>
                            @endif
                        </label>
                        @endforeach
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary flex-fill rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary flex-fill rounded-3 fw-600">
                            <i class="fas fa-check me-1"></i>Update Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
@if(!$user->isSuperAdmin() && $user->id !== auth()->id() && (auth()->user()->isSuperAdmin() || $user->role->value !== 'admin'))
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-700 text-danger" id="deleteUserModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Delete User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-3" style="background: rgba(220,53,69,0.05); border: 1px solid rgba(220,53,69,0.15);">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: {{ $rc['light'] }}; color: {{ $rc['bg'] }}; font-weight: 700; font-size: 1.1rem; flex-shrink: 0;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-600" style="font-size: 0.9rem;">{{ $user->name }}</div>
                        <small class="text-muted">{{ $user->email }}</small>
                    </div>
                </div>
                <p class="text-muted mb-3" style="font-size: 0.85rem;">
                    Are you sure you want to delete this user? You'll have <strong class="text-warning">10 seconds to undo</strong> the action.
                </p>
                <ul class="text-muted ps-3 mb-4" style="font-size: 0.8rem;">
                    <li>The user will lose access to the system</li>
                    <li>Their project assignments will be removed</li>
                    <li>You can undo this via the toast notification</li>
                </ul>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary flex-fill rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger flex-fill rounded-3 fw-600">
                            <i class="fas fa-trash-alt me-1"></i>Yes, Delete User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    // Highlight selected role radio in modal
    document.querySelectorAll('.role-radio-opt input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.role-radio-opt').forEach(opt => {
                opt.style.borderColor = '#e9ecef';
            });
            if (this.checked) {
                this.closest('.role-radio-opt').style.borderColor = '#001f3f';
            }
        });
    });
</script>
@endpush
