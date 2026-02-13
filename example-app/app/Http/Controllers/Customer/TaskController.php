<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use App\Models\TaskHistory;
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

        return redirect()->route('customer.projects.show', $project);
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
            'status' => 'to_do',
        ]);

        // Auto-assign task based on category
        $this->assignmentService->assignTask($task);

        return redirect()
            ->route('customer.projects.show', $project)
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
        abort_unless($task->created_by === auth()->id(), 403);
        $this->abortIfNotCustomerProjectMember($task->project);

        return view('customer.tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        abort_unless($task->created_by === auth()->id(), 403);
        $this->abortIfNotCustomerProjectMember($task->project);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:frontend,backend,server',
        ]);

        // Record history for changes
        if ($task->title !== $validated['title']) {
            TaskHistory::create([
                'task_id' => $task->id,
                'changed_by' => auth()->id(),
                'field_name' => 'title',
                'old_value' => $task->title,
                'new_value' => $validated['title'],
            ]);
        }

        if ($task->description !== $validated['description']) {
            TaskHistory::create([
                'task_id' => $task->id,
                'changed_by' => auth()->id(),
                'field_name' => 'description',
                'old_value' => $task->description,
                'new_value' => $validated['description'],
            ]);
        }

        if ($task->category->value !== $validated['category']) {
            TaskHistory::create([
                'task_id' => $task->id,
                'changed_by' => auth()->id(),
                'field_name' => 'category',
                'old_value' => $task->category->value,
                'new_value' => $validated['category'],
            ]);
        }

        $task->update($validated);

        return redirect()
            ->route('customer.tasks.show', $task)
            ->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        abort_unless($task->created_by === auth()->id(), 403);
        $this->abortIfNotCustomerProjectMember($task->project);

        $projectId = $task->project_id;
        
        // Record deletion in history
        TaskHistory::create([
            'task_id' => $task->id,
            'changed_by' => auth()->id(),
            'field_name' => 'status',
            'old_value' => $task->status,
            'new_value' => 'deleted',
        ]);

        $task->delete();

        return redirect()
            ->route('customer.projects.tasks.index', $projectId)
            ->with('success', 'Task deleted successfully!');
    }

    public function allTasks()
    {
        $tasks = Task::where('created_by', auth()->id())
            ->latest()
            ->get();

        return view('customer.tasks.all', compact('tasks'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query', '');
        
        $tasks = Task::where('created_by', auth()->id())
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhereHas('project', function ($projectQuery) use ($query) {
                      $projectQuery->where('name', 'like', "%{$query}%");
                  });
            })
            ->latest()
            ->get();

        return view('customer.tasks.all', compact('tasks', 'query'));
    }

    public function filter(Request $request)
    {
        $status = $request->input('status', null);
        $category = $request->input('category', null);
        
        $query = Task::where('created_by', auth()->id());
        
        if ($status) {
            $query->where('status', $status);
        }
        
        if ($category) {
            $query->where('category', $category);
        }
        
        $tasks = $query->latest()->get();

        return view('customer.tasks.all', compact('tasks', 'status', 'category'));
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

