<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'status',
        'priority',
        'manager',
        'start_date',
        'end_date'
    ];

    public function user()
    {
        return $this->BelongsTo(User::class);
    }
}
