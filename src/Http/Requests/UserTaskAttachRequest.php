<?php

namespace Psli\Todo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserTaskAttachRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'task_id' => ['required', 'exists:user_tasks,id'],
            'label_id' => ['required', 'exists:labels,id'],
        ];
    }
}
