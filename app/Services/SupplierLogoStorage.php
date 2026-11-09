<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;
use RuntimeException;

class SupplierLogoStorage
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(string $sourcePath, string $extension): string
    {
        if (! is_file($sourcePath) || ! is_readable($sourcePath)) {
            throw new InvalidArgumentException('Invalid logo source.');
        }

        $extension = strtolower($extension);

        if (! preg_match('/^[a-z0-9]+$/', $extension)) {
            throw new InvalidArgumentException('Invalid image extension.');
        }

        $logoName = Str::uuid().'.'.$extension;

        $stored = Storage::disk('public')->putFileAs(
            'suppliers',
            $sourcePath,
            $logoName
        );

        if ($stored === false) {
            throw new RuntimeException('Unable to store supplier logo.');
        }

        return $stored;
    }

    public function delete(?string $logoPath): void
    {
        if (empty($logoPath)) {
            return;
        }

        Storage::disk('public')->delete($logoPath);
    }
}
