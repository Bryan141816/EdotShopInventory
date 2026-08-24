<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $pageLength = $request->input('page_length', 10);

        $inventory = Items::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->paginate($pageLength)
            ->withQueryString();

        $count = Items::count();

        return view('pages.inventory', compact('inventory', 'count'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'string',
            'description' => 'nullable|string',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',

        ]);

        $items = new Items;
        $items->name = $request->input('name');
        $items->sku = $request->input('sku');
        $items->description = $request->input('description');
        $items->cost_price = $request->input('cost_price');
        $items->selling_price = $request->input('selling_price');
        $items->quantity = $request->input('quantity');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('images', config('filesystems.default'));
            $items->image = $path;
        }

        $items->save();

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function destroy(Items $item)
    {
        $disk = config('filesystems.default');

        if ($item->image) {
            Storage::disk($disk)->delete($item->image);
        }

        $item->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }

    public function edit(Request $request, Items $item)
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

        $item->name = $request->input('name');
        $item->sku = $request->input('sku');
        $item->description = $request->input('description');
        $item->cost_price = $request->input('cost_price');
        $item->selling_price = $request->input('selling_price');
        $item->quantity = $request->input('quantity');

        $disk = config('filesystems.default');

        if ($request->boolean('remove_image')) {
            if ($item->image) {
                Storage::disk($disk)->delete($item->image);
            }

            $item->image = null;

        } elseif ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk($disk)->delete($item->image);
            }

            $item->image = $request->file('image')->store('images', $disk);
        }

        $item->save();

        return redirect()->back()->with('success', 'item updated successfully!');
    }
}
