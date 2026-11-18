<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use App\Services\NotificationService;
use App\Services\SupplierService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function __construct(private SupplierService $supplierService, private NotificationService $notificationService)
    {
        //
    }

    /**
     * Display all suppliers.
     */
    public function index(Request $request): View
    {
        $suppliers = $this->supplierService->getAllSuppliers();

        $unreadNotificationsCount = $this->getUnreadNotificationsCount($request);

        return view('suppliers.index')->with([
            'suppliers' => $suppliers,
            'unreadNotificationsCount' => $unreadNotificationsCount,
        ]);
    }

    /**
     * Show create supplier page.
     */
    public function create(Request $request): View
    {
        $unreadNotificationsCount = $this->getUnreadNotificationsCount($request);

        return view('suppliers.create')->with(['unreadNotificationsCount' => $unreadNotificationsCount]);
    }

    /**
     * Store a new supplier.
     */
    public function store(StoreSupplierRequest $request): RedirectResponse
    {
        $this->supplierService->createSupplier(
            $request->validated(),
            $request->file('logo')
        );

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier Added Successfully');
    }

    /**
     * Display a specific supplier and its products.
     */
    public function show(Request $request, Supplier $supplier): View
    {
        $supplier = $this->supplierService->getSupplierById($supplier->id);

        $unreadNotificationsCount = $this->getUnreadNotificationsCount($request);

        return view('suppliers.show')->with([
            'supplier' => $supplier,
            'products' => $supplier->products,
            'unreadNotificationsCount' => $unreadNotificationsCount,
        ]);
    }

    /**
     * Show edit supplier page.
     */
    public function edit(Request $request, Supplier $supplier): View
    {
        $unreadNotificationsCount = $this->getUnreadNotificationsCount($request);

        return view('suppliers.edit')->with([
            'supplier' => $supplier,
            'unreadNotificationsCount' => $unreadNotificationsCount,
        ]);
    }

    /**
     * Update an existing supplier.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier): RedirectResponse
    {
        $this->supplierService->updateSupplier(
            $supplier,
            $request->validated(),
            $request->file('logo')
        );

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier Updated Successfully');
    }

    /**
     * Delete a supplier.
     */
    public function destroy(Supplier $supplier): RedirectResponse
    {
        $deleted = $this->supplierService->deleteSupplier($supplier);

        if (! $deleted) {
            return redirect()->route('suppliers.index')
                ->with(
                    'error',
                    'Supplier Cannot Be Deleted Because It Has Products.'
                );
        }

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier Deleted Successfully');
    }

    /**
     * Get unread notifications count for the authenticated user.
     */
    private function getUnreadNotificationsCount(Request $request): int
    {
        return $this->notificationService->getUnreadCount($request->user());
    }
}
