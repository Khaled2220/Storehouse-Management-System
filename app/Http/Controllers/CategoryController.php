<?php

namespace App\Http\Controllers;

use App\Models\Categorios;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Services\NotificationService;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService ,private NotificationService $notificationService) 
    {
        //
    }

    public function index()
    {
        $categorios = $this->categoryService->getAllCategories();

        return view('categoryview.index')->with('categorios', $categorios);

        //return view('categoryview.index', compact('categorios'));
    }

    public function create()
    {
        return view('categoryview.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        $this->categoryService->createCategory($validated);

        return redirect()->route('Categorios.index')
            ->with('success', 'Category Added Successfully');
    }

    public function show(Categorios $category)
    {
        $products = $category->products;
           
        return view('categoryview.show')
            ->with('category', $category)
            ->with('products', $products);
        //return view('categoryview.show', compact('category', 'products'));
    }

    public function edit(Categorios $category)
    {
        return view('categoryview.edit')->with('category', $category);

        //return view('categoryview.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request,Categorios $category)
    {
        $validated = $request->validated();

        $this->categoryService->updateCategory($category,$validated);

        return redirect()->route('Categorios.index')
            ->with('success', 'Category Updated Successfully');
    }

    public function destroy(Categorios $category)
    {
        $deleted = $this->categoryService->deleteCategory($category);

        if (! $deleted) {
            return redirect()->route('Categorios.index')
                ->with(
                    'error',
                    'Category cannot be deleted because it has linked products'
                );
        }
        return redirect()->route('Categorios.index')
            ->with('success', 'Category Deleted Successfully');
    }
}
