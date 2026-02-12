<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'frontend_dev_id',
        'backend_dev_id',
        'server_admin_id',
    ];

    /**
     * Get the frontend developer assigned to this project
     */
    public function frontendDeveloper(): BelongsTo
    {
        return $this->belongsTo(User::class, 'frontend_dev_id');
    }

    /**
     * Get the backend developer assigned to this project
     */
    public function backendDeveloper(): BelongsTo
    {
        return $this->belongsTo(User::class, 'backend_dev_id');
    }

    /**
     * Get the server administrator assigned to this project
     */
    public function serverAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'server_admin_id');
    }

    /**
     * Get all tasks for this project
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get all members of this project
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_members')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Get all customers for this project
     */
    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_members')
            ->wherePivot('role', 'customer')
            ->withTimestamps();
    }
}
