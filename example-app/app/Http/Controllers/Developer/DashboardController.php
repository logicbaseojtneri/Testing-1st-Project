<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        // Get all assigned tasks
        $assignedTasks = Task::where('assigned_to', $userId)
            ->with('project')
            ->get();
        
        // KPI Calculations
        $kpis = [
            'total' => $assignedTasks->count(),
            'in_progress' => $assignedTasks->where('status', 'in_progress')->count(),
            'completed' => $assignedTasks->where('status', 'done')->count(),
            'overdue' => $assignedTasks->filter(function ($task) {
                return $task->due_date && $task->due_date < Carbon::now() && $task->status !== 'done';
            })->count(),
        ];
        
        // Get projects with task counts
        $projects = Project::whereHas('tasks', function ($query) use ($userId) {
            $query->where('assigned_to', $userId);
        })
        ->withCount(['tasks as assigned_task_count' => function ($query) use ($userId) {
            $query->where('assigned_to', $userId);
        }])
        ->latest('created_at')
        ->get();
        
        // Get recent tasks (last 5)
        $recentTasks = Task::where('assigned_to', $userId)
            ->with('project')
            ->latest('updated_at')
            ->take(5)
            ->get();
        
        return view('developer.dashboard', compact('kpis', 'projects', 'recentTasks'));
    }
}
