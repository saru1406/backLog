<?php

declare(strict_types=1);

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
        'creator_id',
        'type_id',
        'title',
        'content',
        'status',
        'priority',
        'start_date',
        'end_date',
        'branch_name',
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
     * 子タスクに紐づけ
     *
     * @return HasMany
     */
    public function childTasks(): HasMany
    {
        return $this->hasMany(ChildTask::class);
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
     * ユーザーに紐づけ
     *
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
