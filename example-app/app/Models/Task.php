<?php

namespace App\Models;

use App\Enums\TaskCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'category',
        'status',
        'project_id',
        'created_by',
        'assigned_to',
        'due_date',
        'link',
        'image_path',
        'deadline',
    ];

    protected function casts(): array
    {
        return [
            'category' => TaskCategory::class,
            'due_date' => 'datetime',
            'deadline' => 'datetime',
        ];
    }

    /**
     * Get the customer who created this task
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the developer assigned to this task
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the project this task belongs to
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the history of this task
     */
    public function history(): HasMany
    {
        return $this->hasMany(TaskHistory::class)->orderByDesc('created_at');
    }
}
