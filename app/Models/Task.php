<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'type_id',
        'title',
        'content',
        'status',
        'priority',
        'start_date',
        'end_date',
        'branch_name',
    ];

    public function user()
    {
        return $this->BelongsTo(User::class);
    }

    public function project()
    {
        return $this->BelongsTo(Project::class);
    }

    public function childTasks(): HasMany
    {
        return $this->hasMany(ChildTask::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }
}
