<?php

namespace Psli\Todo\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User;
use Psli\Todo\Casts\Status;

class UserTask extends BaseModel
{
    protected $fillable = [
        'title', 'description', 'status', 'user_id'
    ];

    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'description' => 'string',
        'status'=> Status::class,
        'user_id' => 'integer',
    ];

    public const STATUS = [
        0 => 'close',
        1 => 'open'
    ];

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class)->using(LabelTask::class)
            ->withTimestamps();
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
