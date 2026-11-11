<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image,
            'status' => $this->status,
            'expiry_date' => $this->expiry_date?->toDateString(),

            'categories' => $this->whenLoaded('categories',
                fn () => $this->categories->map(fn ($category) => [
                    'id' => $category->id,
                    'name' => $category->name,
                ])
            ),

            'user' => $this->whenLoaded('user',
                fn () => new UserResource($this->user)
            ),

            'supplier' => $this->whenLoaded('supplier',
                fn () => new SupplierResource($this->supplier)
            ),
        ];
    }
}
