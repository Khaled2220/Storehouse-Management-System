<?php

namespace App\Services;

use App\Events\ProductCreated;
use App\Models\Product;
use InvalidArgumentException;

class ProductService
{
    public function __construct(private ProductImageStorage $imageStorage)
    {
        //
    }

    public function getAllProducts()
    {
        return Product::with(['categories', 'user'])
            ->latest()
            ->paginate(50);
    }

    public function getProductsByCategory(int $categoryId)
    {
        return Product::with(['categories', 'user'])
            ->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('categories.id', $categoryId);
            })
            ->latest()
            ->paginate(50);
    }

    public function getProductById(int $id): Product
    {
        return Product::with(['categories', 'user'])
            ->findOrFail($id);
    }

    public function createProduct(array $data, ?string $imagePath = null, ?string $imageExtension = null): Product
    {
        $categoryIds = $data['categories'] ?? [];

        unset($data['categories']);

        $this->prepareImage(
            $data,
            $imagePath,
            $imageExtension
        );
        $product = Product::create($data);

        $product->categories()->sync($categoryIds);

        event(new ProductCreated($product));

        return $product->load(['categories', 'user']);
    }

    public function updateProduct(Product $product, array $data, ?string $imagePath = null, ?string $imageExtension = null): Product
    {
        $oldImage = $product->image;

        $categoryIds = $data['categories'] ?? [];

        $hasCategories = array_key_exists('categories', $data);

        unset($data['categories']);

        $this->prepareImage(
            $data,
            $imagePath,
            $imageExtension
        );

        $product->update($data);

        if ($hasCategories) {
            $product->categories()->sync($categoryIds);
        }

        if ($imagePath !== null) {
            $this->imageStorage->delete($oldImage);
        }

        return $product->refresh()->load(['categories', 'user']);
    }

    public function deleteProduct(Product $product): bool
    {
        $image = $product->image;

        $deleted = (bool) $product->delete();

        if ($deleted) {
            $this->imageStorage->delete($image);
        }

        return $deleted;
    }

    private function prepareImage(array &$data, ?string $imagePath, ?string $imageExtension): void
    {
        if ($imagePath === null) {
            unset($data['image']);

            return;
        }

        if ($imageExtension === null) {
            throw new InvalidArgumentException(
                'Image extension is required.'
            );
        }
        $data['image'] = $this->imageStorage->store(
            $imagePath,
            $imageExtension
        );
    }
}
