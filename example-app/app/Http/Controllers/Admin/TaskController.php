<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Enums\TaskCategory;
use App\Enums\UserRole;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        $tasks = Task::with(['project', 'creator', 'assignee'])
            ->latest()
            ->paginate(15);

        return view('admin.tasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        $task->load(['project', 'creator', 'assignee', 'history']);

        return view('admin.tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        $projects = Project::all();
        $developers = User::whereIn('role', [
            UserRole::FRONTEND->value,
            UserRole::BACKEND->value,
            UserRole::SERVER_ADMIN->value,
            UserRole::DEVELOPER->value,
        ])->get();
        $categories = TaskCategory::cases();
        $statuses = ['to_do', 'in_progress', 'review', 'done'];

        return view('admin.tasks.edit', compact('task', 'projects', 'developers', 'categories', 'statuses'));
    }

    public function update(Request $request, Task $task)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'status' => 'required|string|in:to_do,in_progress,review,done',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'deadline' => 'nullable|date',
        ]);

        $task->update($validated);

        return redirect()->route('admin.tasks.show', $task)
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        $task->delete(); // Soft delete

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task "' . $task->title . '" has been deleted. You can recover it from the Trash.');
    }

    public function restore($id)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        $task = Task::onlyTrashed()->findOrFail($id);
        $task->restore();

        return redirect()->back()
            ->with('success', 'Task "' . $task->title . '" has been restored.');
    }

    public function forceDelete($id)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        $task = Task::onlyTrashed()->findOrFail($id);
        $title = $task->title;
        $task->forceDelete();

        return redirect()->back()
            ->with('success', 'Task "' . $title . '" has been permanently deleted.');
    }
}
