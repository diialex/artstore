<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Services\ProductService;
use App\Http\Requests\Product\CreateProductRequest; 
use App\Http\Requests\Product\UpdateProductRequest; 
use Cache;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function __construct(protected ProductService $productService, protected CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }
    
    public function index(Request $request)
    {
        $categoryId=$request->input('category');
        
        $categories = Cache::rememberForever("categories:all", fn() => $this->categoryService->getAll());

        if ($categoryId != nullOrEmptyString()){
            $products = Cache::remember("products:{$categoryId}", 3600, fn() => $this->productService->getAll($categoryId));
        }else{
            $products = Cache::rememberForever("products:all", fn() => $this->productService->getAll());
        }
        
        return view('products.index', compact('products', 'categories', 'categoryId')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $product = new Product(); 

        return view('products.form', compact('product', 'categories')); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
    
        $data= $request->validated();
        if(isset($data['image'])){
            $data['image'] = $request->file('image')->store('public/media/imgProd');
        }
        $this->productService->create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('sizes'); 
    
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Cache::rememberForever("categories:all", fn() => $this->categoryService->getAll());

        Cache::forget('productos:all');

        return view('products.form', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->productService->update($product, $request->validated());

        Cache::forget('productos:all');

        return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->productService->delete($product);

        Cache::forget('productos:all');

        return redirect()->route('products.index')->with('success', 'Producto eliminado para siempre');
    }
}
