<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexStockMovementRequest;
use App\Http\Requests\StoreStockMovementRequest;
use App\Services\StockMovementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StockMovementController extends Controller
{
    public function __construct(private StockMovementService $stockMovementService) 
    {
        //
    }

    public function index(IndexStockMovementRequest $request): View
    {
        $filters = $request->validated();

        $movements = $this->stockMovementService->getAllMovements($filters);

        $options = $this->stockMovementService->getMovementFormOptions();

        return view('stock-movements.index')
            ->with('movements', $movements)
            ->with('filters', $filters)
            ->with($options);
    }

    public function store(StoreStockMovementRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $attachment = $request->file('attachment');

        unset($data['attachment']);

        $data['created_by'] = $request->user()->id;

        $this->stockMovementService->recordMovement(
            $data,
            $attachment?->getPathname(),
            $attachment?->extension()
        );

        return back()->with(
            'success',
            'Stock movement recorded successfully.'
        );
    }
}
