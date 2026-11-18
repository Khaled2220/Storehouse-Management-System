<?php

namespace App\Http\Requests;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('user'));
    }

    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'full_name' => ['required', 'string', 'max:250'],
            'email' => ['required', 'string', 'email', 'max:225', Rule::unique('users', 'email')->ignore($user)],
            'password' => ['nullable', 'string', 'min:7'],
            'user_type' => ['required', Rule::in([
                UserType::ADMIN->value,
                UserType::USER->value,
            ]),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'This Email already exists. Please Choose another Email.',
        ];
    }
}
