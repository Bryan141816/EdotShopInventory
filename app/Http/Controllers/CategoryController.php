<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\PartCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $pageLength = $request->input('page_length', 10);

        $category = PartCategory::query()->when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%");
        })
            ->paginate($pageLength)
            ->withQueryString();

        return view('pages.category', compact('category'));
    }

    public function store(CategoryRequest $request)
    {

        $category = new PartCategory;
        $category->name = strtoupper($request->input('name'));
        $category->description = $request->input('description');
        $category->save();

        return redirect()->back()->with('success', 'Category added successfully!');

    }

    public function apiStore(CategoryRequest $request)
    {

        $category = new PartCategory;
        $category->name = strtoupper($request->input('name'));
        $category->description = $request->input('description');
        $category->save();

        return response()->json([
            'category' => $category,
        ], 200);

    }

    public function edit(CategoryRequest $request, PartCategory $category)
    {

        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->save();

        return redirect()->back()->with('success', 'Category updated successfully');
    }

    public function destroy(PartCategory $category)
    {
        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully');
    }
}
