<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskHistory;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = auth()->user()->assignedTasks()->get();
        return view('developer.tasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        $this->authorizeTaskAccess($task);
        return view('developer.tasks.show', compact('task'));
    }

    /**
     * Update task status
     */
    public function updateStatus(Request $request, Task $task)
    {
        $this->authorizeTaskAccess($task);

        $validated = $request->validate([
            'status' => 'required|in:to_do,in_progress,done,pending',
        ]);

        // Record the status change in history
        if ($task->status !== $validated['status']) {
            TaskHistory::create([
                'task_id' => $task->id,
                'changed_by' => auth()->id(),
                'field_name' => 'status',
                'old_value' => $task->status,
                'new_value' => $validated['status'],
            ]);

            $task->update(['status' => $validated['status']]);
        }

        return redirect()
            ->route('developer.tasks.show', $task)
            ->with('success', 'Task status updated successfully!');
    }

    /**
     * Undo the last status change
     */
    public function undoStatusChange(Task $task)
    {
        $this->authorizeTaskAccess($task);

        $lastChange = $task->history()
            ->where('field_name', 'status')
            ->orderByDesc('created_at')
            ->first();

        if (!$lastChange || !$lastChange->old_value) {
            return redirect()
                ->route('developer.tasks.show', $task)
                ->with('error', 'No previous status to undo.');
        }

        // Restore the old value
        $task->update(['status' => $lastChange->old_value]);

        // Record the undo action
        TaskHistory::create([
            'task_id' => $task->id,
            'changed_by' => auth()->id(),
            'field_name' => 'status',
            'old_value' => $lastChange->new_value,
            'new_value' => $lastChange->old_value,
        ]);

        return redirect()
            ->route('developer.tasks.show', $task)
            ->with('success', 'Status change undone successfully!');
    }

    /**
     * Check if developer can access the task
     */
    private function authorizeTaskAccess(Task $task): void
    {
        abort_unless($task->assigned_to === auth()->id(), 403);
    }
}
