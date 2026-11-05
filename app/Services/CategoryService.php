<?php

namespace App\Services;

use App\Models\Categorios;
use App\Events\category;

class CategoryService
{
    public function getAllCategories()
    {
        return Categorios::all();
    }

    public function getCategoryById(int $id): Categorios
    {
        return Categorios::findOrFail($id);
    }

    public function createCategory(array $data): Categorios
    {
        $category = Categorios::create($data);

        event(new category($category));

        return $category;
    }

    public function updateCategory(Categorios $category,array $data): Categorios 
    {
        $category->update($data);
        
        return $category->refresh();
    }

    public function deleteCategory(Categorios $category): bool
    {
         if ($category->products()->exists()) {
            return false;
        }
        return (bool) $category->delete();
    }
}
