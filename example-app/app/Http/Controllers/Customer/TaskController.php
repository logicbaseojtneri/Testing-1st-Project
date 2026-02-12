<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use App\Services\TaskAssignmentService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $assignmentService;

    public function __construct(TaskAssignmentService $assignmentService)
    {
        $this->assignmentService = $assignmentService;
    }

    public function index(Project $project)
    {
        $this->abortIfNotCustomerProjectMember($project);

        $tasks = $project
            ->tasks()
            ->where('created_by', auth()->id())
            ->latest()
            ->get();

        return view('customer.tasks.index', compact('project', 'tasks'));
    }

    public function create(Project $project)
    {
        $this->abortIfNotCustomerProjectMember($project);

        return view('customer.tasks.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        $this->abortIfNotCustomerProjectMember($project);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:frontend,backend,server',
        ]);

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'project_id' => $project->id,
            'created_by' => auth()->id(),
            'status' => 'pending',
        ]);

        // Auto-assign task based on category
        $this->assignmentService->assignTask($task);

        return redirect()
            ->route('customer.projects.tasks.index', $project)
            ->with('success', 'Task created successfully and assigned to developer!');
    }

    public function show(Task $task)
    {
        abort_unless($task->created_by === auth()->id(), 403);
        $this->abortIfNotCustomerProjectMember($task->project);

        return view('customer.tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        abort(404);
    }

    public function update(Request $request, Task $task)
    {
        abort(404);
    }

    public function destroy(Task $task)
    {
        abort(404);
    }

    private function abortIfNotCustomerProjectMember(Project $project): void
    {
        $isCustomerMember = $project
            ->customers()
            ->where('users.id', auth()->id())
            ->exists();

        abort_unless($isCustomerMember, 403);
    }
}

