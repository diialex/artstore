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

    public function categories()
    {
        return $this->belongsToMany(Category::class);

    }
    
    public function index(Request $request)
    {
        $categoryId=$request->input('category'); // Obtener el ID de la categoría desde la query string

        $products = $this->productService->getAll($categoryId);

        $categories = Category::all(); // Obtener todas las categorías para el filtro   
        return view('products.index', compact('products', 'categories', 'categoryId')); // Pasamos también el categoryId para mantener el filtro seleccionado
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all(); // Obtener todas las categorías para el select
        $product = new Product(); // Creamos un producto vacío para reutilizar el formulario de edición

        return view('products.form', compact('product', 'categories')); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
    

        $this->productService->create($request->validated());

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
         $categories = Category::all(); // Obtener todas las categorías para el select

        return view('products.form', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // 1. Mandamos el producto y los datos limpios al Servicio
        $this->productService->update($product, $request->validated());

        // 2. Redirigimos al catálogo con un mensaje de éxito
        return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // 1. Mandamos el producto al Servicio para que lo aniquile
        $this->productService->delete($product);

        // 2. Redirigimos al catálogo
        return redirect()->route('products.index')->with('success', 'Producto eliminado para siempre');
    }
}
