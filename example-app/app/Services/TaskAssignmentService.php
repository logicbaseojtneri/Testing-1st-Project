<?php

namespace App\Services;

use App\Enums\TaskCategory;
use App\Models\Task;

class TaskAssignmentService
{
    /**
     * Automatically assign a task based on its category
     */
    public function assignTask(Task $task): void
    {
        $assignee = match($task->category) {
            TaskCategory::FRONTEND => $task->project->frontendDeveloper,
            TaskCategory::BACKEND => $task->project->backendDeveloper,
            TaskCategory::SERVER => $task->project->serverAdmin,
        };

        if ($assignee) {
            $task->update(['assigned_to' => $assignee->id]);
        }
    }
}
