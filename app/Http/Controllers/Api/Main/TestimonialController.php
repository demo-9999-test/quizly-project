<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
   // ------------------------ GetAll Query Start --------------------------------

   public function index()
   {
       $TestimonialPost = Testimonial::all(); // Retrieve all Testimonial posts
       return response()->json(['data' => $TestimonialPost], 200);
   }

       // ------------------------ GetAll Query Start --------------------------------


// ------------------------ Store Query Start --------------------------------

   public function store(Request $request)
   {
   $validator = Validator::make($request->all(), [
       'client_name' => 'required|string',
       'rating' => 'required',
       'images' => 'required|image',
       'desc' => 'required|string',
       'status' => 'boolean',
   ]);
   if ($validator->fails()) {
       return response()->json(['errors' => $validator->errors()], 422);
   }
   $data = $validator->validated();
   if ($request->hasFile('images')) {
       $imageFile = $request->file('images');
       $extension = $imageFile->getClientOriginalExtension();
       $filename = time() . '.' . $extension;
       $imageFile->move(public_path('/images/Testimonial/'), $filename);
       $data['images'] = $filename;
   }
   // return $data;
   $TestimonialPost = Testimonial::create($data);
   return response()->json(['message' => 'Testimonial post created', 'data' => $TestimonialPost], 201);
   }
// ------------------------ Store Query end --------------------------------

// ------------------------ DATA show in id  Query Start --------------------------------
    public function show($id)
    {
        $testimonialPost = Testimonial::where('id', $id)->first();
        if (!$testimonialPost) {
            return response()->json(['error' => 'Testimonial post not found'], 404);
        }
        return response()->json(['data' => $testimonialPost], 200);
    }
   // ------------------------ DATA show in id GetAll Query Start --------------------------------

   // ------------------------ Update Query Start --------------------------------

   // public function update(Request $request, $id){
   // $TestimonialPost = Testimonial::find($id);
   // if (!$TestimonialPost) {
   //     return response()->json(['error' => 'Testimonial post not found'], 404);
   // }
   // $validator = Validator::make($request->all(), [
   //     'heading' => 'string',
   //     'slug' => 'string',
   //     'images' => 'image',
   //     'date' => 'date',
   //     'details' => 'string',
   //     'status' => 'boolean',
   //     'approved' => 'boolean',
   // ]);
   // if ($validator->fails()) {
   //     return response()->json(['errors' => $validator->errors()], 422);
   // }
   // $data = $validator->validated();
   // if ($request->hasFile('images')) {
   //     $imageFile = $request->file('images');
   //     $extension = $imageFile->getClientOriginalExtension();
   //     $filename = time() . '.' . $extension;
   //     // Use an absolute path to store the image
   //     $imageFile->move(public_path('images/Testimonial'), $filename);
   //     $data['images'] = $filename;
   // }
   // $TestimonialPost->update($data);
   // return response()->json(['message' => 'Testimonial post updated', 'data' => $TestimonialPost], 200);}

   // ------------------------ Update Query End --------------------------------
}
