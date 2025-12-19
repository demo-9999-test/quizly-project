<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Slider;

class SliderController extends Controller
{
    // ------------------------Slider GetAll Query Start --------------------------------

    public function index()
    {
        $SliderPost = Slider::all(); // Retrieve all Slider posts
        return response()->json(['data' => $SliderPost], 200);
    }

        // ------------------------Slider GetAll Query Start --------------------------------


// ------------------------Slider Store Query Start --------------------------------

    public function store(Request $request)
    {
        dd($request->all());
    $validator = Validator::make($request->all(), [
        'heading' => 'required|string',
        'sub_heading' => 'required',
        'images' => 'required|image',
        'text_position' => 'required|string|in:l,c,r',
        'details' => 'required|string',
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
        $imageFile->move(public_path('/images/Slider/'), $filename);
        $data['images'] = $filename;
    }
    // return $data;
    $SliderPost = Slider::create($data);
    return response()->json(['message' => 'Slider post created', 'data' => $SliderPost], 201);
    }
// ------------------------Slider Store Query end --------------------------------


// ------------------------ DATA show in id  Query Start --------------------------------
    public function show($id)
    {
        $SliderPost = Slider::where('id', $id)->first();
        if (!$SliderPost) {
            return response()->json(['error' => 'SliderPost post not found'], 404);
        }
        return response()->json(['data' => $SliderPost], 200);
    }
// ------------------------ DATA show in id GetAll Query Start --------------------------------


    // ------------------------Slider Update Query Start --------------------------------

    // public function update(Request $request, $id){
    // $SliderPost = Slider::find($id);
    // if (!$SliderPost) {
    //     return response()->json(['error' => 'Slider post not found'], 404);
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
    //     $imageFile->move(public_path('images/Slider'), $filename);
    //     $data['images'] = $filename;
    // }
    // $SliderPost->update($data);
    // return response()->json(['message' => 'Slider post updated', 'data' => $SliderPost], 200);}

    // ------------------------Slider Update Query End --------------------------------

}
