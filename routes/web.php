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

    Route::get('/inventory/products', [InventoryController::class, 'index'])->name('inventory.products');
    Route::post('/inventory/products', [InventoryController::class, 'store'])->name('inventory.products.store');
    Route::delete('/inventory/products/{item}', [InventoryController::class, 'destroy'])->name('inventory.products.destroy');
    Route::patch('/inventory/products/{item}', [InventoryController::class, 'edit'])->name('inventory.products.edit');

    Route::get('/api/brand_category', [BrandCategoryController::class, 'index'])->name('inventory.brand_category');

    Route::get('/inventory/brands', [BrandController::class, 'index'])->name('inventory.brands');
    Route::post('/inventory/brands', [BrandController::class, 'store'])->name('inventory.brands.store');
    Route::post('/api/inventory/brands', [BrandController::class, 'apiStore'])->name('inventory.brand.api_store');
    Route::delete('/inventory/brands/{brand}', [BrandController::class, 'destroy'])->name('inventory.brand.destroy');
    Route::patch('/inventory/brands/{brand}', [BrandController::class, 'edit'])->name('inventory.brand.edit');

    Route::get('/inventory/category', [CategoryController::class, 'index'])->name('inventory.category');
    Route::post('/inventory/category', [CategoryController::class, 'store'])->name('inventory.category.store');
    Route::post('/api/inventory/category', [CategoryController::class, 'apiStore'])->name('inventory.category.api_store');
    Route::delete('/inventory/category/{category}', [CategoryController::class, 'destroy'])->name('inventory.category.destroy');
    Route::patch('/inventory/category/{category}', [CategoryController::class, 'edit'])->name('inventory.category.edit');

});
