<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use App\Services\NotificationService;
use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct(private SupplierService $supplierService, private NotificationService $notificationService)
    {
        //
    }

    /**
     * Display all suppliers.
     */
    public function index(Request $request)
    {
        $suppliers = $this->supplierService->getAllSuppliers();

        $unreadNotificationsCount =
            $this->getUnreadNotificationsCount($request);

        return view('suppliers.index')
            ->with('suppliers', $suppliers)
            ->with('unreadNotificationsCount', $unreadNotificationsCount);
    }

    /**
     * Show create supplier page.
     */
    public function create(Request $request)
    {
        $unreadNotificationsCount =
            $this->getUnreadNotificationsCount($request);

        return view('suppliers.create')->with('unreadNotificationsCount', $unreadNotificationsCount);
    }

    /**
     * Store a new supplier.
     */
    public function store(StoreSupplierRequest $request)
    {
        $validated = $request->validated();

        $logo = $request->file('logo');

        $this->supplierService->createSupplier(
            $validated,
            $logo?->getRealPath() ?: null,
            $logo?->extension()
        );

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier Added Successfully');
    }

    /**
     * Display a specific supplier.
     */
    public function show(Request $request, Supplier $supplier)
    {
        $supplier = $this->supplierService
            ->getSupplierById($supplier->id);

        $unreadNotificationsCount =
            $this->getUnreadNotificationsCount($request);

        return view('suppliers.show')
            ->with('supplier', $supplier)
            ->with('unreadNotificationsCount', $unreadNotificationsCount);
    }

    /**
     * Show edit supplier page.
     */
    public function edit(Request $request, Supplier $supplier)
    {
        $supplier = $this->supplierService
            ->getSupplierById($supplier->id);

        $unreadNotificationsCount =
            $this->getUnreadNotificationsCount($request);

        return view('suppliers.edit')
            ->with('supplier', $supplier)
            ->with('unreadNotificationsCount', $unreadNotificationsCount);
    }

    /**
     * Update an existing supplier.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $validated = $request->validated();

        $logo = $request->file('logo');

        $this->supplierService->updateSupplier(
            $supplier,
            $validated,
            $logo?->getRealPath() ?: null,
            $logo?->extension()
        );

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier Updated Successfully');
    }

    /**
     * Delete a supplier.
     */
    public function destroy(Supplier $supplier)
    {
        $deleted = $this->supplierService->deleteSupplier($supplier);

        if (! $deleted) {
            return redirect()->route('suppliers.index')
                ->with('error', 'Supplier Cannot Be Deleted Because It Has Products.');
        }

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier Deleted Successfully');
    }

    private function getUnreadNotificationsCount(Request $request): int
    {
        return $this->notificationService->getUnreadCount($request->user());
    }
}
