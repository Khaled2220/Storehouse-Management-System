<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use App\Enums\UserType;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        Gate::authorize('update', $this->route('user'));
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');
        return [
            'full_name'=>['required','string','max:250'],
            'email'=>['required','string','email','max:225',Rule::unique('users', 'email')->ignore($user),],
            'password'=>['nullable','string','min:7'],
            'user_type' => ['required', Rule::enum(UserType::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'This Email already exists. Please Choose another Email',
        ];
    }
}
