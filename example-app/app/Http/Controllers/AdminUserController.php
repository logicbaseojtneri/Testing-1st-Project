<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\UserRole;
use App\Services\NotificationService;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminUserController extends Controller
{
    /**
     * Show user registration form
     */
    public function registrationForm()
    {
        if (!auth()->check() || !auth()->user()->canRegisterUsers()) {
            abort(403, 'Unauthorized. Only admins can register users.');
        }

        $roles = PermissionService::getAvailableRoles(auth()->user());

        return view('admin.register-user', ['roles' => $roles]);
    }

    /**
     * Register a new user (admin only)
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        // Check if user is admin
        if (!$user || !$user->canRegisterUsers()) {
            abort(403, 'Unauthorized. Only admins can register users.');
        }

        // Validate request
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,customer,developer,frontend,backend,server_admin'],
        ]);

        try {
            $newUser = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);

            // Notify other admins about the new user
            NotificationService::notifyAdmins(
                'New User Registered',
                auth()->user()->name . ' registered a new ' . $newUser->role->label() . ': ' . $newUser->name . '.',
                'user_registered',
                $newUser->id,
                'user',
                auth()->id()
            );

            return redirect()->route('admin.register-user.form')
                ->with('success', "User {$newUser->name} ({$newUser->role->label()}) registered successfully.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to register user: ' . $e->getMessage());
        }
    }

    /**
     * List all users (admin only)
     */
    public function index()
    {
        if (!auth()->check() || !auth()->user()->canManageUsers()) {
            abort(403, 'Unauthorized. Only admins can view all users.');
        }

        $users = User::paginate(15);

        return view('admin.users', ['users' => $users]);
    }

    /**
     * Show user details (admin only)
     */
    public function show(User $user)
    {
        if (!auth()->check() || !auth()->user()->canManageUsers()) {
            abort(403, 'Unauthorized');
        }

        $user->loadCount(['createdTasks', 'assignedTasks']);
        $projects = $user->projects()->withPivot('role')->latest('project_members.created_at')->get();
        $recentTasks = $user->assignedTasks()->with('project')->latest()->take(5)->get();
        $roles = PermissionService::getAvailableRoles(auth()->user());

        return view('admin.users.show', compact('user', 'projects', 'recentTasks', 'roles'));
    }

    /**
     * Update user role (admin only)
     */
    public function updateRole(Request $request, User $user)
    {
        $admin = auth()->user();

        if (!$admin || !$admin->canManageUsers()) {
            abort(403, 'Unauthorized. Only admins can update user roles.');
        }

        // Super admin account cannot be modified by anyone
        if ($user->isSuperAdmin()) {
            return redirect()->back()->with('error', 'The super admin account cannot be modified.');
        }

        // Only super admin can modify other admin accounts
        if ($user->role === UserRole::ADMIN && !$admin->isSuperAdmin()) {
            return redirect()->back()->with('error', 'Only the super admin can modify admin accounts.');
        }

        $validated = $request->validate([
            'role' => ['required', 'string', 'in:admin,customer,developer,frontend,backend,server_admin'],
        ]);

        try {
            $oldRole = $user->role->label();
            $user->update(['role' => $validated['role']]);

            // Notify other admins about the role change
            NotificationService::notifyAdmins(
                'User Role Changed',
                auth()->user()->name . ' changed ' . $user->name . '\'s role from ' . $oldRole . ' to ' . $user->role->label() . '.',
                'user_role_changed',
                $user->id,
                'user',
                auth()->id()
            );

            return redirect()->back()
                ->with('success', "User role updated from {$oldRole} to {$user->role->label()}.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update user role: ' . $e->getMessage());
        }
    }

    /**
     * Toggle user active status (super admin only)
     */
    public function toggleActive(User $user)
    {
        $admin = auth()->user();

        if (!$admin || !$admin->isSuperAdmin()) {
            abort(403, 'Only the super admin can disable/enable accounts.');
        }

        // Super admin account cannot be disabled
        if ($user->isSuperAdmin()) {
            return redirect()->back()->with('error', 'The super admin account cannot be disabled.');
        }

        // Prevent disabling yourself
        if ($admin->id === $user->id) {
            return redirect()->back()->with('error', 'You cannot disable your own account.');
        }

        try {
            $user->update(['is_active' => !$user->is_active]);
            $status = $user->is_active ? 'enabled' : 'disabled';

            // Notify other admins about the status change
            NotificationService::notifyAdmins(
                'User Account ' . ucfirst($status),
                auth()->user()->name . ' ' . $status . ' the account of ' . $user->name . '.',
                'user_status_changed',
                $user->id,
                'user',
                auth()->id()
            );

            return redirect()->back()
                ->with('success', "User {$user->name} has been {$status}.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update user status: ' . $e->getMessage());
        }
    }

    /**
     * Delete user (admin only)
     */
    public function destroy(User $user)
    {
        $admin = auth()->user();

        if (!$admin || !$admin->canManageUsers()) {
            abort(403, 'Unauthorized. Only admins can delete users.');
        }

        // Super admin account cannot be deleted
        if ($user->isSuperAdmin()) {
            return redirect()->back()->with('error', 'The super admin account cannot be deleted.');
        }

        // Prevent deleting yourself
        if ($admin->id === $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        // Only super admin can delete other admin accounts
        if ($user->role === UserRole::ADMIN && !$admin->isSuperAdmin()) {
            return redirect()->back()->with('error', 'Only the super admin can delete admin accounts.');
        }

        try {
            $userName = $user->name;
            $userId = $user->id;
            $user->delete();

            // Notify other admins about the deletion
            NotificationService::notifyAdmins(
                'User Deleted',
                auth()->user()->name . ' deleted user ' . $userName . '.',
                'user_deleted',
                null,
                null,
                auth()->id()
            );

            return redirect()->route('admin.users.index')
                ->with('deleted_user', ['id' => $userId, 'name' => $userName]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    /**
     * Restore a soft-deleted user (undo)
     */
    public function restore(int $id)
    {
        $admin = auth()->user();

        if (!$admin || !$admin->canManageUsers()) {
            abort(403, 'Unauthorized.');
        }

        $user = User::withTrashed()->findOrFail($id);

        if (!$user->trashed()) {
            return redirect()->back()->with('warning', 'This user is not deleted.');
        }

        $user->restore();

        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->name} has been restored.");
    }

    /**
     * Permanently delete a soft-deleted user
     */
    public function forceDelete(int $id)
    {
        $admin = auth()->user();

        if (!$admin || !$admin->canManageUsers()) {
            abort(403, 'Unauthorized.');
        }

        $user = User::withTrashed()->findOrFail($id);
        $userName = $user->name;
        $user->forceDelete();

        return redirect()->route('admin.users.index')
            ->with('success', "User {$userName} has been permanently deleted.");
    }
}
