<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Featuredcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FeaturedcategoryController extends Controller
{
    //--------------------- index function code start ----------------------
    public function index()
    {
        $featuredCategories = Featuredcategory::all();
        return view('admin.featured-category.index', compact('featuredCategories'));
    }
    //--------------------- index function code end ----------------------

    //--------------------- create function code start ----------------------
    public function create()
    {
        $categories = Category::all();
        return view('admin.featured-category.create', compact('categories'));
    }
    //--------------------- create function code end ----------------------

    //--------------------- store function code start ----------------------
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category_ids' => 'required|array',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'boolean',
        ]);
        $validatedData['status'] = $request->has('status');

        FeaturedCategory::create($validatedData);

        return redirect()->route('featured.category.index')->with('success', 'Featured Category created successfully.');
    }
    //--------------------- store function code end ----------------------

    //--------------------- edit function code start ----------------------
    public function edit($id)
    {
        $featuredCategory = Featuredcategory::findOrFail($id);
        $categories = Category::all();
        return view('admin.featured-category.edit', compact('featuredCategory', 'categories'));
    }
    //--------------------- edit function code end ----------------------

    //--------------------- update function code start ----------------------
    public function update(Request $request, $id)
    {
        $featuredCategory = Featuredcategory::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category_ids' => 'required|array',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'boolean',
        ]);
        $validatedData['status'] = $request->has('status');

        $featuredCategory->update($validatedData);

        return redirect()->route('featured.category.index')->with('success', 'Featured Category updated successfully.');
    }
    //--------------------- update function code end ----------------------

    //--------------------- destroy function code start ----------------------
    public function destroy($id)
    {
        $featuredCategories = Featuredcategory::findOrFail($id);
        $featuredCategories->delete();
        return redirect()->route('featured.category.index')->with('success', 'Featured Category Deleted successfully.');
    }
    //--------------------- destroy function code end ----------------------

    //--------------------- toggleStatus function code start ----------------------
    public function toggleStatus(Request $request, $id)
    {
        $category = FeaturedCategory::findOrFail($id);
        $now = Carbon::now();

        if ($now->lt($category->start_date)) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot activate. The start date has not been reached yet.'
            ]);
        }

        if ($now->gt($category->end_date)) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot activate. The end date has passed.'
            ]);
        }

        $category->status = 1;  // We're only allowing activation here
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category activated successfully'
        ]);
    }
    //--------------------- toggleStatus function code end ----------------------
}
