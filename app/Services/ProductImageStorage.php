<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
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
        if (!is_file($sourcePath) || !is_readable($sourcePath)) {
            throw new InvalidArgumentException('Invalid image source.');
        }

        $extension = strtolower($extension);

        if (!preg_match('/^[a-z0-9]+$/', $extension)) {
            throw new InvalidArgumentException('Invalid image extension.');
        }

        $directory = public_path('image');

        File::ensureDirectoryExists($directory);

        $imageName = Str::uuid() . '.' . $extension;

        $destination = $directory . DIRECTORY_SEPARATOR . $imageName;

        if (!File::copy($sourcePath, $destination)) {
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
        $path = public_path('image/' . basename($imageName));

        if (File::exists($path)) {
            File::delete($path);
        }
    }
}