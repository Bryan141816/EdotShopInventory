<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class InventoryController extends Controller
{
    public function index()
    {
        $inventory = Product::all();
        return view('pages.inventory', compact('inventory'));
    }
}
