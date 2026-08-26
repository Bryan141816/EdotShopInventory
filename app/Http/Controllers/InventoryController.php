<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryRequest;
use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $pageLength = $request->input('page_length', 10);

        $inventory = Items::with(['brand', 'category'])
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->paginate($pageLength)
            ->withQueryString();

        return view('pages.inventory', compact('inventory'));
    }

    public function store(InventoryRequest $request)
    {

        $items = new Items;
        $items->name = $request->input('name');
        $items->sku = $request->input('sku');
        $items->description = $request->input('description');
        $items->cost_price = $request->input('cost_price');
        $items->selling_price = $request->input('selling_price');
        $items->quantity = $request->input('quantity');
        $items->brand_id = $request->input('brand_id');
        $items->category_id = $request->input('category_id');

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

    public function edit(InventoryRequest $request, Items $item)
    {

        $item->name = $request->input('name');
        $item->sku = $request->input('sku');
        $item->description = $request->input('description');
        $item->cost_price = $request->input('cost_price');
        $item->selling_price = $request->input('selling_price');
        $item->quantity = $request->input('quantity');
        $item->brand_id = $request->input('brand_id');
        $item->category_id = $request->input('category_id');

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
