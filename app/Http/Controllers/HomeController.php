<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = [
            [
                'name' => 'Mujeres',
                'video' => 'media/video/mujeresMain.mp4'
            ],
            [
                'name' => 'Hombres',
                'video' => 'media/video/hombresMain.mp4'
            ],
            [
                'name' => 'Colecciones',
                'video' => 'media/video/colecciones.mp4'
            ],
            [
                'name' => 'Accesorios',
                'video' => 'media/video/accesorios.mp4'
            ]
        ];

        return view('welcome', ['categories' => $categories]);
    }
}
