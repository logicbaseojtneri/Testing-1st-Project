<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\NotificationController;
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
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Notification routes (for authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/api/notifications/unread', [NotificationController::class, 'unread'])->name('notifications.unread');
    Route::get('/api/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/api/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/api/notifications/{notification}/unread', [NotificationController::class, 'markAsUnread'])->name('notifications.unread');
    Route::post('/api/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
    Route::delete('/api/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});

// Customer routes
Route::middleware(['auth', 'customer'])->prefix('customer')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');

    // Projects (customers create projects, then create tasks inside projects)
    Route::resource('/projects', CustomerProjectController::class, ['as' => 'customer']);

    // Nested tasks under a project (shallow routes for show/edit/update/destroy)
    Route::resource('/projects.tasks', CustomerTaskController::class, ['as' => 'customer'])
        ->shallow();
    
    // All tasks, search, and filter
    Route::get('/tasks/all', [CustomerTaskController::class, 'allTasks'])->name('customer.tasks.all');
    Route::get('/tasks/search', [CustomerTaskController::class, 'search'])->name('customer.tasks.search');
    Route::get('/tasks/filter', [CustomerTaskController::class, 'filter'])->name('customer.tasks.filter');
});

// Developer routes
Route::middleware(['auth', 'developer'])->prefix('developer')->group(function () {
    Route::get('/dashboard', [DeveloperDashboardController::class, 'index'])->name('developer.dashboard');
    
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
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::resource('/admin/projects', Admin\ProjectController::class);
//     Route::resource('/admin/users', Admin\UserController::class);
//     Route::post('/admin/assign-developer', [Admin\AssignmentController::class, 'store']);
// });

