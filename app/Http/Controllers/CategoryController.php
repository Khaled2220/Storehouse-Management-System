<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {
        //
    }

    public function index(): View
    {
        $categories = $this->categoryService->getAllCategories();

        return view('categories.index')->with(['categories' => $categories]);
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $this->categoryService->createCategory($request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Category Added Successfully');
    }

    public function show(Category $category): View
    {
        $category = $this->categoryService->getCategoryWithProducts($category);

        return view('categories.show')->with([
            'category' => $category,
            'products' => $category->products,
        ]);
    }

    public function edit(Category $category): View
    {
        return view('categories.edit')->with(['category' => $category]);
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $this->categoryService->updateCategory($category, $request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Category Updated Successfully');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $deleted = $this->categoryService->deleteCategory($category);

        if (! $deleted) {
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
