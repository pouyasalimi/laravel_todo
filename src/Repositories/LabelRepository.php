<?php

namespace Psli\Todo\Repositories;

use Psli\Todo\Contracts\LabelRepositoryInterface;
use Psli\Todo\Models\Label;

class LabelRepository extends BaseRepository implements LabelRepositoryInterface
{

    public function model(): string
    {
        return Label::class;
    }

    public function paginate()
    {
        return app($this->model())
            ->with(['tasks' => function ($query) {
                $query->where('user_id', request()->user->id);
            }])->paginate();
    }
}
