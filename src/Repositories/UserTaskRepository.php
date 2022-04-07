<?php

namespace Psli\Todo\Repositories;

use Psli\Todo\Contracts\UserTaskRepositoryInterface;
use Psli\Todo\Models\BaseModel;
use Psli\Todo\Models\UserTask;

class UserTaskRepository extends BaseRepository implements UserTaskRepositoryInterface
{
    public function model(): string
    {
        return UserTask::class;
    }

    public function status(array $data, int $id): BaseModel
    {
        return $this->update($data, $id);
    }

    public function attach(int $taskId, int $labelId)
    {
        $userTask = app($this->model())->find($taskId);
        if (!$userTask->labels->contains($labelId)) {
            return $userTask->labels()->attach($labelId);
        }
    }

    public function paginate()
    {
        return app($this->model())
            ->where('user_id', request()->user->id)
            ->with(['labels' => function ($query) {
                $query->with(['tasks' => function ($query) {
                    $query->where('user_id', request()->user->id);
                }]);
            }])->paginate();
    }
}
