<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexStockMovementRequest;
use App\Http\Requests\StoreStockMovementRequest;
use App\Http\Resources\StockMovementResource;
use App\Services\StockMovementService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StockMovementController extends Controller
{
    public function __construct(private StockMovementService $stockMovementService) 
    {
        //
    }

    public function index(IndexStockMovementRequest $request): AnonymousResourceCollection 
    {
        $movements = $this->stockMovementService->getAllMovements(
            $request->validated()
        );

        return StockMovementResource::collection($movements)
            ->additional([
                'success' => true,
            ]);
    }

    public function store(StoreStockMovementRequest $request): StockMovementResource 
    {
        $data = $request->validated();

        $attachment = $request->file('attachment');

        unset($data['attachment']);

        $data['created_by'] = $request->user()->id;

        $movement = $this->stockMovementService->recordMovement(
            $data,
            $attachment?->getPathname(),
            $attachment?->extension()
        );

        return (new StockMovementResource($movement))
            ->additional([
                'success' => true,
                'message' => 'Stock movement recorded successfully.',
            ]);
    }
}
