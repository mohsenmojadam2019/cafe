<?php

namespace App\Http\Requests\OptionRequest;

use Illuminate\Foundation\Http\FormRequest;

class OptionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'product_id' => 'required|integer|min:1',
        ];
    }
}
