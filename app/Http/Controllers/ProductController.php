<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\NotificationService;
use App\Services\ProductService;
use App\Services\StockMovementService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService,private NotificationService $notificationService,private StockMovementService $stockMovementService) 
    {
        //
    }

    /**
     * Display all products.
     */
    public function index(Request $request)
    {
        $categoryId = $request->query('category_id');

        if ($categoryId) {
            $products = $this->productService
                ->getProductsByCategory((int) $categoryId);
        } 
        else {
            $products = $this->productService->getAllProducts();
        }

        $unreadNotificationsCount =
            $this->getUnreadNotificationsCount($request);

        return view('products.index')->with([
            'products' => $products,
            'unreadNotificationsCount' => $unreadNotificationsCount,
        ]);
    }

    /**
     * Show create product page.
     */
    public function create(Request $request)
    {
        $categories = $this->productService->getCategories();

        $suppliers = $this->productService->getSuppliers();

        $unreadNotificationsCount =
            $this->getUnreadNotificationsCount($request);

        return view('products.create')->with([
            'categories' => $categories,
            'suppliers' => $suppliers,
            'unreadNotificationsCount' => $unreadNotificationsCount,
        ]);
    }

    /**
     * Store a new product.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $image = $request->file('image');

        $this->productService->createProduct(
            $validated,
            $image?->getRealPath() ?: null,
            $image?->extension()
        );

        return redirect()->route('products.index')
            ->with('success', 'Product Added Successfully');
    }

    /**
     * Display a specific product.
     */
    public function show(Request $request, Product $product)
    {
        $unreadNotificationsCount =
            $this->getUnreadNotificationsCount($request);

        $product->load('categories', 'supplier');

        $movements = $this->stockMovementService
            ->getProductMovements($product->id);

        return view('products.show')->with([
            'product' => $product,
            'movements' => $movements,
            'unreadNotificationsCount' => $unreadNotificationsCount,
        ]);
    }

    /**
     * Show edit product page.
     */
    public function edit(Request $request, Product $product)
    {
        $categories = $this->productService->getCategories();

        $suppliers = $this->productService->getSuppliers();

        $product = $this->productService
            ->getProductWithRelations($product);

        $unreadNotificationsCount =
            $this->getUnreadNotificationsCount($request);

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
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $image = $request->file('image');

        $this->productService->updateProduct(
            $product,
            $validated,
            $image?->getRealPath() ?: null,
            $image?->extension()
        );

        return redirect()->route('products.index')
            ->with('success', 'Product Updated Successfully');
    }

    /**
     * Delete a product.
     */
    public function destroy(Product $product)
    {
        $deleted = $this->productService->deleteProduct($product);

        if (! $deleted) {
            return redirect()->route('products.index')
                ->with('error', 'Product Could Not be Deleted');
        }

        return redirect()->route('products.index')
            ->with('success', 'Product Deleted Successfully');
    }

    /**
     * Get unread notifications count for the authenticated user.
     */
    private function getUnreadNotificationsCount(Request $request): int
    {
        return $this->notificationService->getUnreadCount($request->user());
    }
}