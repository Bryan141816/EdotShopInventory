<?php

namespace App\Http\Controllers;

use App\Models\PartCategory;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
    private function commonStore(Request $request)
    {
        $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);

        $category = new PartCategory();
        $category->name = strtoupper($request->input('name'));
        $category->description = $request->input('description');
        $category->save();
    }
    public function store(Request $request)
    {
        try {
            $this->commonStore($request);
            return redirect()->back()->with('success', 'Category added successfully!');
        } catch (ValidationException $e) {
            dd($e);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->with('error', 'Category with this name already exist');
            }
            return redirect()->back()->with('error', 'An error occured in the database');
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function apiStore(Request $request)
    {
        try {
            $category = $this->commonStore($request);
            return response()->json([
                "category" => $category
            ], 200);
        } catch (ValidationException $e) {
            dd($e);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json([
                    'success' => false,
                    'message' => 'A category with this name already exists.',
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
    public function destroy(PartCategory $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');
    }
}
