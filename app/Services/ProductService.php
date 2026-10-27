<?php

namespace App\Services;

use App\Models\Products;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class ProductService
{
    public function getAllProducts()
    {
        return Products::latest()->paginate(50);
    }

    public function getProductById(int $id): Products
    {
        return Products::findOrFail($id);
    }

    public function createProduct(array $data,?UploadedFile $image = null): Products 
    {
        if ($image !== null) {
            $data['image'] = $this->uploadImage($image);
        } else {
            unset($data['image']);
        }

        return Products::create($data);
    }

    public function updateProduct(Products $product,array $data,?UploadedFile $image = null): Products 
    {
        if ($image !== null) {
            $oldImage = $product->image;
            $data['image'] = $this->uploadImage($image);
            $product->update($data);
            $this->deleteImage($oldImage);

            return $product->refresh();
        }

        unset($data['image']);
        $product->update($data);

        return $product->refresh();
    }

    public function deleteProduct(Products $product): bool
    {
        $image = $product->image;

        $deleted = (bool) $product->delete();

        if ($deleted) {
            $this->deleteImage($image);
        }
        return $deleted;
    }

    private function uploadImage(?UploadedFile $image): ?string
    {
        if ($image === null) {
            return null;
        }
        $directory = public_path('image');
        File::ensureDirectoryExists($directory);
        $imageName = uniqid() . '.' . $image->extension();
        $image->move($directory, $imageName);

        return $imageName;
    }

    private function deleteImage(?string $imageName): void
    {
        if ($imageName === null || $imageName === '') {
            return;
        }
        $path = public_path('image/' . basename($imageName));
        if (File::exists($path)) {
            File::delete($path);
        }
    }
}