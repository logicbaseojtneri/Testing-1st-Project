<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = auth()->user()->assignedTasks()->get();
        return view('developer.tasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        return view('developer.tasks.show', compact('task'));
    }
}
