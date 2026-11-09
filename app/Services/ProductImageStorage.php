<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;
use RuntimeException;

class ProductImageStorage
{
    /**
     * Store a product image.
     */
    public function store(string $sourcePath, string $extension): string
    {
        if (! is_file($sourcePath) || ! is_readable($sourcePath)) {
            throw new InvalidArgumentException('Invalid image source.');
        }

        $extension = strtolower($extension);

        if (! preg_match('/^[a-z0-9]+$/', $extension)) {
            throw new InvalidArgumentException('Invalid image extension.');
        }

        $imageName = Str::uuid().'.'.$extension;

        $stored = Storage::disk('public')->putFileAs(
            '',
            $sourcePath,
            $imageName
        );

        if ($stored === false) {
            throw new RuntimeException('Unable to store product image.');
        }

        return $imageName;
    }

    /**
     * Delete a product image.
     */
    public function delete(?string $imageName): void
    {
        if (empty($imageName)) {
            return;
        }

        Storage::disk('public')->delete(basename($imageName));
    }
}
