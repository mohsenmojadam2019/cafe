<?php

namespace App\Http\Requests\OptionRequest;

use Illuminate\Foundation\Http\FormRequest;

class OptionArrayRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'options' => 'required|array',
            'options.*.name' => 'required|string|max:255',
            'options.*.price' => 'required|numeric',
        ];
    }
}
