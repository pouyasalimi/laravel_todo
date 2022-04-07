<?php

namespace Psli\Todo\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Psli\Todo\Models\UserTask;

class Status implements CastsAttributes
{

    public function get($model, $key, $value, $attributes)
    {
        if(is_null($value)) {
            $value = array_flip(UserTask::STATUS)['open'];
        }

        return UserTask::STATUS[$value];
    }

    public function set($model, $key, $value, $attributes)
    {
        return array_flip(UserTask::STATUS)[$value];
    }
}
