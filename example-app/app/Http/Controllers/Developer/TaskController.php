<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskHistory;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = auth()->user()->assignedTasks()
            ->with('project')
            ->latest()
            ->get();
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

            // Create notification for customer
            Notification::create([
                'user_id' => $task->created_by,
                'title' => 'Task Status Updated',
                'message' => 'Task "' . $task->title . '" status changed to ' . ucfirst(str_replace('_', ' ', $validated['status'])),
                'type' => 'task_status_updated',
                'related_id' => $task->id,
                'related_type' => 'task',
            ]);
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
     * Update task details (link and image)
     */
    public function updateDetails(Request $request, Task $task)
    {
        $this->authorizeTaskAccess($task);

        $validated = $request->validate([
            'link' => 'nullable|url',
            'image' => 'nullable|file|image|max:5120',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($task->image_path) {
                Storage::disk('public')->delete($task->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('task-images', 'public');
        }

        // Prepare update data
        $updateData = [];
        if (isset($validated['link'])) {
            $updateData['link'] = $validated['link'];
        }
        if (isset($validated['image_path'])) {
            $updateData['image_path'] = $validated['image_path'];
        }

        $task->update($updateData);

        return redirect()
            ->route('developer.tasks.show', $task)
            ->with('success', 'Task details updated successfully!');
    }

    /**
     * Check if developer can access the task
     */
    private function authorizeTaskAccess(Task $task): void
    {
        abort_unless($task->assigned_to === auth()->id(), 403);
    }
}
