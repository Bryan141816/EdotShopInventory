<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
Route::post('/inventory', [InventoryController::class, 'store'])->name('products.store');
Route::delete('/inventory/{product}', [InventoryController::class, 'destroy'])->name('products.destroy');
Route::post('/inventory/{product}/edit', [InventoryController::class, 'edit'])->name('products.edit');