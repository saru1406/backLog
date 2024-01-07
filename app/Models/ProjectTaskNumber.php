<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ProjectTaskNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'task_number',
        'taskable_id',
        'taskable_type'
    ];

    public function taskable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * プロジェクトに紐づけ
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->BelongsTo(Project::class);
    }
}
