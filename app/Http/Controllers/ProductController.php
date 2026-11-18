<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\NotificationService;
use App\Services\ProductService;
use App\Services\StockMovementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService, private NotificationService $notificationService, private StockMovementService $stockMovementService)
    {
        //
    }

    /**
     * Display all products.
     */
    public function index(Request $request): View
    {
        $categoryId = $request->filled('category_id') ? $request->integer('category_id') : null;

        $products = $this->productService->getProducts($categoryId);

        $unreadNotificationsCount = $this->getUnreadNotificationsCount($request);

        return view('products.index')->with([
            'products' => $products,
            'unreadNotificationsCount' => $unreadNotificationsCount,
        ]);
    }

    /**
     * Show create product page.
     */
    public function create(Request $request): View
    {
        $categories = $this->productService->getCategories();

        $suppliers = $this->productService->getSuppliers();

        $unreadNotificationsCount = $this->getUnreadNotificationsCount($request);

        return view('products.create')->with([
            'categories' => $categories,
            'suppliers' => $suppliers,
            'unreadNotificationsCount' => $unreadNotificationsCount,
        ]);
    }

    /**
     * Store a new product.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->productService->createProduct(
            $request->validated(),
            $request->file('image'),
            $request->user(),
        );

        return redirect()->route('products.index')
            ->with('success', 'Product Added Successfully');
    }

    /**
     * Display a specific product.
     */
    public function show(Request $request, Product $product): View
    {
        $unreadNotificationsCount = $this->getUnreadNotificationsCount($request);

        $product = $this->productService->getProductWithRelations($product);

        $movements = $this->stockMovementService->getProductMovements($product->id);

        return view('products.show')->with([
            'product' => $product,
            'movements' => $movements,
            'unreadNotificationsCount' => $unreadNotificationsCount,
        ]);
    }

    /**
     * Show edit product page.
     */
    public function edit(Request $request, Product $product): View
    {
        $categories = $this->productService->getCategories();

        $suppliers = $this->productService->getSuppliers();

        $product = $this->productService->getProductWithRelations($product);

        $unreadNotificationsCount = $this->getUnreadNotificationsCount($request);

        return view('products.edit')->with([
            'product' => $product,
            'categories' => $categories,
            'suppliers' => $suppliers,
            'unreadNotificationsCount' => $unreadNotificationsCount,
        ]);
    }

    /**
     * Update an existing product.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $this->productService->updateProduct($product, $request->validated(), $request->file('image'));

        return redirect()->route('products.index')
            ->with('success', 'Product Updated Successfully');
    }

    /**
     * Delete a product.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $deleted = $this->productService->deleteProduct($product);

        if (! $deleted) {
            return redirect()->route('products.index')
                ->with('error', 'Product Could Not be Deleted');
        }

        return redirect()->route('products.index')
            ->with('success', 'Product Deleted Successfully');
    }

    private function getUnreadNotificationsCount(Request $request): int
    {
        return $this->notificationService->getUnreadCount($request->user());
    }
}
