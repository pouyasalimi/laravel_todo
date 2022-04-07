<?php

namespace Psli\Todo\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    public function getHidden(): array
    {
        return array_merge($this->hidden, [
            'deleted_at',
            'updated_at'
        ]);
    }
}
