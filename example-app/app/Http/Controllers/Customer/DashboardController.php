<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $projects = auth()
            ->user()
            ->projects()
            ->wherePivot('role', 'customer')
            ->latest('projects.created_at')
            ->get();

        return view('customer.dashboard', compact('projects'));
    }
}
