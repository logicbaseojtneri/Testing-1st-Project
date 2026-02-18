<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\TaskController as AdminTaskController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\ProjectController as CustomerProjectController;
use App\Http\Controllers\Customer\TaskController as CustomerTaskController;
use App\Http\Controllers\Developer\DashboardController as DeveloperDashboardController;
use App\Http\Controllers\Developer\TaskController as DeveloperTaskController;
use App\Http\Controllers\Developer\ProjectController as DeveloperProjectController;

Route::get('/', function () {
    return view('welcome');
});

// Public Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Public registration is disabled. Admins should create accounts via the admin UI.
Route::match(['get', 'post'], '/register', function () {
    abort(403, 'Registration is disabled. Contact an administrator.');
})->name('register');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Generic dashboard route - redirects based on user role
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if (!$user) {
        return redirect()->route('login');
    }
    
    return match($user->role) {
        \App\Enums\UserRole::ADMIN => redirect()->route('admin.dashboard'),
        \App\Enums\UserRole::CUSTOMER => redirect()->route('customer.dashboard'),
        default => redirect()->route('developer.dashboard'),
    };
})->middleware('auth')->name('dashboard');

// Profile routes (for authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Notification routes (for authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/api/notifications/unread', [NotificationController::class, 'unread'])->name('notifications.unread');
    Route::get('/api/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/api/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/api/notifications/{notification}/unread', [NotificationController::class, 'markAsUnread'])->name('notifications.unread');
    Route::post('/api/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
    Route::delete('/api/notifications/all', [NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');
    Route::delete('/api/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});

// Customer routes
Route::middleware(['auth', 'customer'])->prefix('customer')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
    Route::get('/notifications', [NotificationController::class, 'page'])->name('customer.notifications');

    // All tasks, search, and filter (must be before resource routes to avoid conflict)
    Route::get('/tasks/all', [CustomerTaskController::class, 'allTasks'])->name('customer.tasks.all');
    Route::get('/tasks/search', [CustomerTaskController::class, 'search'])->name('customer.tasks.search');
    Route::get('/tasks/filter', [CustomerTaskController::class, 'filter'])->name('customer.tasks.filter');

    // Projects (customers create projects, then create tasks inside projects)
    Route::resource('/projects', CustomerProjectController::class, ['as' => 'customer']);

    // Nested tasks under a project (shallow routes for show/edit/update/destroy)
    Route::resource('/projects.tasks', CustomerTaskController::class, ['as' => 'customer'])
        ->shallow();
});

// Developer routes
Route::middleware(['auth', 'developer'])->prefix('developer')->group(function () {
    Route::get('/dashboard', [DeveloperDashboardController::class, 'index'])->name('developer.dashboard');
    Route::get('/notifications', [NotificationController::class, 'page'])->name('developer.notifications');
    
    // Projects (read-only - only projects with assigned tasks)
    Route::get('/projects', [DeveloperProjectController::class, 'index'])->name('developer.projects.index');
    Route::get('/projects/{project}', [DeveloperProjectController::class, 'show'])->name('developer.projects.show');
    
    // Tasks
    Route::get('/tasks', [DeveloperTaskController::class, 'index'])->name('developer.tasks.index');
    Route::get('/tasks/{task}', [DeveloperTaskController::class, 'show'])->name('developer.tasks.show');
    Route::put('/tasks/{task}/status', [DeveloperTaskController::class, 'updateStatus'])->name('developer.tasks.updateStatus');
    Route::put('/tasks/{task}/details', [DeveloperTaskController::class, 'updateDetails'])->name('developer.tasks.updateDetails');
    Route::post('/tasks/{task}/undo', [DeveloperTaskController::class, 'undoStatusChange'])->name('developer.tasks.undo');
});

// Admin routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Admin dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // User registration and management (admin only)
    Route::get('/register-user', [AdminUserController::class, 'registrationForm'])
        ->name('admin.register-user.form');
    Route::post('/register-user', [AdminUserController::class, 'store'])
        ->name('admin.register-user.store');
    
    Route::resource('/users', AdminUserController::class)
        ->only(['index', 'show', 'destroy'])
        ->names([
            'index' => 'admin.users.index',
            'show' => 'admin.users.show',
            'destroy' => 'admin.users.destroy',
        ]);
    
    Route::put('/users/{user}/role', [AdminUserController::class, 'updateRole'])
        ->name('admin.users.update-role');
    
    Route::put('/users/{user}/toggle-active', [AdminUserController::class, 'toggleActive'])
        ->name('admin.users.toggle-active');
    
    Route::post('/users/{id}/restore', [AdminUserController::class, 'restore'])
        ->name('admin.users.restore');
    Route::delete('/users/{id}/force-delete', [AdminUserController::class, 'forceDelete'])
        ->name('admin.users.force-delete');

    // Admin Projects management
    Route::get('/projects', [AdminProjectController::class, 'index'])->name('admin.projects.index');
    Route::get('/projects/trash', [AdminProjectController::class, 'trash'])->name('admin.trash');
    Route::get('/projects/{project}/edit', [AdminProjectController::class, 'edit'])->name('admin.projects.edit');
    Route::put('/projects/{project}', [AdminProjectController::class, 'update'])->name('admin.projects.update');
    Route::post('/projects/{project}/auto-assign', [AdminProjectController::class, 'autoAssign'])->name('admin.projects.auto-assign');
    Route::post('/projects/{project}/assign-role', [AdminProjectController::class, 'assignRole'])->name('admin.projects.assign-role');
    Route::delete('/projects/{project}', [AdminProjectController::class, 'destroy'])->name('admin.projects.destroy');
    Route::post('/projects/{id}/restore', [AdminProjectController::class, 'restore'])->name('admin.projects.restore');
    Route::delete('/projects/{id}/force-delete', [AdminProjectController::class, 'forceDelete'])->name('admin.projects.force-delete');
    Route::get('/projects/{project}', [AdminProjectController::class, 'show'])->name('admin.projects.show');

    // Admin Tasks management
    Route::get('/tasks', [AdminTaskController::class, 'index'])->name('admin.tasks.index');
    Route::get('/tasks/{task}/edit', [AdminTaskController::class, 'edit'])->name('admin.tasks.edit');
    Route::put('/tasks/{task}', [AdminTaskController::class, 'update'])->name('admin.tasks.update');
    Route::delete('/tasks/{task}', [AdminTaskController::class, 'destroy'])->name('admin.tasks.destroy');
    Route::post('/tasks/{id}/restore', [AdminTaskController::class, 'restore'])->name('admin.tasks.restore');
    Route::delete('/tasks/{id}/force-delete', [AdminTaskController::class, 'forceDelete'])->name('admin.tasks.force-delete');
    Route::get('/tasks/{task}', [AdminTaskController::class, 'show'])->name('admin.tasks.show');

    // Admin Notifications page
    Route::get('/notifications', [NotificationController::class, 'page'])->name('admin.notifications');
});

// Old commented routes
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::resource('/admin/projects', Admin\ProjectController::class);
//     Route::resource('/admin/users', Admin\UserController::class);
//     Route::post('/admin/assign-developer', [Admin\AssignmentController::class, 'store']);
// });

