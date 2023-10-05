<?php

namespace App\Http\Requests\OrderRequest;

use App\Enum\Services\StatusOrder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderStatusRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'status' => ['required', 'string', Rule::in(StatusOrder::toArray())],
        ];
    }

    public function messages()
    {
        return [
            'status' => 'وضعیت سفارش معتبر نیست.',
        ];
    }
}
