<?php

namespace Psli\Todo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Psli\Todo\Contracts\UserTaskRepositoryInterface;
use Psli\Todo\Models\UserTask;

class UserTaskShowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user->id === optional(UserTask::find($this->id))->user_id;
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'exists:user_tasks'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => (int)$this->id,
        ]);
    }
}
