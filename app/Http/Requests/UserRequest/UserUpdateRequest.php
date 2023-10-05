<?php

namespace App\Http\Requests\UserRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->route('id');

        return [
            'name' => 'required|max:50',
            'email' => [
                'required',
                'max:100',
                'email',
                Rule::unique('users')->ignore($userId),
            ],
            'password' => 'nullable|min:6|confirmed',
            'roles' => 'array',

        ];
    }
}
