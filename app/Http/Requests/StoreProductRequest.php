<?php

namespace App\Http\Requests;

use App\Models\Products;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        Gate::authorize('create',Products::class);
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255','unique:products,name'],
            'quantity' => ['required','integer','min:0'],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],
            'status' => ['required', 'in:active,expired'],
            'expiry_date' => ['nullable', 'date'],
        ];
    }
    
    public function messages(): array
    {
        return [
            'name.unique' => 'This product name already exists. Please choose another name.',
            'categories.*.exists' => 'One or more selected categories do not exist.',
            'status.in' => 'Status must be active or expired.',
            'expiry_date.date' => 'Please enter a valid expiry date.',
        ];
    }
}
