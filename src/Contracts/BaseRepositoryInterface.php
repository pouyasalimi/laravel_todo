<?php

namespace Psli\Todo\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Psli\Todo\Models\BaseModel;

interface BaseRepositoryInterface
{
    public function paginate();

    public function find(int $id, array $columns = ['*']): ?BaseModel;

    public function create(array $data): BaseModel;

    public function update(array $data, int $id): BaseModel;

    public function findOrFail(int $id = null, array $columns = ['*']): BaseModel;

}
