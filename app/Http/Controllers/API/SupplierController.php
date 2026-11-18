<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use App\Services\SupplierService;
use Illuminate\Http\JsonResponse;

class SupplierController extends Controller
{
    public function __construct(private SupplierService $supplierService)
    {
        //
    }

    /**
     * Display all suppliers.
     */
    public function index(): JsonResponse
    {
        $suppliers = $this->supplierService->getAllSuppliers();

        return SupplierResource::collection($suppliers)
            ->additional([
                'status' => true,
                'message' => 'Suppliers retrieved successfully.',
            ])
            ->response();
    }

    /**
     * Display the specified supplier.
     */
    public function show(Supplier $supplier): JsonResponse
    {
        return (new SupplierResource($supplier))
            ->additional([
                'status' => true,
                'message' => 'Supplier retrieved successfully.',
            ])
            ->response();
    }

    /**
     * Store a new supplier.
     */
    public function store(StoreSupplierRequest $request): JsonResponse
    {
        $supplier = $this->supplierService->createSupplier(
            $request->validated(),
            $request->file('logo'),
        );

        return (new SupplierResource($supplier))
            ->additional([
                'status' => true,
                'message' => 'Supplier created successfully.',
            ])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Update the specified supplier.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier): JsonResponse
    {
        $updatedSupplier = $this->supplierService->updateSupplier(
            $supplier,
            $request->validated(),
            $request->file('logo'),
        );

        return (new SupplierResource($updatedSupplier))
            ->additional([
                'status' => true,
                'message' => 'Supplier updated successfully.',
            ])
            ->response();
    }

    /**
     * Delete the specified supplier.
     */
    public function destroy(Supplier $supplier): JsonResponse
    {
        $deleted = $this->supplierService->deleteSupplier($supplier);

        if (! $deleted) {
            return response()->json([
                'status' => false,
                'message' => 'Cannot delete supplier because it has products.',
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Supplier deleted successfully.',
        ]);
    }
}
