<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()
            ->user()
            ->projects()
            ->wherePivot('role', 'customer')
            ->latest('projects.created_at')
            ->get();

        return view('customer.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('customer.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project = Project::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        // Add the current user as a customer member of this project
        auth()->user()->projects()->attach($project->id, [
            'role' => 'customer',
        ]);

        return redirect()
            ->route('customer.projects.show', $project)
            ->with('success', 'Project created successfully!');
    }

    public function show(Project $project)
    {
        $isCustomerMember = $project
            ->customers()
            ->where('users.id', auth()->id())
            ->exists();

        abort_unless($isCustomerMember, 403);

        $tasks = $project
            ->tasks()
            ->where('created_by', auth()->id())
            ->latest()
            ->get();

        return view('customer.projects.show', compact('project', 'tasks'));
    }
}

