<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PartBrands;
use App\Models\PartCategory;
class BrandCategoryController extends Controller
{
    public function index(){
        $brands = PartBrands::all();
        $category = PartCategory::all();

        return response()->json([
            "brands" => $brands,
            "category" => $category
        ],200);
    }
}
