<?php

namespace Psli\Todo\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Psli\Todo\Contracts\BaseRepositoryInterface;
use Psli\Todo\Exceptions\ModelException;
use Psli\Todo\Models\BaseModel;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected BaseModel $model;

    public function __construct()
    {
        $this->makeModel();
    }

    public function paginate()
    {
        return $this->model->paginate();
    }

    public function find(int $id, array $columns = ['*']): ?BaseModel
    {
        return $this->model->find($id, $columns);
    }

    public function create(array $data): BaseModel
    {
        return $this->model->create($data);
    }

    public function update(array $data, int $id): BaseModel
    {
        $model = $this->findOrFail($id);

        $model->fill($data);
        if ($model->isDirty()) {
            $model->update();
        }

        return $model;
    }

    public function findOrFail(int $id = null, array $columns = ['*']): BaseModel
    {
        return $this->model->findOrFail($id, $columns);
    }

    private function makeModel(): void
    {
        $model = app($this->model());
        if (!$model instanceof BaseModel) {
            throw new ModelException("Class " . get_class($model) . " must be an instance of BaseModel");
        }
        $this->model = $model;
    }

    abstract public function model(): string;
}
