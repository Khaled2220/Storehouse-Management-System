<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService) 
    {
        //
    }

    public function index()
    {
        $categories = $this->categoryService->getAllCategories();

        return view('categories.index')->with([
            'categories' => $categories
        ]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        $this->categoryService->createCategory($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category Added Successfully');
    }

    public function show(Category $category)
    {
        $products = $category->products;

        return view('categories.show')->with([
            'category' => $category,
            'products' => $products
        ]);
    }

    public function edit(Category $category)
    {
        return view('categories.edit')->with([
            'category' => $category
        ]);
    }

    public function update(UpdateCategoryRequest $request,Category $category) 
    {
        $validated = $request->validated();

        $this->categoryService->updateCategory($category, $validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category Updated Successfully');
    }

    public function destroy(Category $category)
    {
        $deleted = $this->categoryService->deleteCategory($category);

        if (!$deleted) {
            return redirect()->route('categories.index')
                ->with(
                    'error',
                    'Category cannot be deleted because it has linked products'
                );
        }

        return redirect()->route('categories.index')
            ->with('success', 'Category Deleted Successfully');
    }
}
