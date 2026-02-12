<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\ProjectController as CustomerProjectController;
use App\Http\Controllers\Customer\TaskController as CustomerTaskController;
use App\Http\Controllers\Developer\DashboardController as DeveloperDashboardController;
use App\Http\Controllers\Developer\TaskController as DeveloperTaskController;

Route::get('/', function () {
    return view('welcome');
});

// Public Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Customer routes
Route::middleware(['auth', 'customer'])->prefix('customer')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');

    // Projects (customers create projects, then create tasks inside projects)
    Route::resource('/projects', CustomerProjectController::class, ['as' => 'customer'])
        ->only(['index', 'create', 'store', 'show']);

    // Nested tasks under a project (shallow routes for show/edit/update/destroy)
    Route::resource('/projects.tasks', CustomerTaskController::class, ['as' => 'customer'])
        ->shallow();
});

// Developer routes
Route::middleware(['auth', 'developer'])->prefix('developer')->group(function () {
    Route::get('/dashboard', [DeveloperDashboardController::class, 'index'])->name('developer.dashboard');
    Route::get('/tasks', [DeveloperTaskController::class, 'index'])->name('developer.tasks.index');
    Route::get('/tasks/{task}', [DeveloperTaskController::class, 'show'])->name('developer.tasks.show');
});


// Developer routes
Route::middleware(['auth', 'developer'])->group(function () {
    Route::get('/developer/dashboard', [Developer\DashboardController::class, 'index']);
    Route::get('/developer/tasks', [Developer\TaskController::class, 'index']);
    Route::get('/developer/tasks/{task}', [Developer\TaskController::class, 'show']);
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('/admin/projects', Admin\ProjectController::class);
    Route::resource('/admin/users', Admin\UserController::class);
    Route::post('/admin/assign-developer', [Admin\AssignmentController::class, 'store']);
});

