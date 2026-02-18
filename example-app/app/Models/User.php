<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get tasks created by this customer
     */
    public function createdTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    /**
     * Get tasks assigned to this developer
     */
    public function assignedTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    /**
     * Get all projects this user is assigned to
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_members')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Check if user is a customer
     */
    public function isCustomer(): bool
    {
        return $this->role === UserRole::CUSTOMER;
    }

    /**
     * Check if user is a developer
     */
    public function isDeveloper(): bool
    {
        return in_array($this->role, UserRole::developerRoles());
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    /**
     * Check if user is the super admin (admin@example.com)
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === UserRole::ADMIN && $this->email === 'admin@example.com';
    }

    /**
     * Check if user account is active
     */
    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    /**
     * Check if user can register other users
     */
    public function canRegisterUsers(): bool
    {
        return $this->role->canRegisterUsers();
    }

    /**
     * Check if user can manage users
     */
    public function canManageUsers(): bool
    {
        return $this->role->canManageUsers();
    }

    /**
     * Check if user can create tasks
     */
    public function canCreateTask(): bool
    {
        return $this->role->canCreateTask();
    }

    /**
     * Check if user can create projects
     */
    public function canCreateProject(): bool
    {
        return $this->role->canCreateProject();
    }

    /**
     * Check if user can delete project
     */
    public function canDeleteProject(): bool
    {
        return $this->role->canDeleteProject();
    }

    /**
     * Check if user can delete task
     */
    public function canDeleteTask(): bool
    {
        return $this->role->canDeleteTask();
    }

    /**
     * Get all notifications for this user
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class)->latest();
    }

    /**
     * Get unread notifications for this user
     */
    public function unreadNotifications(): HasMany
    {
        return $this->notifications()->whereNull('read_at');
    }
}

