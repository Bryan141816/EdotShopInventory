<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\PartBrands;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $pageLength = $request->input('page_length', 10);

        $brands = PartBrands::query()->when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%");
        })
            ->paginate($pageLength)
            ->withQueryString();

        return view('pages.brands', compact('brands'));
    }

    public function store(BrandRequest $request)
    {
        $brand = new PartBrands;
        $brand->name = strtoupper($request->input('name'));
        $brand->description = $request->input('description');
        $brand->save();

        return redirect()->back()->with('success', 'Brand created successfully');
    }

    public function apiStore(BrandRequest $request)
    {

        $brand = new PartBrands;
        $brand->name = strtoupper($request->input('name'));
        $brand->description = $request->input('description');
        $brand->save();

        return response()->json([
            'brand' => $brand,
        ], 200);

    }

    public function edit(BrandRequest $request, PartBrands $brand)
    {
        $brand->name = $request->input('name');
        $brand->description = $request->input('description');
        $brand->save();

        return redirect()->back()->with('success', 'Brand updated successfully');
    }

    public function destroy(PartBrands $brand)
    {
        $brand->delete();

        return redirect()->back()->with('success', 'Brand deleted successfully');
    }
}
