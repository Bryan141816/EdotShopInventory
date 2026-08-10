<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
