<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChildTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'task_id',
        'title',
        'content',
        'status',
        'priority',
        'start_date',
        'end_date'
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
