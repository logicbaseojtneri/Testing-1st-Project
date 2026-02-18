<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Enums\UserRole;

class DashboardController extends Controller
{
    public function index()
    {
        // Check if user is admin
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        // Get developer counts by role
        $frontendCount = User::where('role', UserRole::FRONTEND)->count();
        $backendCount = User::where('role', UserRole::BACKEND)->count();
        $serverAdminCount = User::where('role', UserRole::SERVER_ADMIN)->count();
        $developerCount = User::where('role', UserRole::DEVELOPER)->count();
        
        $totalDevelopers = $frontendCount + $backendCount + $serverAdminCount + $developerCount;

        // Get other counts
        $customerCount = User::where('role', UserRole::CUSTOMER)->count();
        $adminCount = User::where('role', UserRole::ADMIN)->count();
        $totalUsers = User::count();

        // Project stats
        $totalProjects = Project::count();
        // Note: Projects table doesn't have status column, showing total only
        $activeProjects = 0;
        $completedProjects = 0;
        $pendingProjects = 0;

        // Task stats
        $totalTasks = Task::count();
        $toDoTasks = Task::where('status', 'to_do')->count();
        $inProgressTasks = Task::where('status', 'in_progress')->count();
        $doneTasks = Task::where('status', 'done')->count();
        $reviewTasks = Task::where('status', 'review')->count();

        // Get actual lists for expandable cards (limit to recent 10)
        $usersList = User::latest()->take(10)->get();
        $projectsList = Project::latest()->take(10)->get();
        $tasksList = Task::with('project')->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'frontendCount',
            'backendCount',
            'serverAdminCount',
            'developerCount',
            'totalDevelopers',
            'customerCount',
            'adminCount',
            'totalUsers',
            'totalProjects',
            'activeProjects',
            'completedProjects',
            'pendingProjects',
            'totalTasks',
            'toDoTasks',
            'inProgressTasks',
            'doneTasks',
            'reviewTasks',
            'usersList',
            'projectsList',
            'tasksList'
        ));
    }
}
