<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Enums\UserRole;
use App\Services\ProjectAssignmentService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        $projects = Project::with(['frontendDeveloper', 'backendDeveloper', 'serverAdmin'])
            ->withCount('tasks')
            ->latest()
            ->paginate(15);

        return view('admin.projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        $project->load(['tasks.assignee', 'frontendDeveloper', 'backendDeveloper', 'serverAdmin', 'members']);

        $frontendDevs = User::where('role', UserRole::FRONTEND->value)->get();
        $backendDevs = User::where('role', UserRole::BACKEND->value)->get();
        $serverAdmins = User::where('role', UserRole::SERVER_ADMIN->value)->get();

        return view('admin.projects.show', compact('project', 'frontendDevs', 'backendDevs', 'serverAdmins'));
    }

    public function edit(Project $project)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        $frontendDevs = User::where('role', UserRole::FRONTEND->value)->get();
        $backendDevs = User::where('role', UserRole::BACKEND->value)->get();
        $serverAdmins = User::where('role', UserRole::SERVER_ADMIN->value)->get();

        return view('admin.projects.edit', compact('project', 'frontendDevs', 'backendDevs', 'serverAdmins'));
    }

    public function update(Request $request, Project $project)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'frontend_dev_id' => 'nullable|exists:users,id',
            'backend_dev_id' => 'nullable|exists:users,id',
            'server_admin_id' => 'nullable|exists:users,id',
        ]);

        $project->update($validated);

        // Sync project members after assignment change
        $service = new ProjectAssignmentService();
        $service->syncProjectMembersPublic($project);

        return redirect()->route('admin.projects.show', $project)
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Auto-assign all developer roles on a project (least-loaded selection)
     */
    public function autoAssign(Project $project)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        $service = new ProjectAssignmentService();
        $assigned = $service->assignDevelopersToProject($project);

        $names = [];
        foreach ($assigned as $role => $user) {
            $names[] = ucfirst(str_replace('_', ' ', $role)) . ': ' . $user->name;
        }

        $msg = !empty($names)
            ? 'Auto-assigned: ' . implode(', ', $names)
            : 'No developers available for auto-assignment.';

        return redirect()->route('admin.projects.show', $project)->with('success', $msg);
    }

    /**
     * Quick-assign a single role slot on a project
     */
    public function assignRole(Request $request, Project $project)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        $validated = $request->validate([
            'role_slot' => 'required|in:frontend_dev_id,backend_dev_id,server_admin_id',
            'user_id' => 'nullable|exists:users,id',
            'auto' => 'nullable|boolean',
        ]);

        $roleSlot = $validated['role_slot'];

        if (!empty($validated['auto'])) {
            $service = new ProjectAssignmentService();
            $dev = $service->autoAssignRole($project, $roleSlot);
            $msg = $dev
                ? ucfirst(str_replace('_', ' ', str_replace('_id', '', $roleSlot))) . ' auto-assigned to ' . $dev->name
                : 'No available developer found for auto-assignment.';
        } else {
            $project->update([$roleSlot => $validated['user_id'] ?: null]);
            $service = new ProjectAssignmentService();
            $service->syncProjectMembersPublic($project);

            if ($validated['user_id']) {
                $user = User::find($validated['user_id']);
                $msg = ucfirst(str_replace('_', ' ', str_replace('_id', '', $roleSlot))) . ' assigned to ' . $user->name;
            } else {
                $msg = ucfirst(str_replace('_', ' ', str_replace('_id', '', $roleSlot))) . ' unassigned.';
            }
        }

        return redirect()->route('admin.projects.show', $project)->with('success', $msg);
    }

    public function destroy(Project $project)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project "' . $project->name . '" has been deleted. You can recover it from the Trash.');
    }

    public function trash()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        $projects = Project::onlyTrashed()
            ->with(['frontendDeveloper', 'backendDeveloper', 'serverAdmin'])
            ->withCount('tasks')
            ->latest('deleted_at')
            ->paginate(15);

        $tasks = \App\Models\Task::onlyTrashed()
            ->with(['project', 'creator', 'assignee'])
            ->latest('deleted_at')
            ->paginate(15);

        return view('admin.trash.index', compact('projects', 'tasks'));
    }

    public function restore($id)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        $project = Project::onlyTrashed()->findOrFail($id);
        $project->restore();

        return redirect()->back()
            ->with('success', 'Project "' . $project->name . '" has been restored.');
    }

    public function forceDelete($id)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        $project = Project::onlyTrashed()->findOrFail($id);
        $name = $project->name;
        $project->forceDelete();

        return redirect()->back()
            ->with('success', 'Project "' . $name . '" has been permanently deleted.');
    }
}
