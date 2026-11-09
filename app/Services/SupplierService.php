<?php

namespace App\Services;

use App\Models\Supplier;
use App\Events\SupplierCreated;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Throwable;

class SupplierService
{
    public function __construct(private SupplierLogoStorage $logoStorage) 
    {
        //
    }

    public function getAllSuppliers()
    {
        return Supplier::withCount('products')
            ->orderBy('name')
            ->paginate(50);
    }

    public function getSupplierById(int $id): Supplier
    {
        return Supplier::with(['products.categories'])
            ->findOrFail($id);
    }

    public function createSupplier(array $data, ?string $logoPath = null, ?string $logoExtension = null): Supplier 
    {
        $storedLogo = null;

        try {
            if ($logoPath !== null) {
                if ($logoExtension === null) {
                    throw new InvalidArgumentException(
                        'Logo extension is required.'
                    );
                }

                $storedLogo = $this->logoStorage->store(
                    $logoPath,
                    $logoExtension
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

    public function updateSupplier(Supplier $supplier, array $data, ?string $logoPath = null, ?string $logoExtension = null): Supplier 
    {
        $oldLogo = $supplier->logo;
        $newLogo = null;

        try {
            if ($logoPath !== null) {
                if ($logoExtension === null) {
                    throw new InvalidArgumentException(
                        'Logo extension is required.'
                    );
                }

                $newLogo = $this->logoStorage->store(
                    $logoPath,
                    $logoExtension
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
        } 
        catch (Throwable $exception) {
            $this->logoStorage->delete($newLogo);

            throw $exception;
        }

        if ($newLogo !== null) {
            $this->logoStorage->delete($oldLogo);
        }

        return $updatedSupplier;
    }

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

            $lockedSupplier->delete();

            return ['logo' => $logo];
        });

        if ($result === false) {
            return false;
        }

        $this->logoStorage->delete($result['logo']);

        return true;
    }
}