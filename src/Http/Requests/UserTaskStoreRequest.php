<?php

namespace Psli\Todo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserTaskStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:50'],
            'description' => ['sometimes', 'string', 'max:200'],
        ];
    }
}
