<?php

namespace App\Http\Controllers\API;

use App\Models\Products;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
     public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth('sanctum')->check() && auth('sanctum')->user()->user_type !== 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized access! Admin only.'
                ], 403);
            }
            return $next($request);
        })->except(['index', 'show']);
    }




    public function index()
    {
        $products = Products::with('categories', 'user')->latest()->paginate(50);
        return response()->json([
            'status' => true,
            'message' => 'Products retrieved successfully',
            'data' => $products
        ], 200);
    }
  

    public function store(ProductRequest $request)
    {
       // $validator = Validator::make($request->all(), [
        //    'name' => ['required', 'string'],
        //    'quantity' => ['required', 'integer', 'min:1'],
        //    'description' => ['nullable', 'string'],
        //    'price' => ['required', 'numeric', 'min:1'],
        //    'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif']
       // ]);
        //  if ($validator->fails()) {
         //   return response()->json([
          //      'status' => false,
           //     'message' => 'Validation error.',
           //     'errors' => $validator->errors()
          //  ], 422);
        //}

        $validated = $request->validated();        
        $imagename = null;
        if ($request->hasFile('image')) {
            $imagename = time() . '.' . $request->image->extension();
            $request->image->move(public_path('image'), $imagename);
        }
    
       $product = Products::create([
            'user_id' => auth('sanctum')->id(),
            'name' => $validated->name,
            'quantity' => $validated->quantity,
            'description' => $validated->description,
            'price' => $validated->price,
            'image' => $imagename,
        ]);
          
        return response()->json([
            'status' => true,
            'message' => 'Product created successfully.',
            'data' => $product
        ], 201);
} 

    public function show($id)
    {
        $product = Products::with('categories', 'user')->find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Product retrieved successfully.',
            'data' => $product
        ], 200);           

    }


     public function update(ProductRequest $request, $id)
     {
        $product = Products::find($id);

        if (!$product) {
           return response()->json([
              'status' => false,
              'message' => 'Product not found.'
           ], 404);
        }

      //    $validator = Validator::make($request->all(), [
       //     'name' => ['required', 'string'],
       //     'quantity' => ['required', 'integer', 'min:1'],
       //     'description' => ['nullable', 'string'],
       //     'price' => ['required', 'numeric', 'min:1'],
       //     'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif']
      //  ]);

       // if ($validator->fails()) {
        //    return response()->json([
          //      'status' => false,
            //    'message' => 'Validation error.',
            //    'errors' => $validator->errors()
           // ], 422);
        //}

        $validated = $request->validated();
        $imagename = $product->image;

        if ($request->hasFile('image')) {
             if ($product->image && File::exists(public_path('image/' . $product->image))) {
                File::delete(public_path('image/' . $product->image));
            }

            $imagename = time() . '.' . $request->image->extension();
            $request->image->move(public_path('image'), $imagename);
        }
       
        $product->update([
            'name' => $validated->name,
            'quantity' => $validated->quantity,
            'description' => $validated->description,
            'price' =>$validated->price,
            'image' => $imagename,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }

    public function destroy($id)
    {
         $product = Products::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found.'
            ], 404);
        }
       $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully.'
        ], 200);
    }
}