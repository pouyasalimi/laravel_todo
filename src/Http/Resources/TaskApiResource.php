<?php

namespace Psli\Todo\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskApiResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "labels" => LabelApiResource::collection($this->labels)
        ];
    }
}
