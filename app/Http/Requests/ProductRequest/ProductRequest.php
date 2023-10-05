<?php

namespace App\Http\Requests\ProductRequest;

use App\Enum\Services\StatusProduct;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|integer|min:1',
            'status' => [
                'required',
                Rule::in([
                    StatusProduct::available,
                    StatusProduct::outOfStock,
                ]),
            ],
        ];
    }
}
