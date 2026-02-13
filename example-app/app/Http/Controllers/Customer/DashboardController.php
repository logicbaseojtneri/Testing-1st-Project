<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $projects = $user
            ->projects()
            ->wherePivot('role', 'customer')
            ->latest('projects.created_at')
            ->get();

        $tasks = $user->createdTasks()->get();

        return view('customer.dashboard', compact('projects', 'tasks'));
    }
}
