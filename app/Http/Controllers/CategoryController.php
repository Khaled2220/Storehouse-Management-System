<?php

namespace App\Http\Controllers;

use App\Models\Categorios;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\File;
//use Illuminate\Support\Facades\Auth;


//use Illuminate\Routing\Controllers\HasMiddleware;
//use Illuminate\Routing\Controllers\Middleware; 

class CategoryController extends Controller
{
    public $category;


  //   public function __construct()
   // {
    //    $this->middleware(function ($request, $next) {
   //         if (Auth::check() && Auth::user()->user_type !== 1) {
     //           return redirect()->route('Products.index')->with('error', 'Unauthorized access! Admin only.');
    //        }
     //       return $next($request);
    //    })->except(['index', 'show']);
  //  }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorios = Categorios::all();
        return view('categoryview.index', compact('categorios'));
        //return  redirect()->route('   Categorios.index',compact('categories'));
      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return redirect()->route('   Categorios.create');
         return view('categoryview.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
            'name' => ['required', 'string']
        ]);
        
           Categorios::create([
            'name' => $validated['name']
        ]);
         return redirect()->route('Categorios.index')->with('success', 'Category added successfully');
    }
    
    /** 
     *Display the specified resource.
     */
    public function show($id)
    {
        //return Categorios::findOrFail($id);
        $category = Categorios::findOrFail($id);
        return view('categoryview.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Categorios::findOrFail($id);
        //return redirect()->route('   Categorios.edit',compact('category'));
        return view('categoryview.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $category = Categorios::findOrFail($id);
         $validated = $request->validate([
         'name' => ['required', 'string']
         ]);
         $category->update([
            'name' => $validated['name']
         ]);
         return redirect()->route('Categorios.index')->with('success', 'Category updated successfully');
    }

    /*
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         $category = Categorios::findOrFail($id);
         if($category->products()->exists()) {
            return redirect()->route('Categorios.index')->with('error', 'Category cannot be deleted because it has linked products');
        }
        $category->delete();
         return redirect()->route('Categorios.index')->with('success', 'Category deleted successfully');

    }
}    