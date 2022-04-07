<?php

namespace Psli\Todo\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Psli\Todo\Models\UserTask;

trait HasTasks
{
    public function tasks(): HasMany
    {
        return $this->hasMany(UserTask::class);
    }
}
