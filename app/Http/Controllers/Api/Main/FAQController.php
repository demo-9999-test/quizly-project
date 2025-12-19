<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\FAQ;

class FAQController extends Controller
{
    // ------------------------FAQ GetAll Query Start --------------------------------

    public function index()
    {
        $faq = FAQ::all(); // Retrieve all FAQ posts
        return response()->json(['data' => $faq], 200);
    }

        // ------------------------FAQ GetAll Query Start --------------------------------


// ------------------------FAQ Store Query Start --------------------------------

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'answer' => 'required',
            'status' => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        $faq = FAQ::create($data);
        return response()->json(['message' => 'FAQ post created', 'data' => $faq], 201);
    }

// ------------------------FAQ Store Query end --------------------------------


// ------------------------ DATA show in id  Query Start --------------------------------
        public function show($id)
        {
            $faq = FAQ::where('id', $id)->first();
            if (!$faq) {
                return response()->json(['error' => 'FAQ post not found'], 404);
            }
            return response()->json(['data' => $faq], 200);
        }
// ------------------------ DATA show in id GetAll Query Start --------------------------------




    // ------------------------FAQ Update Query Start --------------------------------

    public function update(Request $request, $id)
    {
        if (FAQ::where('id', $id)->exists()) {
            $faq = FAQ::find($id);
            $faq->question = isset($request->question) ? $request->question : $faq->question;
            $faq->answer = isset($request->answer) ? $request->answer : $faq->answer;
            $faq->status = isset($request->status) ? $request->status : $faq->status;
            $faq->save();
            return response()->json([
              "message" => "Blog Post  updated successfully",
              'data'=>$faq
            ]);
        } else {
            return response()->json([
              "message" => "blog Post not found"
            ], 404);
        }
    }
    // ------------------------FAQ Update Query End --------------------------------

     // ------------------------ delete Query End --------------------------------
     public function destroy($id)
     {
         $faq = FAQ::find($id);
         if (!$faq) {
             return response()->json(['message' => 'FAQ not found'], 404);
         }
         $faq->delete();
         return response()->json(['message' => 'FAQ deleted successfully'], 200);
     }
     // ------------------------ delete Query End --------------------------------

}

