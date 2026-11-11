<?php

namespace App\Services;

use App\Events\ProductCreated;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Throwable;

class ProductService
{
    public function __construct(private ProductImageStorage $imageStorage)
    {
        //
    }

    public function createProduct(array $data,?string $imagePath = null,?string $imageExtension = null): Product 
    {
        $categoryIds = $data['categories'] ?? [];

        unset($data['categories']);

        $this->prepareImage($data, $imagePath, $imageExtension);

        $newImage = $data['image'] ?? null;

        try {
            $product = DB::transaction(function () use ($data, $categoryIds) {
                $product = Product::create($data);

                $product->categories()->sync($categoryIds);

                return $product;
            });
        } 
        catch (Throwable $exception) {
            if ($newImage !== null) {
                $this->imageStorage->delete($newImage);
            }

            throw $exception;
        }

        event(new ProductCreated($product));

        return $product->load(['categories', 'user', 'supplier']);
    }

    public function updateProduct(Product $product,array $data,?string $imagePath = null,?string $imageExtension = null): Product 
    {
        $oldImage = $product->image;

        $categoryIds = $data['categories'] ?? [];
        $hasCategories = array_key_exists('categories', $data);

        unset($data['categories']);

        $this->prepareImage($data, $imagePath, $imageExtension);

        $newImage = $data['image'] ?? null;

        try {
            $updatedProduct = DB::transaction(function () use (
                $product,
                $data,
                $categoryIds,
                $hasCategories
            ) {
                $product->update($data);

                if ($hasCategories) {
                    $product->categories()->sync($categoryIds);
                }

                return $product->refresh();
            });
        } 
        catch (Throwable $exception) {
            if ($imagePath !== null) {
                $this->imageStorage->delete($newImage);
            }

            throw $exception;
        }

        if ($imagePath !== null) {
            $this->imageStorage->delete($oldImage);
        }

        return $updatedProduct->load(['categories', 'user', 'supplier']);
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

    public function getAllProducts(): LengthAwarePaginator
    {
        return Product::with(['categories', 'user', 'supplier'])
            ->latest()
            ->paginate(50);
    }

    public function getProductsByCategory(int $categoryId): LengthAwarePaginator
    {
        return Product::with(['categories', 'user', 'supplier'])
            ->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('categories.id', $categoryId);
            })
            ->latest()
            ->paginate(50);
    }

    public function getProductById(int $id): Product
    {
        return Product::with(['categories', 'user', 'supplier'])
            ->findOrFail($id);
    }

    private function prepareImage(array &$data,?string $imagePath,?string $imageExtension): void 
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

    public function getCategories(): Collection
    {
        return Category::all();
    }

    public function getSuppliers(): Collection
    {
        return Supplier::orderBy('name')->get();
    }

    public function getProductWithRelations(Product $product): Product
    {
        return $product->load(['categories', 'user', 'supplier']);
    }
}
