<?php

namespace App\Http\Requests;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        Gate::authorize('create', User::class);

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:250'],
            'email' => ['required', 'string', 'email', 'max:225', 'unique:users,email'],
            'password' => ['required', 'string', 'min:7'],
            'user_type' => [
                'required',
                Rule::in([
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
