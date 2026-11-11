<?php

namespace App\Http\Requests;

use App\Models\StockMovement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreStockMovementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        Gate::authorize('create', StockMovement::class);

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required','integer','exists:products,id',],
            'supplier_id' => ['required_if:type,in','nullable','integer','exists:suppliers,id',],
            'type' => ['required',Rule::in(['in', 'out']),],
            'quantity' => ['required','integer','min:1',],
            'movement_date' => ['required','date',],
            'note' => ['nullable','string','max:5000',],
            'attachment' => ['nullable','file','mimes:pdf,jpg,jpeg,png','max:5120',],
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'product_id.required' => 'Please select a product.',
            'product_id.exists' => 'The selected product does not exist.',
            'supplier_id.required_if' => 'Please select a supplier for stock in movements.',
            'supplier_id.exists' => 'The selected supplier does not exist.',
            'type.in' => 'Movement type must be in or out.',
            'quantity.required' => 'Please enter the movement quantity.',
            'quantity.integer' => 'Quantity must be a whole number.',
            'quantity.min' => 'Quantity must be greater than zero.',
            'movement_date.required' => 'Please select the movement date.',
            'attachment.mimes' => 'Attachment must be a PDF or image.',
            'attachment.max' => 'Attachment size must not exceed 5 MB.',
        ];
    }
}
