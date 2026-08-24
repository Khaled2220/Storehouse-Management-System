<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $Products = Products::latest()->paginate(50);
        return view('productview.index', compact('Products'));
    }

    public function create()
    {
        return view('productview.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string',
            'quantity'    => 'required|integer',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);
        
        $imagename = null;
        if ($request->hasFile('image')) {
            $imagename = time() . '.' . $request->image->extension();
            $request->image->move(public_path('image'), $imagename);
        }
        
        Products::create([   
            'name'        => $validated['name'],
            'quantity'    => $validated['quantity'],
            'description' => $validated['description'],
            'price'       => $validated['price'],
            'image'       => $imagename,
        ]);

        return redirect()->to('/Products')->with('success', 'Product added successfully');
    }

    public function show($id)
    {
        $product = Products::findOrFail($id);
        return view('productview.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Products::findOrFail($id);
        return view('productview.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string',
            'quantity'    => 'required|integer',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $imagename = $product->image;

        if ($request->hasFile('image')) {
            if ($product->image && File::exists(public_path('image/' . $product->image))) {
                File::delete(public_path('image/' . $product->image));
            }            
            $imagename = time() . '.' . $request->image->extension();
            $request->image->move(public_path('image'), $imagename);
        } 
         
        $product->update([
            'name'        => $validated['name'],
            'quantity'    => $validated['quantity'],
            'description' => $validated['description'],
            'price'       => $validated['price'],
            'image'       => $imagename,
        ]);

        return redirect()->to('/Products')->with('success', 'Product updated successfully');
    }   

    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        
        if ($product->image && File::exists(public_path('image/' . $product->image))) {
            File::delete(public_path('image/' . $product->image));
        }

        $product->delete();

        return redirect()->to('/Products')->with('success', 'Product deleted successfully');
    }
}
