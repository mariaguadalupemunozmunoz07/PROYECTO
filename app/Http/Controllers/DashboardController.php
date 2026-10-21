<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Un libro está "por agotarse" si le quedan entre 1 y este número de ejemplares
    private const UMBRAL_BAJO = 2;

    public function index()
    {
        $agotados = collect();
        $porAgotarse = collect();
        $totalLibros = 0;

        if (Auth::user()->role === 'admin') {
            $agotados = Libro::with('categoria')
                ->where('cantidad_disponible', 0)
                ->orderBy('titulo')
                ->get();

            $porAgotarse = Libro::with('categoria')
                ->whereBetween('cantidad_disponible', [1, self::UMBRAL_BAJO])
                ->orderBy('cantidad_disponible')
                ->orderBy('titulo')
                ->get();

            $totalLibros = Libro::count();
        }

        $umbral = self::UMBRAL_BAJO;

        return view('dashboard', compact('agotados', 'porAgotarse', 'totalLibros', 'umbral'));
    }
}