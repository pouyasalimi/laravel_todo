<?php

namespace Psli\Todo\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LabelApiResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "label" => $this->label,
            "total_tasks" => $this->tasks->count()
        ];
    }
}
