<?php

namespace App\Services;

use App\Events\ProductCreated;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductService
{
    public function __construct(private ProductImageStorage $imageStorage)
    {
        //
    }

    public function createProduct(array $data, ?UploadedFile $image, User $user): Product
    {
        $categoryIds = $data['categories'] ?? [];

        unset($data['categories']);

        $data['user_id'] = $user->id;

        $this->prepareImage($data, $image);

        $newImage = $data['image'] ?? null;

        try {
            $product = DB::transaction(function () use ($data, $categoryIds) {
                $product = Product::create($data);

                $product->categories()->sync($categoryIds);

                return $product;
            });
        } catch (Throwable $exception) {
            if ($newImage !== null) {
                $this->imageStorage->delete($newImage);
            }

            throw $exception;
        }

        event(new ProductCreated($product));

        return $product->load(['categories', 'user', 'supplier']);
    }

    public function updateProduct(Product $product, array $data, ?UploadedFile $image = null): Product
    {
        $oldImage = $product->image;

        $categoryIds = $data['categories'] ?? [];
        $hasCategories = array_key_exists('categories', $data);

        unset($data['categories']);

        $this->prepareImage($data, $image);

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
        } catch (Throwable $exception) {
            if ($newImage !== null) {
                $this->imageStorage->delete($newImage);
            }

            throw $exception;
        }

        if ($image !== null) {
            $this->imageStorage->delete($oldImage);
        }

        return $updatedProduct->load(['categories', 'user', 'supplier']);
    }

    public function deleteProduct(Product $product): bool
    {
        if ($product->stockMovements()->exists()) {
            return false;
        }

        $image = $product->image;

        $deleted = (bool) $product->delete();

        if ($deleted) {
            $this->imageStorage->delete($image);
        }

        return $deleted;
    }

    public function getAllProducts(): LengthAwarePaginator
    {
        return $this->getProducts();
    }

    public function getProducts(?int $categoryId = null): LengthAwarePaginator
    {
        return Product::with(['categories', 'user', 'supplier'])
            ->when($categoryId !== null, function ($query) use ($categoryId) {
                $query->whereHas('categories', function ($query) use ($categoryId) {
                    $query->where('categories.id', $categoryId);
                });
            })
            ->latest()
            ->paginate(50);
    }

    private function prepareImage(array &$data, ?UploadedFile $image): void
    {
        if ($image === null) {
            unset($data['image']);

            return;
        }

        $data['image'] = $this->imageStorage->store(
            $image->getRealPath(),
            $image->extension()
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
