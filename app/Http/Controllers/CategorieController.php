<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Schema;
use App\Models\Quiz;
use App\Models\GeneralSetting;

class CategorieController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:category.view', ['only' => ['index','import']]);
        $this->middleware('permission:category.create', ['only' => ['Category','importSave']]);
        // $this->middleware('permission:category.edit', ['only' => ['editCategory', 'updateStatus']]);
        $this->middleware('permission:category.delete', ['only' => ['bulk_delete','deleteCategory']]);
    }
    //------------------- Category start --------------------------------
    public function index(Request $request)
    {
        $categories = Category::all();

        if ($request->isMethod('get')) {
            return view('admin.category.index', compact('categories'));
        }
        try {
            if ($request->isMethod('post')) {
                $validator = $request->validate([
                    'name' => 'required',
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'icon' => 'nullable',
                    'slug' => 'required|unique:categories',
                    'parent_id' => 'nullable|numeric',
                    'categorytype' => 'required',
                ]);

                // Handle image upload
                $imagePath = '';
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . 'image.' . $extension;
                    $file->move(public_path('images/category'), $filename);
                    $imagePath = 'images/category/' . $filename;
                }

                // Create or update category based on categorytype
                if ($request->categorytype == -1) {
                    $category = new Category();
                    $category->name = $request->name;
                    $category->slug = $request->slug;
                    $category->icon = $request->icon;
                    $category->parent_id = $request->parent_id ?? '-1';
                    $category->description = $request->description;
                    $category->status = $request->has('status') ? 1 : 0;
                    $category->image = $imagePath;
                    $category->save();
                }

                // Create or update category based on categorytype
                elseif ($request->categorytype == 'sub') {
                    SubCategory::create([
                        'name' => $request->name,
                        'slug' => $request->slug,
                        'category_id' => $request->parent_id,
                        'description' => $request->description,
                        'status' => $request->boolean('status'),
                    ]);
                } else {
                    ChildCategory::create([
                        'name' => $request->name,
                        'slug' => $request->slug,
                        'sub_category_id' => $request->sub_category_id,
                        'description' => $request->description,
                        'status' => $request->boolean('status'),
                    ]);
                }

                return redirect()->back()->with('success','Category has been created successfully.');
            }
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while creating the category: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //------------------- Category end --------------------------------

    //------------------- handling form submit for category and subcategory --------------------------------
    public function store(Request $request)
{
    try {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icon' => 'nullable',
            'slug' => 'required|unique:categories',
            'parent_id' => 'nullable|numeric',
            'categorytype' => 'required',
        ]);

        // Handle image upload
        $imagePath = '';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'image.' . $extension;
            $file->move(public_path('images/category'), $filename);
            $imagePath = 'images/category/' . $filename;
        }

        // Create based on type
        if ($request->categorytype == -1) {
            Category::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'icon' => $request->icon,
                'parent_id' => $request->parent_id ?? -1,
                'description' => $request->description,
                'status' => $request->has('status') ? 1 : 0,
                'image' => $imagePath,
            ]);
        } elseif ($request->categorytype == 'sub') {
            SubCategory::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'category_id' => $request->parent_id,
                'description' => $request->description,
                'status' => $request->boolean('status'),
            ]);
        } else {
            ChildCategory::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'sub_category_id' => $request->sub_category_id,
                'description' => $request->description,
                'status' => $request->boolean('status'),
            ]);
        }

        return redirect()->back()->with('success', 'Category created successfully.');
    } catch (\Exception $e) {
        return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
    }
}
    //------------------- handling form submit for category and subcategory end --------------------------------

    //------------------- Category import start --------------------------------
    public function import()
    {
        return view('admin.category.import');
    }
    //------------------- Category import end --------------------------------

    //------------------- Category edit start --------------------------------
    public function editCategory($id, Request $request)
    {
           $editcategory = Category::findOrFail($id);
        if($request->method()=='GET')
        {
            $categories =  Category::all();
            return view('admin.category.index', compact('editcategory', 'categories'));
         }

    }
    //------------------- Category edit end --------------------------------

    //------------------- subCategory edit start  --------------------------------
    public function editSubCategory($id, Request $request)
    {
        $editcategory = SubCategory::findOrFail($id);
        if($request->method()=='GET')
        {
            $categories = Category::all();
            return view('admin.category.index', compact('editcategory', 'categories'));
        }

    }
    //------------------- subCategory edit end  --------------------------------

    //------------------- childCategory edit start  --------------------------------
    public function editChildCategory($id, Request $request)
    {
        $editcategory = ChildCategory::findOrFail($id);
        if($request->method()=='GET')
        {
            $categories = Category::all();
            return view('admin.category.index', compact('editcategory', 'categories'));
        }

    }
    //------------------- childCategory edit end --------------------------------

    //------------------- Category category start --------------------------------
    public function UpdateCategory(Request $request)
{
    try {
        if ($request->categorytype == -1) {
            $category = Category::findOrFail($request->id);

            $request->validate([
                'name' => 'required',
                'slug' => 'required',
            ]);

            if ($request->name != $category->name || $request->parent_id != $category->parent_id) {
                $checkDuplicate = Category::where('name', $request->name)
                    ->where('parent_id', $request->parent_id ?? -1)
                    ->where('id', '!=', $request->id)
                    ->first();

                if ($checkDuplicate) {
                    return redirect()->back()->with('error', 'Category already exists with this name in this parent.');
                }
            }

            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->description = $request->description;
            $category->status = $request->has('status') ? 1 : 0;

            if (Schema::hasColumn('categories', 'icon')) {
                $category->icon = $request->icon;
            }

            $category->save();
            return redirect('admin/category')->with('success', 'Category has been updated successfully.');
        }

        if ($request->categorytype == 'sub') {
            $category = SubCategory::findOrFail($request->id);

            $request->validate([
                'name' => 'required',
                'slug' => ['required', Rule::unique('sub_categories')->ignore($category->id)],
            ]);

            if ($request->name != $category->name || $request->parent_id != $category->parent_id) {
                $checkDuplicate = SubCategory::where('name', $request->name)
                    ->where('category_id', $request->parent_id ?? -1)
                    ->where('id', '!=', $request->id)
                    ->first();

                if ($checkDuplicate) {
                    return redirect()->back()->with('error', 'Category already exists with this name in this parent.');
                }
            }

            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->category_id = $request->parent_id;
            $category->description = $request->description;
            $category->status = $request->has('status') ? 1 : 0;

            if (Schema::hasColumn('sub_categories', 'icon')) {
                $category->icon = $request->icon;
            }

            $category->save();
            return redirect('admin/category')->with('success', 'Category has been updated successfully.');
        }

        if ($request->categorytype == 'child') {
            $category = ChildCategory::findOrFail($request->id);

            $request->validate([
                'name' => 'required',
                'slug' => ['required', Rule::unique('child_categories')->ignore($category->id)],
            ]);

            if ($request->name != $category->name || $request->parent_id != $category->parent_id) {
                $checkDuplicate = ChildCategory::where('name', $request->name)
                    ->where('parent_id', $request->parent_id ?? -1)
                    ->where('id', '!=', $request->id)
                    ->first();

                if ($checkDuplicate) {
                    return redirect()->back()->with('error', 'Category already exists with this name in this parent.');
                }
            }

            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->sub_category_id = $request->sub_category_id;
            $category->description = $request->description;
            $category->status = $request->has('status') ? 1 : 0;

            if (Schema::hasColumn('child_categories', 'icon')) {
                $category->icon = $request->icon;
            }

            $category->save();
            return redirect('admin/category')->with('success', 'Category has been updated successfully.');
        }
    } catch (\Exception $e) {
        $errorMessage = 'An error occurred while creating the category: ' . $e->getMessage();
        return back()->with('error', $errorMessage)->withInput();
    }
}
    //------------------- Category category end --------------------------------


    //------------------- Category status start --------------------------------
    public function categoryStatus(Request $request)
    {
        // return $request;
        $category = Category::find($request->id);
        $category->status = $request->status;
        $category->save();
        return response()->json(['message' => 'Status changed successfully'], 200);
    }
    //------------------- Category status end --------------------------------

    //------------------- subCategory status start --------------------------------
    public function subcategoryStatus(Request $request)
    {
        // return $request;
        $category = SubCategory::find($request->id);
        $category->status = $request->status;
        $category->save();
        return response()->json(['message' => 'Status changed successfully'], 200);
    }
    //------------------- subCategory status end --------------------------------

    //------------------- childCategoryStatus start --------------------------------
    public function childcategoryStatus(Request $request)
    {
        // return $request;
        $category = ChildCategory::find($request->id);
        $category->status = $request->status;
        $category->save();
        return response()->json(['message' => 'Status changed successfully'], 200);

    }
    //------------------- childCategoryStatus end --------------------------------

    //------------------- deleteCategory start --------------------------------
    public function deleteCategory($id)
    {   try{
            $category = Category::findOrFail($id);

            $subcategories = $category->subcategories;

            foreach($subcategories as $cat)
            {
                $cat = SubCategory::findOrFail($cat->id);

                $children = ChildCategory::all();

                foreach ($children as $childcategory) {
                    // Check if sub_category_id is an array and if the current category ID exists in it

                    if (is_array($childcategory->sub_category_id) && in_array($cat->id, $childcategory->sub_category_id)) {
                        // Remove the subcategory ID from the array
                        $childcategory->sub_category_id = array_diff($childcategory->sub_category_id, [$cat->id]);

                        // Check if sub_category_id is empty after removing the category ID
                        if (empty($childcategory->sub_category_id)) {
                            // Delete the row if sub_category_id is empty
                            $childcategory->delete();
                        } else {
                            // Save the updated child category if sub_category_id is not empty
                            $childcategory->save();
                        }
                    }
                }
                $cat->delete();
            }

            $category->delete();
            return redirect()->back()->with('delete','Category has been deleted successfully.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the category: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //------------------- deleteCategory end --------------------------------

    //------------------- deleteSubCategory start --------------------------------
    public function deleteSubCategory($id)
    {
        try{
            $cat = SubCategory::findOrFail($id);

                $children = ChildCategory::all();

                foreach ($children as $childcategory) {
                    // Check if sub_category_id is an array and if the current category ID exists in it

                    if (is_array($childcategory->sub_category_id) && in_array($cat->id, $childcategory->sub_category_id)) {
                        // Remove the subcategory ID from the array
                        $childcategory->sub_category_id = array_diff($childcategory->sub_category_id, [$cat->id]);

                        // Check if sub_category_id is empty after removing the category ID
                        if (empty($childcategory->sub_category_id)) {
                            // Delete the row if sub_category_id is empty
                            $childcategory->delete();
                        } else {
                            // Save the updated child category if sub_category_id is not empty
                            $childcategory->save();
                        }
                    }
                }
                $cat->delete();

                Flash::error()->important();

            return redirect()->back()->with('delete','Category has been deleted successfully.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the category: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //------------------- deleteSubCategory end --------------------------------

    //------------------- deleteChildCategory start --------------------------------
    public function deleteChildCategory($id, Request $request)
    {
        try{
            $cat = ChildCategory::findOrFail($id);
            $subcategories = $cat->sub_category_id; // Decode JSON string to array

            // Check if sub_category_id is an array and if the current category ID exists in it
            if (is_array($subcategories) && in_array($request->subcategory_id, $subcategories)) {
                // Remove the subcategory ID from the array
                $catsub_category_id = array_diff($subcategories, [$request->subcategory_id]);

                // Check if sub_category_id is empty after removing the category ID
                if (empty($catsub_category_id)) {
                    // Delete the row if sub_category_id is empty
                    $cat->delete();
                } else {
                    // Update the sub_category_id property of $cat
                    $cat->sub_category_id = $catsub_category_id; // Store as array, not JSON-encoded string
                    // Save the updated child category if sub_category_id is not empty
                    $cat->save();
                }
            } else {
                // Handle the case where the requested subcategory ID is not found in the subcategories array
                // You may throw an exception, return an error response, or perform any other appropriate action.
            }
            return redirect()->back()->with('delete','Category has been deleted successfully.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the category: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //------------------- deleteChildCategory end --------------------------------

    //------------------- bulk_DELETE start --------------------------------
    public function bulk_delete(Request $request)
    {
        try{
            $categoryIds = $request->input('checked');
            // return $categoryIds;
            if (empty($categoryIds)) {
                return back()->with('warning', 'Atleast one item is required to be checked');
            }

            Category::whereIn('id', $categoryIds)->with('subcategories')->get()->each(function ($category) {
                foreach ($category->subcategories as $subcategory) {

                    $children = ChildCategory::all();

                    foreach ($children as $childcategory) {
                        // Check if sub_category_id is an array and if the current category ID exists in it

                        if (is_array($childcategory->sub_category_id) && in_array($subcategory->id, $childcategory->sub_category_id)) {
                            // Remove the subcategory ID from the array
                            $childcategory->sub_category_id = array_diff($childcategory->sub_category_id, [$subcategory->id]);

                            // Check if sub_category_id is empty after removing the category ID
                            if (empty($childcategory->sub_category_id)) {
                                // Delete the row if sub_category_id is empty
                                $childcategory->delete();
                            } else {
                                // Save the updated child category if sub_category_id is not empty
                                $childcategory->save();
                            }
                        }
                    }
                }
                $category->subcategories->each->delete();
                $category->delete();
            });

            return redirect('admin/category')->with('delete','Data has been deleted successfully.');
        }
        catch (\Exception $e) {
                $errorMessage = 'An error occurred while deleting the category: ' . $e->getMessage();
                return back()->with('error', $errorMessage)->withInput();
            }
    }
    //------------------- bulk_DELETE end --------------------------------

    //------------------- subCategory_bulk_delete start --------------------------------
    public function subcategory_bulk_delete(Request $request)
    {
        try{
            $categoryIds = $request->input('checked');

            if (empty($categoryIds)) {
                return back()->withErrors(['message' => 'At least one item is required to be checked']);
            }

            SubCategory::whereIn('id', $categoryIds)->get()->each(function ($subcategory) {

                $children = ChildCategory::all();

                foreach ($children as $childcategory) {
                    // Check if sub_category_id is an array and if the current category ID exists in it
                    if (is_array($childcategory->sub_category_id) && in_array($subcategory->id, $childcategory->sub_category_id)) {
                        // Remove the subcategory ID from the array
                        $childcategory->sub_category_id = array_diff($childcategory->sub_category_id, [$subcategory->id]);

                        // Check if sub_category_id is empty after removing the category ID
                        if (empty($childcategory->sub_category_id)) {
                            // Delete the row if sub_category_id is empty
                            $childcategory->delete();
                        } else {
                            // Save the updated child category if sub_category_id is not empty
                            $childcategory->save();
                        }
                    }
                }

                $subcategory->delete();
            });

            return redirect('admin/category')->with('delete','Data has been deleted successfully.');
        }catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the category: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //------------------- subCategory_bulk_delete end --------------------------------


    //------------------- childCategory_bulk_delete start --------------------------------
    public function childcategory_bulk_delete(Request $request)
    {
        try{
            $categoryIds = $request->input('checked');
            $subcategory_ids = $request->input('subcategory_id');

            if (empty($categoryIds)) {
                return back()->withErrors(['message' => 'At least one item is required to be checked']);
            }

            ChildCategory::whereIn('id', $categoryIds)->get()->each(function ($subcategory) use ($subcategory_ids) {
                // Check if sub_category_id is an array and if the current category ID exists in it
                if (is_array($subcategory->sub_category_id)) {
                    foreach ($subcategory_ids as $sub_id) {
                        if (in_array($sub_id, $subcategory->sub_category_id)) {
                            // Remove the subcategory ID from the array
                            $catsubcategory_id = array_diff($subcategory->sub_category_id, [$sub_id]);

                            // Check if sub_category_id is empty after removing the category ID
                            if (empty($catsubcategory_id)) {
                                // Delete the row if sub_category_id is empty
                                $subcategory->delete();
                            } else {
                                $subcategory->sub_category_id = $catsubcategory_id;
                                // Save the updated child category if sub_category_id is not empty
                                $subcategory->save();
                            }
                        }
                    }
                }
            });

            return redirect('admin/category')->with('delete','Data has been deleted successfully.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the category: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //------------------- childCategory_bulk_delete end --------------------------------

    //------------------- export categories start --------------------------------
    public function exportCategories()
    {
        $categories = Category::with('subcategories')->get();

        $csv = [];
        foreach ($categories as $category) {
            foreach ($category->subcategories as $subcategory) {
                $children = ChildCategory::all();
                foreach ($children as $childcategory) {
                    if (is_array($childcategory->sub_category_id) && in_array($subcategory->id, $childcategory->sub_category_id)) {
                        $csv[] = [
                            'id' => $category->id,
                        'category_name' => $category->name,
                        'subcategory_name' => $subcategory->name,
                        'childcategory_name' => $childcategory->name,
                    ];
                }
            }
            }
        }

        $filename = 'categories.csv';
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
        fputcsv($output, ['id','Category', 'Subcategory', 'Childcategory']);

        foreach ($csv as $row) {
            fputcsv($output, $row);
        }

        fclose($output);

        return Response::make(rtrim(ob_get_clean()), 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
    //------------------- export categories end --------------------------------


    //------------------- import categories start --------------------------------
    public function importSave(Request $request)
    {
        if ($request->hasFile('csv_file')) {
            $file = $request->file('csv_file');

            // Read the CSV file
            $csvData = file_get_contents($file);

            // Parse CSV data
            $rows = array_map('str_getcsv', explode("\n", $csvData));

            // Remove header row
            $headers = array_shift($rows);
            // return $rows;
            foreach ($rows as $row) {

                if (count($row) >= 3) {
                    // Assuming CSV columns are in order: category, subcategory, childcategory
                    $categoryName = $row[0];
                    $subcategoryName = $row[1];
                    $childcategoryName = $row[2];

                    // Find or create the category
                    $category = Category::firstOrCreate(
                        ['name' => $categoryName],
                        ['slug' => Str::slug($categoryName)]
                    );

                    // Find or create the subcategory under the category
                    $subcategory = $category->subcategories()->firstOrCreate(
                        ['name' => $subcategoryName],
                        ['slug' => Str::slug($subcategoryName)],
                        ['category_id' => $category->id] // Assign slug when creating subcategory
                    );

                    $childcategory = ChildCategory::where('name', $childcategoryName)->first();

                    if ($childcategory) {
                        // Update the sub_category_id by appending the new subcategory id if it doesn't already exist
                        $subCategoryIds = $childcategory->sub_category_id; // Assuming sub_category_id is already an array
                        if (!in_array("$subcategory->id", $subCategoryIds)) { // Check if the ID already exists in the array
                            $subCategoryIds[] = "$subcategory->id"; // Append the new subcategory id
                            $childcategory->sub_category_id = $subCategoryIds;
                            $childcategory->save();
                        }
                    } else {
                        // Create the childcategory under the subcategory
                        $childcategory = ChildCategory::firstOrCreate([
                            'name' => $childcategoryName,
                            'sub_category_id' => ["$subcategory->id"], // Wrap the id in an array
                            'slug' => Str::slug($childcategoryName)
                        ]);
                    }

                } else {

                }
            }
            Flash::success('Categories imported successfully.')->important();

            return redirect('admin/category');
        }
        Flash::error('Please select a CSV file.')->important();

        return redirect()->back();
    }
    //------------------- import categories end--------------------------------

    //------------------- singe category on front start --------------------------------
    public function category_single(string $slug) {
        $category = Category::where('slug', $slug)->firstOrFail();
        $allCategories = Category::where('id', '!=', $slug)->get();
        $setting = GeneralSetting::first();
        $paginate = Quiz::paginate(6);
        $quiz = Quiz::all();
        $bookmarkedQuizIds = auth()->check()
        ? auth()->user()->bookmarks()->pluck('quiz_id')->toArray()
        : [];
        return view('front.category_single',compact('category','quiz','setting', 'allCategories','paginate','bookmarkedQuizIds'));
    }
    //------------------- singe category on front end --------------------------------

}
