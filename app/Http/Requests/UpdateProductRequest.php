<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
          $product = \App\Models\Products::find($this->route('id'));
          
          return $product !== null && $this->user()?->can('update', $product);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'quantity' => ['required','integer','min:0'],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'image' => ['nullable','mimes:jpeg,png,jpg,gif','max:2048']
        ];
    }
}
