<?php

namespace Psli\Todo\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Label extends BaseModel
{
    protected $fillable = [
        'label',
    ];

    protected $casts = [
        'id' => 'integer',
        'label' => 'string',
    ];

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(UserTask::class)->using(LabelTask::class)
            ->withTimestamps();
    }
}
