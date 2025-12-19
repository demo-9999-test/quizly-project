<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Blog;

class BlogController extends Controller
{
    // ------------------------Blog GetAll Query Start --------------------------------

    public function index()
    {
        $blogPosts = Blog::all(); // Retrieve all blog posts
        return response()->json(['data' => $blogPosts], 200);
    }
        // ------------------------Blog GetAll Query Start --------------------------------

// ------------------------Blog Store Query Start --------------------------------

    public function store(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'heading' => 'required|string',
        'slug' => 'required',
        'images' => 'required|image',
        'details' => 'required|string',
        'status' => 'boolean',
        'approved' => 'boolean',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }
    $data = $validator->validated();
    if ($request->hasFile('images')) {
        $imageFile = $request->file('images');
        $extension = $imageFile->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $imageFile->move(public_path('/images/blog/'), $filename);
        $data['images'] = $filename;
    }
    // return $data;
    $blogPost = Blog::create($data);
    return response()->json(['message' => 'Blog post created', 'data' => $blogPost], 201);
    }
// ------------------------Blog Store Query end --------------------------------


// ------------------------ DATA show in id  Query Start --------------------------------
    public function show($id)
    {
        $blogPost = Blog::where('id', $id)->first();
        if (!$blogPost) {
            return response()->json(['error' => 'Blog post not found'], 404);
        }
        return response()->json(['data' => $blogPost], 200);
    }
// ------------------------ DATA show in id GetAll Query Start --------------------------------


    // ------------------------Blog Update Query Start --------------------------------

    public function update(Request $request, $id)
    {
        if (Blog::where('id', $id)->exists()) {
            $blog = Blog::find($id);
            $blog->heading = isset($request->heading) ? $request->heading : $blog->heading;
            $blog->slug = isset($request->slug) ? $request->slug : $blog->slug;
            $blog->date = isset($request->date) ? $request->date : $blog->date;
            $blog->details = isset($request->details) ? $request->details : $blog->details;
            $blog->status = isset($request->status) ? $request->status : $blog->status;
            $blog->approved = isset($request->approved) ? $request->approved : $blog->approved;
            if ($request->hasFile('images')) {
                $imageFile = $request->file('images');
                $extension = $imageFile->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $imageFile->move(public_path('/images/blog/'), $filename);
                $blog['images'] = $filename;
            }
            $blog->save();
            return response()->json([
              "message" => "Blog Post  updated successfully",
              'data'=>$blog
            ]);
        } else {
            return response()->json([
              "message" => "blog Post not found"
            ], 404);
        }
    }
    // ------------------------Blog Update Query End --------------------------------


    // ------------------------ delete Query End --------------------------------
    public function destroy($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }
        $blog->delete();
        return response()->json(['message' => 'Blog deleted successfully'], 200);
    }
    // ------------------------ delete Query End --------------------------------

}
