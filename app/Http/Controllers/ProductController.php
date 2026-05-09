<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Services\ProductService;
use App\Http\Requests\Product\CreateProductRequest; 
use App\Http\Requests\Product\UpdateProductRequest; 

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function __construct(protected ProductService $productService)
    {
        $this->productService = $productService;
    }
    
    public function index(Request $request)
    {
        $categoryId=$request->input('category');

        $products = $this->productService->getAll($categoryId);

        $categories = Category::all(); 
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
         $categories = Category::all();

        return view('products.form', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->productService->update($product, $request->validated());

        return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->productService->delete($product);

        return redirect()->route('products.index')->with('success', 'Producto eliminado para siempre');
    }
}
