<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;

class ProjectController extends Controller
{
    /**
     * Display projects that have tasks assigned to the developer
     */
    public function index()
    {
        $projects = Project::whereHas('tasks', function ($query) {
            $query->where('assigned_to', auth()->id());
        })
        ->withCount(['tasks as assigned_task_count' => function ($query) {
            $query->where('assigned_to', auth()->id());
        }])
        ->latest('created_at')
        ->get();

        return view('developer.projects.index', compact('projects'));
    }

    /**
     * Display a single project with its tasks assigned to the developer
     */
    public function show(Project $project)
    {
        // Check if developer has tasks in this project
        $developerHasTasks = $project->tasks()
            ->where('assigned_to', auth()->id())
            ->exists();

        if (!$developerHasTasks) {
            abort(403, 'Unauthorized to view this project');
        }

        $tasks = $project->tasks()
            ->where('assigned_to', auth()->id())
            ->with('project')
            ->latest()
            ->get();

        return view('developer.projects.show', compact('project', 'tasks'));
    }
}
