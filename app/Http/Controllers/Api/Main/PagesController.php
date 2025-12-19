<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Pages;

class PagesController extends Controller
{
    // / ------------------------Pages GetAll Query Start --------------------------------

    public function index()
    {
        $Pages = Pages::all(); // Retrieve all Pages posts
        return response()->json(['data' => $Pages], 200);
    }

        // ------------------------Pages GetAll Query Start --------------------------------


// ------------------------Pages Store Query Start --------------------------------

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'slug' => 'required|string',
            'desc' => 'required|string',
            'status' => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        $Pages = Pages::create($data);
        return response()->json(['message' => 'Pages post created', 'data' => $Pages], 201);
    }

// ------------------------Pages Store Query end --------------------------------


// ------------------------ DATA show in id  Query Start --------------------------------
public function show($id)
{
    $Pages = Pages::where('id', $id)->first();
    if (!$Pages) {
        return response()->json(['error' => 'Pages post not found'], 404);
    }
    return response()->json(['data' => $Pages], 200);
}
// ------------------------ DATA show in id GetAll Query Start --------------------------------

// ------------------------pages Update Query Start --------------------------------

     public function update(Request $request, $id)
     {
         if (Pages::where('id', $id)->exists()) {
             $pages = Pages::find($id);
             $pages->title = isset($request->title) ? $request->title : $pages->title;
             $pages->slug = isset($request->slug) ? $request->slug : $pages->slug;
             $pages->desc = isset($request->desc) ? $request->desc : $pages->desc;
             $pages->status = isset($request->status) ? $request->status : $pages->status;
             $pages->save();
             return response()->json([
               "message" => "Blog Post  updated successfully",
               'data'=>$pages
             ]);
         } else {
             return response()->json([
               "message" => "blog Post not found"
             ], 404);
         }
     }

     // ------------------------pages Update Query End --------------------------------

      // ------------------------ delete Query End --------------------------------
      public function destroy($id)
      {
          $pages = Pages::find($id);
          if (!$pages) {
              return response()->json(['message' => 'Page not found'], 404);
          }
          $pages->delete();
          return response()->json(['message' => 'Page deleted successfully'], 200);
      }
      // ------------------------ delete Query End --------------------------------

}

