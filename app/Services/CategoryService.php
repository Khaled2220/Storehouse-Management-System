<?php

namespace App\Services;

use App\Events\CategoryCreated;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function getAllCategories(): Collection
    {
        return Category::all();
    }

    public function getCategoryById(int $id): Category
    {
        return Category::findOrFail($id);
    }

    public function createCategory(array $data): Category
    {
        $category = Category::create($data);

        event(new CategoryCreated($category));

        return $category;
    }

    public function updateCategory(Category $category, array $data): Category
    {
        $category->update($data);

        return $category->refresh();
    }

    public function deleteCategory(Category $category): bool
    {
        if ($category->products()->exists()) {
            return false;
        }

        return (bool) $category->delete();
    }

    public function getCategoryWithProducts(Category $category): Category
    {
        return $category->load('products');
    }
}
