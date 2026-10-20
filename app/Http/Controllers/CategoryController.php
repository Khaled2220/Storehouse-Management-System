<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;
use App\Events\category;
use App\Notifications\CategoryCreatedNotification;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService) 
    {
        //
    }

    public function index()
    {
        $categorios = $this->categoryService->getAllCategories();

        return view('categoryview.index', compact('categorios'));
    }

    public function create()
    {
        return view('categoryview.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        $category = $this->categoryService->createCategory([
            'name' => $validated['name'],
        ]);

        event(new category($category));

        $user = Auth::user();

        if ($user) {
            $user->notify(
                new CategoryCreatedNotification(
                    $category->name,
                    $category->id
                )
            );
        }
        return redirect()->route('Categorios.index')
            ->with('success', 'Category added successfully');
    }

    public function show($id)
    {
        $category = $this->categoryService->getCategoryById((int) $id);

        return view('categoryview.show', compact('category'));
    }

    public function edit($id)
    {
        $category = $this->categoryService->getCategoryById((int) $id);

        return view('categoryview.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->categoryService->getCategoryById((int) $id);
        $validated = $request->validated();

        $this->categoryService->updateCategory($category, [
            'name' => $validated['name'],
        ]);

        return redirect()->route('Categorios.index')
            ->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = $this->categoryService->getCategoryById((int) $id);

        $deleted = $this->categoryService->deleteCategory($category);

        if (! $deleted) {
            return redirect()->route('Categorios.index')
                ->with(
                    'error',
                    'Category cannot be deleted because it has linked products'
                );
        }

        return redirect()->route('Categorios.index')
            ->with('success', 'Category deleted successfully');
    }
}
