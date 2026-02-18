@extends('admin.layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="container-fluid py-4 px-4">

    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-700 mb-1" style="color: #001f3f;">User Management</h4>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">Manage all registered users</p>
        </div>
        <a href="{{ route('admin.register-user.form') }}" class="btn btn-primary btn-sm rounded-3">
            <i class="fas fa-user-plus me-1"></i>Register New User
        </a>
    </div>

    <!-- Users Table Card -->
    <div class="card border-0 overflow-hidden" style="box-shadow: 0 2px 8px rgba(0, 31, 63, 0.08);">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th class="text-center pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; background: #001f3f; color: white; font-size: 0.75rem; font-weight: 700;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-decoration-none fw-600" style="color: #001f3f;">{{ $user->name }}</a>
                                    @if($user->isSuperAdmin())
                                    <span class="badge rounded-pill ms-1" style="background: rgba(255,215,0,0.15); color: #b8860b; font-size: 0.6rem;"><i class="fas fa-crown me-1"></i>Super</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td>
                            <span class="badge
                                @if($user->role->value === 'admin') bg-danger
                                @elseif(in_array($user->role->value, ['developer', 'frontend', 'backend', 'server_admin'])) bg-primary
                                @else bg-success
                                @endif
                            ">{{ $user->role->label() }}</span>
                        </td>
                        <td>
                            @if($user->is_active)
                            <span class="badge bg-success bg-opacity-10 text-success" style="font-size: 0.7rem;"><i class="fas fa-check-circle me-1"></i>Active</span>
                            @else
                            <span class="badge bg-danger bg-opacity-10 text-danger" style="font-size: 0.7rem;"><i class="fas fa-ban me-1"></i>Disabled</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="text-center pe-4">
                            <div class="btn-group gap-1" role="group">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary rounded-3" title="View Profile">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(!$user->isSuperAdmin())
                                <button onclick="editRole({{ $user->id }}, '{{ $user->role->value }}')" class="btn btn-sm btn-outline-warning rounded-3" title="Edit Role">
                                    <i class="fas fa-pen"></i>
                                </button>
                                @if(auth()->user()->isSuperAdmin() && $user->id !== auth()->id())
                                <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    @if($user->is_active)
                                    <button type="submit" class="btn btn-sm btn-outline-secondary rounded-3" title="Disable Account" onclick="return confirm('Disable this user?');">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                    @else
                                    <button type="submit" class="btn btn-sm btn-outline-success rounded-3" title="Enable Account" onclick="return confirm('Enable this user?');">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                    @endif
                                </form>
                                @endif
                                @if ($user->id !== auth()->id() && (auth()->user()->isSuperAdmin() || $user->role->value !== 'admin'))
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="rounded-circle bg-light d-inline-flex p-4 mb-3">
                                <i class="fas fa-users fa-2x text-muted"></i>
                            </div>
                            <p class="text-muted mb-0">No users found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $users->links() }}
    </div>
    @endif
</div>

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-700" id="editRoleModalLabel" style="color: #001f3f;">Update User Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRoleForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="newRole" class="form-label fw-600" style="color: #1a1a1a;">New Role</label>
                        <select id="newRole" name="role" class="form-select" style="border-radius: 8px; border-color: #e9ecef; padding: 0.6rem 1rem;" required>
                            <option value="admin">Administrator</option>
                            <option value="customer">Customer</option>
                            <option value="developer">Developer</option>
                            <option value="frontend">Frontend Developer</option>
                            <option value="backend">Backend Developer</option>
                            <option value="server_admin">Server Administrator</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary flex-fill rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary flex-fill rounded-3">Update Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function editRole(userId, currentRole) {
        document.getElementById('newRole').value = currentRole;
        document.getElementById('editRoleForm').action = `/admin/users/${userId}/role`;
        const modal = new bootstrap.Modal(document.getElementById('editRoleModal'));
        modal.show();
    }
</script>
@endpush
