<?php

namespace Psli\Todo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LabelUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'label' => ['required', 'string', 'max:20', 'unique:labels,label'],
        ];
    }
}
