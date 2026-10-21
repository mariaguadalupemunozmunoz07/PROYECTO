<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\MultaController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/catalogo', [LibroController::class, 'catalogo'])->name('catalogo');

    Route::post('/libros/{libro}/apartar', [PrestamoController::class, 'apartar'])->name('prestamos.apartar');
    Route::get('/mis-prestamos', [PrestamoController::class, 'misPrestamos'])->name('prestamos.mis');
    Route::get('/mis-multas', [MultaController::class, 'misMultas'])->name('multas.mis');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('categorias', CategoriaController::class);
    Route::resource('libros', LibroController::class);

    Route::get('/prestamos', [PrestamoController::class, 'index'])->name('prestamos.index');
    Route::get('/prestamos/{prestamo}/editar', [PrestamoController::class, 'edit'])->name('prestamos.edit');
    Route::put('/prestamos/{prestamo}', [PrestamoController::class, 'update'])->name('prestamos.update');
    Route::patch('/prestamos/{prestamo}/devolver', [PrestamoController::class, 'devolver'])->name('prestamos.devolver');

    Route::get('/multas', [MultaController::class, 'index'])->name('multas.index');
    Route::patch('/multas/{multa}/pagar', [MultaController::class, 'pagar'])->name('multas.pagar');
});

require __DIR__.'/auth.php';