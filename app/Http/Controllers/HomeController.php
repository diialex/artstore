<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(): View
    {
        

        $categories = Category::all(); // Obtener todas las categorías para mostrar en la vista

        return view('welcome', ['categories' => $categories]);
    }
}
