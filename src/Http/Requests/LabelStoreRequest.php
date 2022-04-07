<?php

namespace Psli\Todo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LabelStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'label' => ['required', 'string', 'max:20', 'unique:labels,label'],
        ];
    }
}
