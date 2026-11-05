<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Categorios;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use App\Services\NotificationService;
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
            $Products = $this->productService
               ->getProductsByCategory((int) $categoryId);
        } 
        else {
            $Products = $this->productService->getAllProducts();
        }
        $unreadNotificationsCount = $this->getUnreadNotificationsCount($request);

       return view('productview.index')
            ->with('Products', $Products)
            ->with('unreadNotificationsCount', $unreadNotificationsCount);
    }

    /**
     * Show create product page.
     */
    public function create(Request $request)
    {
        $unreadNotificationsCount =
        $this->getUnreadNotificationsCount($request);

        $categories = Categorios::all();

        return view('productview.create')
           ->with('categories', $categories)
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
        return redirect()->route('Products.index')
            ->with('success', 'Product Added Successfully');
    }

    /**
     * Display a specific product.
     */
    public function show(Request $request, Products $product)
    {
        $unreadNotificationsCount =
            $this->getUnreadNotificationsCount($request);

        return view('productview.show')
            ->with('product', $product)
            ->with('unreadNotificationsCount', $unreadNotificationsCount);
    }

    /**
     * Show edit product page.
     */
    public function edit(Request $request, Products $product)
    {
        $unreadNotificationsCount =
        $this->getUnreadNotificationsCount($request);

        $categories = Categorios::all();

        $product->load('categories');

        return view('productview.edit')
           ->with('product', $product)
           ->with('categories', $categories)
           ->with('unreadNotificationsCount', $unreadNotificationsCount);
    }

    /**
     * Update an existing product.
     */
    public function update(UpdateProductRequest $request,Products $product) 
    {
        $validated = $request->validated();

        $image = $request->file('image');

        $this->productService->updateProduct(
            $product,
            $validated,
            $image?->getRealPath() ?: null,
            $image?->extension()
        );
        return redirect()->route('Products.index')
            ->with('success', 'Product Updated Successfully');
    }

    /**
     * Delete a product.
     */
    public function destroy(Products $product)
    {
        $deleted = $this->productService->deleteProduct($product);

        if (!$deleted) {
            return redirect()->route('Products.index')
                ->with('error', 'Product Could Not be Deleted');
        }

        return redirect()->route('Products.index')
            ->with('success', 'Product Deleted Successfully');
    }

        
    private function getUnreadNotificationsCount(Request $request): int
    {
        return $this->notificationService
            ->getUnreadCount($request->user());
    }

}