<?php

namespace App\Http\Controllers;

use App\Models\PartBrands;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
    private function commonStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $brand = new PartBrands;
        $brand->name = strtoupper($request->input('name'));
        $brand->description = $request->input('description');
        $brand->save();

        return $brand;
    }
    public function store(Request $request)
    {
        try {
            $this->commonStore($request);
            return redirect()->back()->with('success', 'Brand added successfully!');
        } catch (ValidationException $e) {
            dd($e);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->with('error', 'Brand with this name already exist');
            }
            return redirect()->back()->with('error', 'An error occured in the database');
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function apiStore(Request $request)
    {
        try {
            $brand = $this->commonStore($request);
            return response()->json([
                'brand' => $brand,
            ], 200);
        } catch (ValidationException $e) {
            dd($e);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json([
                    'success' => false,
                    'message' => 'A brand with this name already exists.',
                ], 409);
            }
            return response()->json([
                'success' => false,
                'message' => 'A database error occurred.',
            ], 500);
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function destroy(PartBrands $brand)
    {
        $brand->delete();
        return redirect()->back()->with('sucess', 'Brand deleted successfully');
    }
}
