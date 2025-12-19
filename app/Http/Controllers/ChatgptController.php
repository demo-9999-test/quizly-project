<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models\Openai;
use Illuminate\Support\Facades\Session;
use Laracasts\Flash\Flash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ChatgptController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ai.manage', ['only' => ['text','textoutput','image','imagegenerate','useropenai','delete','bulk_delete']]);

    }
    //------------------- text code start --------------------------------
    public function text(Request $request)
    {
        if (config('app.demolock') == 1) {
            $data['status'] = false;
            $data['msg'] = "Demo lock has been disbaled";
            return response()->json($data);
        }
        $service = $request->service;
        $language = $request->language;
        $keyword = $request->keyword;
        $settings = ApiSetting::first();
        $decryptedApiSecret = decrypt($settings->openapikey);
        $prompt = "Genrate a $service in this $language with specific $keyword";
        $data = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$decryptedApiSecret,
        ])
        ->post("https://api.openai.com/v1/chat/completions", [
            "model" => "gpt-3.5-turbo",
            'messages' => [
                [
                "role" => "user",
                "content" => $prompt
            ]
            ],
            'temperature' => 1.5,
            "max_tokens" => 150,
            "stop" => ["11."],
        ])->json();
        $output = $data['choices'][0]['message'];
        $newdata = new Openai();
        $newdata->generate     = 'Text Generate';
        $newdata->user_id   = Auth::id();
        $newdata->prompt   = $prompt;
        $newdata->response = json_encode($output);
        $newdata->save();
        return $this->textoutput($output);
     }
    //------------------- text code end --------------------------------

    //------------------- text code output start --------------------------------
    public function textoutput($output){
        $data = (object) $output;
        $html = view('admin.openai.output', compact('data'))->render();
        return response()->json(compact('html'));
    }
    //------------------- text code output end --------------------------------

    //------------------- image code start --------------------------------
    public function image(Request $request){
        if (config('app.demolock') == 1) {
            $data['status'] = false;
            $data['msg'] = "Demo lock has been disbaled";
            return response()->json($data);
        }
        $prompt = $request->description;
        $settings = ApiSetting::first();
        $decryptedApiSecret = decrypt($settings->openapikey);
        $client = new Client();
        $url = 'https://api.openai.com/v1/images/generations';
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' .$decryptedApiSecret,
        ];
        $data = [
            'model' => 'dall-e-3',
            'prompt' => $prompt,
            'n' => (int)$request->image_number_of_images,
            'size' => '1024x1024',
        ];
        $client = new Client();
        try {
        $response = $client->post($url, [
            'headers' => $headers,
            'json' => $data,
        ]);
        $result = json_decode($response->getBody(), true);
        $image_url = $response->getBody();
        $resp = json_decode($image_url);
        $imageUrl = $result['data'][0]['url'];
        foreach ($resp->data as $key => $value) {
        // Save the image to the specified folder within the public directory
        $contents = file_get_contents($imageUrl);
        $nameOfImage = Str::random(12) . '-' . Str::slug($request->prompt) . '.png';
        $imagePath =  public_path('images/openai/' . $nameOfImage);
        file_put_contents($imagePath, $contents);
        // Storage::put($imagePath, $contents);

        // Construct the public URL for the saved image
        $publicImageUrl = asset('/images/openai/' . $nameOfImage);
        $newdata  = new Openai();
        $newdata->generate  = 'Image Generate';
        $newdata->user_id   = Auth::id();
        $newdata->prompt   = $prompt;
        $newdata->response = $publicImageUrl;
        $newdata->save();
        }
        return $this->imagegenerate($imageUrl);
        } catch (\Exception $e) {
            // Handle exceptions (e.g., Guzzle HTTP errors)
            dd($e->getMessage());
        }
    }
    //------------------- image code end --------------------------------

    //------------------- image generate start --------------------------------
    public function imagegenerate($imageUrl){
        $response = view('admin.openai.image', compact('imageUrl'))->render();
        $status = 'True';
        return response()->json(compact('response','status'));
    }
    //------------------- image generate end --------------------------------

    //------------------- useropenai start --------------------------------
    public function useropenai()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'A') {
                $openai = Openai::orderBy('created_at', 'desc')->paginate(10);
            } else {
                $openai = Openai::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
            }
        } else {
            return redirect()->route('login');
        }

        // Pass data to the view
        return view('admin.openai.show', compact('openai'));
    }
    //------------------- useropenai ebd --------------------------------

    //------------------- delete code start --------------------------------
    public function delete(string $id)
    {
        $openai = Openai::find($id);
        $openai->delete();
        Flash::success('Data Delete Successfully.')->important();

        return redirect('admin/openai');
    }
    //------------------- delete code end --------------------------------

    //------------------- bulkdelete code start --------------------------------
    public function bulk_delete(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);

        if ($validator->fails()) {
            Flash::error('Atleast one item is required to be checked')->important();

            return back();

        }
        else{
            Openai::whereIn('id',$request->checked)->delete();

            Session::flash('success',trans('Deleted Successfully'));
            return redirect()->back();

        }
    }
    //------------------- bulkdelete code end --------------------------------
}
