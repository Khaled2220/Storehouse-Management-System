<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Services\NotificationService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService, private NotificationService $notificationService)
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
            $products = $this->productService->getProductsByCategory((int) $categoryId);
        } else {
            $products = $this->productService->getAllProducts();
        }
        $unreadNotificationsCount = $this->getUnreadNotificationsCount($request);

        return view('products.index')
            ->with('products', $products)
            ->with('unreadNotificationsCount', $unreadNotificationsCount);
    }

    /**
     * Show create product page.
     */
    public function create(Request $request)
    {
        $unreadNotificationsCount =
        $this->getUnreadNotificationsCount($request);

        $categories = Category::all();

        $suppliers = Supplier::orderBy('name')->get();

        return view('products.create')
            ->with('categories', $categories)
            ->with('suppliers', $suppliers)
            ->with('unreadNotificationsCount', $unreadNotificationsCount);
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

        return view('products.show')
            ->with('product', $product)
            ->with('unreadNotificationsCount', $unreadNotificationsCount);
    }

    /**
     * Show edit product page.
     */
    public function edit(Request $request, Product $product)
    {
        $unreadNotificationsCount =
        $this->getUnreadNotificationsCount($request);

        $categories = Category::all();

        $suppliers = Supplier::orderBy('name')->get();

        $product->load('categories', 'supplier');

        return view('products.edit')
            ->with('product', $product)
            ->with('categories', $categories)
            ->with('suppliers', $suppliers)
            ->with('unreadNotificationsCount', $unreadNotificationsCount);
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

    private function getUnreadNotificationsCount(Request $request): int
    {
        return $this->notificationService
            ->getUnreadCount($request->user());
    }
}
