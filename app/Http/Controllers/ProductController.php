<?php

namespace App\Http\Controllers;

use App\Events\product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Mail\ProductCreatedMail;
use App\Models\User;
use App\Models\Products;
use App\Notifications\ProductCreatedNotification;
use App\Services\ProductService;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService) 
    {
        //
    }

    public function index()
    {
        $Products = $this->productService->getAllProducts();

        return view('productview.index')
            ->with('Products', $Products);
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

        Mail::to('khalidalomari558@gmail.com')->send(
            new ProductCreatedMail(
                $product->name,
                (int) $product->id
            )
        );

        return redirect()->route('Products.index')
            ->with('success', 'Product added successfully');
    }

    public function show($id)
    {
        $product = $this->productService->getProductById(
            (int) $id
        );

        return view('productview.show')
            ->with('product', $product);
    }

    public function edit(Products $product)
    {
        return view('productview.edit')
            ->with('product', $product);
    }

    public function update(UpdateProductRequest $request, Products $product)
    {
        $validated = $request->validated();

        $this->productService->updateProduct(
            $product,
            $validated,
            $request->file('image')
        );

        return redirect()->route('Products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Products $product)
    {
        $this->productService->deleteProduct($product);

        return redirect()->route('Products.index')
            ->with('success', 'Product deleted successfully');
    }
}
