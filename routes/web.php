<?php

use App\Http\Controllers\BrandCategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('pages.home');
    })->name('home');

    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::delete('/inventory/{item}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::post('/inventory/{item}', [InventoryController::class, 'edit'])->name('products.edit');
    Route::get('/brands', [BrandController::class, 'index'])->name('brands');
    Route::post('/api/brands', [BrandController::class, 'apiStore'])->name('brand.store');
    Route::delete('/brands/{brand}',[BrandController::class, 'destroy'])->name('brand.destroy');
    Route::get('/category', [CategoryController::class, 'index'])->name('category');
    Route::post('/api/category', [CategoryController::class, 'store'])->name('category.store');
    
});
Route::get('/api/brand_category', [BrandCategoryController::class, 'index'])->name('brand_category');
