<?php

namespace Psli\Todo\Contracts;

use Psli\Todo\Models\BaseModel;

interface UserTaskRepositoryInterface extends BaseRepositoryInterface
{
    public function status(array $data, int $id): BaseModel;

    public function attach(int $taskId, int $labelId);
}
