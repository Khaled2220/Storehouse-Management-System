<?php

namespace App\Http\Controllers;

use App\Events\product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService) 
    {
        //
    }

    public function index()
    {
        $Products = $this->productService->getAllProducts();

        return view('productview.index', compact('Products'));
    }

    public function create()
    {
        return view('productview.create');
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $product = $this->productService->createProduct(
            $validated,
            $request->file('image')
        );
        event(new product($product));

        User::where('user_type', 1)->each(function ($user) use ($product) {
            $user->notify(
                new ProductCreatedNotification(
                    $product->name,
                    (int) $product->id
                )
            );
        });

        return redirect()->to('/Products')
            ->with('success', 'Product added successfully');
    }

    public function show($id)
    {
        $product = $this->productService->getProductById((int) $id);

        return view('productview.show', compact('product'));
    }

    public function edit($id)
    {
        $product = $this->productService->getProductById((int) $id);

        return view('productview.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->productService->getProductById((int) $id);

        $validated = $request->validated();

        $this->productService->updateProduct(
            $product,
            $validated,
            $request->file('image')
        );

        return redirect()->to('/Products')
            ->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = $this->productService->getProductById((int) $id);

        $this->productService->deleteProduct($product);

        return redirect()->to('/Products')
            ->with('success', 'Product deleted successfully');
    }
}
