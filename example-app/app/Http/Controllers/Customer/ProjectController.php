<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\ProjectAssignmentService;
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

        // Automatically assign developers to the project
        $assignmentService = new ProjectAssignmentService();
        $assignmentService->assignDevelopersToProject($project);

        return redirect()
            ->route('customer.projects.show', $project)
            ->with('success', 'Project created successfully!');
    }

    public function show(Project $project)
    {
        $this->ensureCustomerMember($project);

        $tasks = $project
            ->tasks()
            ->where('created_by', auth()->id())
            ->latest()
            ->get();

        return view('customer.projects.show', compact('project', 'tasks'));
    }

    public function edit(Project $project)
    {
        $this->ensureCustomerMember($project);
        return view('customer.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $this->ensureCustomerMember($project);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('customer.projects.show', $project)
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $this->ensureCustomerMember($project);
        $project->delete();
        return redirect()
            ->route('customer.dashboard')
            ->with('success', 'Project deleted.');
    }

    private function ensureCustomerMember(Project $project): void
    {
        $isCustomerMember = $project
            ->customers()
            ->where('users.id', auth()->id())
            ->exists();
        abort_unless($isCustomerMember, 403);
    }
}

