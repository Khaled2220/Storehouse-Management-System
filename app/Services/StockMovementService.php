<?php

namespace App\Services;

use App\Events\StockMovementCreated;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Throwable;

class StockMovementService
{
    public function __construct(private StockMovementAttachmentStorage $attachmentStorage) 
    {
        //
    }

    /**
     * Record a stock movement and update product quantity.
     */
    public function recordMovement(array $data,?string $attachmentPath = null,?string $attachmentExtension = null): StockMovement 
    {
        $type = $data['type'] ?? null;
        $quantityValue = $data['quantity'] ?? null;

        if (! in_array($type, ['in', 'out'], true)) {
            throw new InvalidArgumentException('Invalid movement type.');
        }

        $validQuantity = is_int($quantityValue)
            || (
                is_string($quantityValue)
                && ctype_digit($quantityValue)
            );

        if (! $validQuantity || (int) $quantityValue <= 0) {
            throw new InvalidArgumentException(
                'Quantity must be a positive whole number.'
            );
        }

        $quantity = (int) $quantityValue;
        $supplierId = null;

        if ($type === 'in') {
            $supplierIdValue = $data['supplier_id'] ?? null;

            $validSupplierId = is_int($supplierIdValue)
                || (
                    is_string($supplierIdValue)
                    && ctype_digit($supplierIdValue)
                );

            if (! $validSupplierId || (int) $supplierIdValue <= 0) {
                throw new InvalidArgumentException(
                    'A valid supplier is required for stock in movements.'
                );
            }

            $supplierId = (int) $supplierIdValue;
        }

        $storedAttachment = null;

        try {
            if ($attachmentPath !== null) {
                if ($attachmentExtension === null) {
                    throw new InvalidArgumentException(
                        'Attachment extension is required.'
                    );
                }

                $storedAttachment = $this->attachmentStorage->store(
                    $attachmentPath,
                    $attachmentExtension
                );
            }

            $movement = DB::transaction(function () use (
                $data,
                $type,
                $quantity,
                $supplierId,
                $storedAttachment
            ) {
                $product = Product::query()
                    ->lockForUpdate()
                    ->findOrFail($data['product_id']);

                if ($supplierId !== null) {
                    Supplier::query()->findOrFail($supplierId);
                }

                if ($type === 'in') {
                    $product->quantity += $quantity;
                } else {
                    if ($product->quantity < $quantity) {
                        throw new InvalidArgumentException(
                            'Insufficient stock quantity.'
                        );
                    }

                    $product->quantity -= $quantity;
                }

                $product->save();

                return StockMovement::create([
                    'product_id' => $product->id,
                    'supplier_id' => $supplierId,
                    'type' => $type,
                    'quantity' => $quantity,
                    'movement_date' => $data['movement_date'],
                    'note' => $data['note'] ?? null,
                    'attachment' => $storedAttachment,
                    'created_by' => $data['created_by'],
                ]);
            });
        } catch (Throwable $exception) {
            $this->attachmentStorage->delete($storedAttachment);

            throw $exception;
        }

        $movement->load([
            'product',
            'supplier',
            'creator',
        ]);

        event(new StockMovementCreated($movement));

        return $movement;
    }

    /**
     * Get all stock movements with optional filters.
     */
    public function getAllMovements(array $filters = []): LengthAwarePaginator 
    {
        return StockMovement::with([
            'product',
            'supplier',
            'creator',
        ])
            ->when(
                $filters['product_id'] ?? null,
                fn ($query, $productId) => $query->where(
                    'product_id',
                    $productId
                )
            )
            ->when(
                $filters['type'] ?? null,
                fn ($query, $type) => $query->where('type', $type)
            )
            ->when(
                $filters['date_from'] ?? null,
                fn ($query, $date) => $query->whereDate(
                    'movement_date',
                    '>=',
                    $date
                )
            )
            ->when(
                $filters['date_to'] ?? null,
                fn ($query, $date) => $query->whereDate(
                    'movement_date',
                    '<=',
                    $date
                )
            )
            ->latest('movement_date')
            ->latest('id')
            ->paginate(20)
            ->withQueryString();
    }

    /**
     * Get movements for a specific product.
     */
    public function getProductMovements(int $productId): LengthAwarePaginator 
    {
        return StockMovement::with([
            'supplier',
            'creator',
        ])
            ->where('product_id', $productId)
            ->latest('movement_date')
            ->latest('id')
            ->paginate(20)
            ->withQueryString();
    }

    /**
     * Get products and suppliers for movement forms.
     */
    public function getMovementFormOptions(): array
    {
        return [
            'products' => Product::query()
                ->orderBy('name')
                ->get(['id', 'name', 'quantity']),

            'suppliers' => Supplier::query()
                ->orderBy('name')
                ->get(['id', 'name']),
        ];
    }
}
