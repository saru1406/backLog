<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ChildTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'creator_id',
        'project_id',
        'task_id',
        'type_id',
        'title',
        'content',
        'status',
        'priority',
        'start_date',
        'end_date'
    ];

    /**
     * ユーザーに紐づけ
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
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

    /**
     * タスクに紐づけ
     *
     * @return BelongsTo
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * ユーザーに紐づけ
     *
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    /**
     * 種別に紐づけ
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * タスクに関連するプロジェクトタスク番号を取得
     *
     * @return MorphOne
     */
    public function projectTaskNumber(): MorphOne
    {
        return $this->morphOne(ProjectTaskNumber::class, 'taskable');
    }
}
