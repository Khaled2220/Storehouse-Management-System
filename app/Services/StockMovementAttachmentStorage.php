<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;
use RuntimeException;

class StockMovementAttachmentStorage
{
    public function store(string $sourcePath, string $extension): string
    {
        if (! is_file($sourcePath) || ! is_readable($sourcePath)) {
            throw new InvalidArgumentException(
                'Invalid attachment source.'
            );
        }

        $extension = strtolower($extension);

        if (! preg_match('/^[a-z0-9]+$/', $extension)) {
            throw new InvalidArgumentException(
                'Invalid attachment extension.'
            );
        }

        $fileName = Str::uuid().'.'.$extension;

        $stored = Storage::disk('public')->putFileAs(
            'stock-movements',
            $sourcePath,
            $fileName
        );

        if ($stored === false) {
            throw new RuntimeException(
                'Failed to store movement attachment.'
            );
        }

        return $stored;
    }

    public function delete(?string $path): void
    {
        if (empty($path)) {
            return;
        }

        Storage::disk('public')->delete($path);
    }
}
