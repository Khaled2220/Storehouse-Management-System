<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {
        //
    }

    /**
     * Display all products.
     */
    public function index()
    {
        $products = $this->productService->getAllProducts();

        return ProductResource::collection($products)
            ->additional([
                'status' => true,
                'message' => 'Products retrieved successfully',
            ]);
    }

    /**
     * Store a new product.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $validated['user_id'] = $request->user()->id;

        $image = $request->file('image');

        $product = $this->productService->createProduct(
            $validated,
            $image?->getRealPath(),
            $image?->extension()
        );

        return (new ProductResource($product))
            ->additional([
                'status' => true,
                'message' => 'Product created successfully.',
            ])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['categories', 'user']);

        return (new ProductResource($product))->additional([
            'status' => true,
            'message' => 'Product retrieved successfully.',
        ]);
    }

    /**
     * Update the specified product.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $image = $request->file('image');

        $updatedProduct = $this->productService->updateProduct(
            $product,
            $validated,
            $image?->getRealPath(),
            $image?->extension()
        );

        return (new ProductResource($updatedProduct))->additional([
            'status' => true,
            'message' => 'Product updated successfully.',
        ]);
    }

    /**
     * Delete the specified product.
     */
    public function destroy(Product $product)
    {
        $deleted = $this->productService->deleteProduct($product);

        if (! $deleted) {
            return response()->json([
                'status' => false,
                'message' => 'Product could not be deleted.',
            ], 500);
        }

        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully.',
        ], 200);
    }
}
