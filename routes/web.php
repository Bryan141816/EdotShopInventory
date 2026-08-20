<?php

use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('pages.home');
    })->name('home');

    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::post('/inventory',[InventoryController::class, 'store'])->name('inventory.store');
    Route::delete('/inventory/{item}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::post('/inventory/{item}', [InventoryController::class, 'edit'])->name('products.edit');
});
