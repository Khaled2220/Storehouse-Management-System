<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockMovementResource extends JsonResource
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
            'product_id' => $this->product_id,
            'supplier_id' => $this->supplier_id,
            'type' => $this->type,
            'quantity' => $this->quantity,
            'movement_date' => $this->movement_date?->toDateString(),
            'note' => $this->note,
            'attachment' => $this->attachment,
            'created_by' => $this->created_by,

            'product' => $this->whenLoaded('product',
                fn () => new ProductResource($this->product)
            ),

            'supplier' => $this->whenLoaded('supplier',
                fn () => new SupplierResource($this->supplier)
            ),

            'creator' => $this->whenLoaded('creator',
                fn () => new UserResource($this->creator)
            ),

            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
