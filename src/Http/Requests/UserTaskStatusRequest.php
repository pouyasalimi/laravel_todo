<?php

namespace Psli\Todo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Psli\Todo\Models\UserTask;

class UserTaskStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'exists:user_tasks'],
            'status' => ['required', 'string', 'in:'. implode(',', array_values(UserTask::STATUS))],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => (int)$this->id,
        ]);
    }
}
