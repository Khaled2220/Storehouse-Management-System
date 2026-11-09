<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use App\Services\SupplierService;
use Illuminate\Http\JsonResponse;

class SupplierController extends Controller
{
    public function __construct(private SupplierService $supplierService) 
    {
        //
    }

    public function index(): JsonResponse
    {
        $suppliers = $this->supplierService->getAllSuppliers();

        return response()->json([
            'status' => true,
            'data' => $suppliers,
        ]);
    }

    public function show(Supplier $supplier): JsonResponse
    {
        $supplier = $this->supplierService
            ->getSupplierById($supplier->id);

        return response()->json([
            'status' => true,
            'data' => $supplier,
        ]);
    }

    public function store(StoreSupplierRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $logo = $request->file('logo');

        $supplier = $this->supplierService->createSupplier(
            $validated,
            $logo?->getRealPath() ?: null,
            $logo?->extension()
        );
        return response()->json([
            'status' => true,
            'message' => 'Supplier created successfully.',
            'data' => $supplier,
        ], 201);
    }

    public function update( UpdateSupplierRequest $request, Supplier $supplier): JsonResponse 
    {
        $validated = $request->validated();

        $logo = $request->file('logo');

        $updatedSupplier = $this->supplierService->updateSupplier(
            $supplier,
            $validated,
            $logo?->getRealPath() ?: null,
            $logo?->extension()
        );
        return response()->json([
            'status' => true,
            'message' => 'Supplier updated successfully.',
            'data' => $updatedSupplier,
        ]);
    }

    public function destroy(Supplier $supplier): JsonResponse
    {
        $deleted = $this->supplierService
            ->deleteSupplier($supplier);

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