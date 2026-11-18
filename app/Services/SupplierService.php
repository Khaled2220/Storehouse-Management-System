<?php

namespace App\Services;

use App\Events\SupplierCreated;
use App\Models\Supplier;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Throwable;

class SupplierService
{
    public function __construct(private SupplierLogoStorage $logoStorage)
    {
        //
    }

    /**
     * Create a supplier and optionally store its logo.
     */
    public function createSupplier(array $data, ?UploadedFile $logo = null): Supplier
    {
        $storedLogo = null;

        try {
            if ($logo !== null) {
                $storedLogo = $this->logoStorage->store(
                    $logo->getRealPath(),
                    $logo->extension(),
                );

                $data['logo'] = $storedLogo;
            }
            $supplier = DB::transaction(function () use ($data) {
                return Supplier::create($data);
            });
        } catch (Throwable $exception) {
            $this->logoStorage->delete($storedLogo);

            throw $exception;
        }

        event(new SupplierCreated($supplier));

        return $supplier;
    }

    /**
     * Update a supplier and optionally replace its logo.
     */
    public function updateSupplier(Supplier $supplier, array $data, ?UploadedFile $logo = null): Supplier
    {
        $oldLogo = $supplier->logo;
        $newLogo = null;

        try {
            if ($logo !== null) {
                $newLogo = $this->logoStorage->store(
                    $logo->getRealPath(),
                    $logo->extension(),
                );

                $data['logo'] = $newLogo;
            }

            $updatedSupplier = DB::transaction(function () use (
                $supplier,
                $data
            ) {
                $supplier->update($data);

                return $supplier->refresh();
            });
        } catch (Throwable $exception) {
            $this->logoStorage->delete($newLogo);

            throw $exception;
        }

        if ($newLogo !== null) {
            $this->logoStorage->delete($oldLogo);
        }

        return $updatedSupplier;
    }

    /**
     * Delete a supplier only when it has no products.
     */
    public function deleteSupplier(Supplier $supplier): bool
    {
        $result = DB::transaction(function () use ($supplier) {
            $lockedSupplier = Supplier::query()
                ->lockForUpdate()
                ->findOrFail($supplier->id);

            if ($lockedSupplier->products()->exists()) {
                return false;
            }

            $logo = $lockedSupplier->logo;

            $deleted = $lockedSupplier->delete();

            if (! $deleted) {
                return false;
            }

            return ['logo' => $logo];
        });

        if ($result === false) {
            return false;
        }

        $this->logoStorage->delete($result['logo']);

        return true;
    }

    public function getAllSuppliers(): LengthAwarePaginator
    {
        return Supplier::withCount('products')
            ->orderBy('name')
            ->paginate(50);
    }

    public function getSupplierById(int $id): Supplier
    {
        return Supplier::with([
            'products.categories',
        ])->findOrFail($id);
    }
}
