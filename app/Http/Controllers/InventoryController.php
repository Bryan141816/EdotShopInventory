<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $inventory = Product::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            })
            ->get();

        return view('pages.inventory', compact('inventory'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'sku' => 'string',
                'description' => 'nullable|string',
                'cost_price' => 'required|numeric|min:0',
                'selling_price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',

            ]);
        } catch (ValidationException $e) {
            dd($e->errors());
        }

        $product = new Product;
        $product->name = $request->input('name');
        $product->sku = $request->input('sku');
        $product->description = $request->input('description');
        $product->cost_price = $request->input('cost_price');
        $product->selling_price = $request->input('selling_price');
        $product->quantity = $request->input('quantity');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('images', 'public');
            $product->image = $path;
        }

        $product->save();

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Item deleted successfully.',
        ]);
    }

    public function edit(Request $request, Product $product)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'sku' => 'string',
                'description' => 'nullable|string',
                'cost_price' => 'required|numeric|min:0',
                'selling_price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'remove_image' => 'nullable|boolean',
            ]);
        } catch (ValidationException $e) {
            dd($e->errors());
        }

        $product->name = $request->input('name');
        $product->sku = $request->input('sku');
        $product->description = $request->input('description');
        $product->cost_price = $request->input('cost_price');
        $product->selling_price = $request->input('selling_price');
        $product->quantity = $request->input('quantity');

        if ($request->boolean('remove_image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->image = null;
        } elseif ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->image = $request->file('image')->store('images', 'public');
        }

        $product->save();

        return redirect()->back()->with('success', 'Product updated successfully!');
    }
}
