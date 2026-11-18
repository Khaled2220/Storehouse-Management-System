<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:250'],
            'email' => ['required', 'string', 'email', 'max:225', 'unique:users,email'],
            'password' => ['required', 'string', 'min:7'],
            'user_type' => ['required', 'in:1,2'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'This Email already exists.Please Choose another Email',
        ];
    }
}
