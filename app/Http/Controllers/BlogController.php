<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Blog;
use App\Models\Category;
use App\Models\PostCategory;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\GeneralSetting;
use App\Models\BlogComment;

class BlogController extends Controller
{
    private $cohereApiKey;
    private $pixabayApiKey;
    private $openaiApiKey;
    private $unsplashkey;

    public function __construct()
    {
        $this->middleware('permission:blog.view', ['only' => ['index', 'show']]);
        $this->middleware('permission:blog.create', ['only' => ['store']]);
        $this->middleware('permission:blog.edit', ['only' => ['edit', ' update', 'updateStatus', 'updateOrder']]);
        $this->middleware('permission:blog.delete', ['only' => ['destroy', 'bulk_delete', 'trash_bulk_delete', 'trash', 'restore', 'trashDelete']]);
        $this->middleware('permission:blog.comments',['only'=>['blog_comment']]);
        $this->cohereApiKey = env('COHERE_API_KEY');
        $this->pixabayApiKey = env('PIXABAY_API_KEY');
        $this->openaiApiKey = env('OPEN_API_KEY');
        $this->unsplashkey = env('UNSPLASH_ACCESS_KEY');
    }

    //---------------------------------- Page View Code start-------------------------------
    public function index()
    {
        $categoryData = PostCategory::all();
        return view('admin.blog.index', compact('categoryData'));
    }
    //---------------------------------- Page View Code end-------------------------------

    //---------------------------------- Data Store Code start-------------------------------

    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required|blogs,unique',
            'category_id' => 'required',
            'desc' => 'required',
            'image_source' => 'required|in:local,generated',
            'local_images' => 'required_if:image_source,local|image|mimes:jpeg,png,jpg,gif',
            'generated_image_url' => 'required_if:image_source,generated',
        ]);

        // Create a new blog record
        $blog = new Blog;
        $blog->title = $request->input('title');
        $blog->slug = $request->input('slug');
        $blog->desc = $request->input('desc');
        $blog->category_id = $request->input('category_id');
        $blog->approved = $request->input('approved') ? 1 : 0;
        $blog->sticky = $request->input('sticky') ? 1 : 0;
        $blog->is_featured = $request->input('is_featured') ? 1 : 0;

        $action = $request->input('status');
        $blog->status = ($action === 'publish') ? 1 : 0;


        if ($request->hasFile('thumbnail_img')) {
            $file = $request->file('thumbnail_img');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_thumbnail.' . $extension;
            $file->move('images/blog', $filename);
            $blog->thumbnail_img = $filename;
        }

        // Handle the image based on the source
        try {
            if ($request->input('image_source') === 'local') {
                if ($request->hasFile('local_images')) {
                    $file = $request->file('local_images');
                    $filename = $this->uploadImage($file);
                    $blog->banner_img = $filename;
                }
            } else { // Generated image
                $generatedImageUrl = $request->input('generated_image_url');
                if (!empty($generatedImageUrl)) {
                    $filename = $this->downloadGeneratedImage($generatedImageUrl);
                    $blog->banner_img = $filename;
                } else {
                    throw new \Exception('Generated image URL is empty');
                }
            }

            $blog->save();

            return redirect('admin/post')->with('success','Blog post has been created successfully.');
        } catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding the post: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }

    private function uploadImage($file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $file->move('images/blog', $filename);
        return $filename;
    }

    private function downloadGeneratedImage($url)
    {
        $filename = time() . '.jpg';
        $imagePath = public_path('images/blog/' . $filename);

        $client = new \GuzzleHttp\Client();
        $response = $client->get($url);

        if ($response->getStatusCode() === 200) {
            file_put_contents($imagePath, $response->getBody());
            return $filename;
        }

        throw new \Exception('Failed to download generated image');
    }

    //---------------------------------- Data Store Code end-------------------------------


    //---------------------------------- All Data Show Code start-------------------------------
    public function show(Request $request)
    {

        $blog = Blog::orderBy('position')->paginate(7);
        $categoryData = PostCategory::get();
        return view('admin.blog.index', compact('blog', 'categoryData'));
    }
    //---------------------------------- All Data Show Code end-------------------------------


    //---------------------------------- Edit Page Code start-------------------------------

    public function edit(string $id)
    {
        $categoryData = PostCategory::get();
        $blog = Blog::find($id);
        if (!$blog) {
            Flash::error('blog not found')->important();

            return redirect('admin/blog');
        }
        return view('admin.blog.edit', compact('blog', 'categoryData'));
    }
    //---------------------------------- Edit Page Code end-------------------------------


    //---------------------------------- Update Code start-------------------------------

    public function update(Request $request, string $id)
    {
        try{
            $blog = Blog::find($id);
            if (!$blog) {
                Flash::error('blog not found')->important();

                return redirect('admin/post');
            }
            $blog->title = $request->input('title');
            $blog->slug = $request->input('slug');
            $blog->desc = $request->input('desc');
            $blog->category_id = $request->input('category_id');
            $blog->sticky = $request->input('sticky') ? 1 : 0;
            $blog->approved = $request->input('approved') ? 1 : 0;
            $blog->is_featured = $request->input('is_featured') ? 1 : 0;
            $action = $request->input('status');
            if ($action === 'draft') {
                $blog->status = 0; // Draft status
            } elseif ($action === 'publish') {
                $blog->status = 1; // Publish status
            }
            if ($request->hasFile('thumbnail_img')) {
                $file = $request->file('thumbnail_img');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/blog', $filename);
                if ($blog->thumbnail_img != null) {
                    $existingImagePath = public_path('images/blog/' . $blog->thumbnail_img);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }

                $blog->thumbnail_img = $filename;
            }
            if ($request->hasFile('banner_img')) {
                $file = $request->file('banner_img');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/blog', $filename);
                if ($blog->banner_img != null) {
                    $existingImagePath = public_path('images/blog/' . $blog->banner_img);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }

                $blog->banner_img = $filename;
            }
            $blog->save();

            return redirect('admin/post')->with('success','blog has been updated.');
        }catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating the badge: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }

    //---------------------------------- Update Code End-------------------------------


    //---------------------------------- Data Delete Code start-------------------------------

    public function destroy(string $id)
    {
        $blog = Blog::find($id);
        $blog->delete();
        return redirect('admin/post')->with('delete','Data Delete Successfully');
    }
    //---------------------------------- Data Delete Code End-------------------------------


    //---------------------------------- Data Selected Delete Code start-------------------------------
    public function bulk_delete(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->with('warning','Atleast one item is required to be checked');
            } else {
                Blog::whereIn('id', $request->checked)->delete();
                return redirect('admin/post')->with('delete','Data Delete Successfully');
            }
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the badge: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data Selected Delete Code end-------------------------------

    //---------------------------------- Data Selected Delete trash Code start-------------------------------
    public function trash_bulk_delete(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->with('warning','Atleast one item is required to be checked');
            } else {
                Blog::whereIn('id', $request->checked)->forceDelete();
                return redirect('admin/post')->with('delete','Data Delete Successfully');
            }
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the badge: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data Selected Delete trash Code end-------------------------------


    //---------------------------------- trash Code start-------------------------------
    public function trash()
    {
        $blog = Blog::onlyTrashed()->get();
        return view('admin.blog.trash', compact('blog'));
    }
    //---------------------------------- trash Code end-------------------------------


    //---------------------------------- Data restore Code start-------------------------------
    public function restore(string $id)
    {
        try{
            $blog = Blog::withTrashed()->find($id);
            if (!is_null($blog)) {
                $blog->restore();
            }
            return redirect('admin/post/trash')->with('success','Data Delete Successfully');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while restoring the badge: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data restore Code End-------------------------------


    //---------------------------------- Trash data Delete Code start-------------------------------
    public function trashDelete(string $id)
    {
        try{
            $blog = Blog::withTrashed()->find($id);
            if (!is_null($blog)) {
                if ($blog->images != null) {
                    $content = @file_get_contents(public_path() . '/images/blog/' . $blog->images);
                    if ($content) {
                        unlink(public_path() . "/images/blog/" . $blog->images);
                    }
                }
                $blog->forceDelete();
                return redirect('admin/post/trash')->with('delete','Data Delete Successfully');
            }
            return redirect('admin/post/trash');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while restoring the badge: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //----------------------------------Trash data Delete Code start-------------------------------

    //---------------------------------- Status  Code start-------------------------------

    public function updateStatus(Request $request)
    {
        $blog = Blog::find($request->id);
        $blog->approved = $request->input('approved') ? 1 : 0;
        $blog->save();
        return response()->json(['message' => 'Status changed successfully'], 200);
    }
    //---------------------------------- Status  Code end-------------------------------

    //  -----------------------darg and drop order update code  start -----------------
    public function updateOrder(Request $request)
    {
        $id = $request->input('id');
        $position = $request->input('position');
        $blog = Blog::findOrFail($id);
        $blog->position = $position;
        $blog->save();
        return response()->json(['success' => true]);
    }
    //  -----------------------darg and drop order update code  end -----------------



    //---------------------------------- Post category start-------------------------------
    public function post_category()
    {
        $category = PostCategory::orderBy('created_at', 'desc')->paginate(7);
        return view('admin.blog.category', compact('category'));
    }
    //---------------------------------- Post category end-------------------------------

    //---------------------------------- Post category store start-------------------------------
    public function post_categorystore(Request $request)
    {
        try{
            $request->validate([
                'categories' => 'required',
            ]);

            $category = new PostCategory;
            $category->categories = $request->input('categories');
            $category->status = $request->has('status') ? 1 : 0;
            $category->save();

            return redirect('admin/post-category')->with('success','Data has been added.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding the post category: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Post category store end-------------------------------

    //---------------------------------- Post category updatestatus start-------------------------------
    public function post_updateStatus(Request $request)
    {
        // return $request;
        $category = PostCategory::find($request->id);
        $category->status = $request->status;
        $category->save();
        return response()->json(['message' => 'Status changed successfully'], 200);
    }
    //---------------------------------- Post category updatestatus end-------------------------------

    //---------------------------------- Post category update page start-------------------------------
    public function post_categoryedit(string $id)
    {

        $category = PostCategory::find($id);
        if (!$category) {
            return redirect('admin/post-category')->with('error','category not found');
        }
        return view('admin.blog.editcategory', compact('category'));
    }
    //---------------------------------- Post category update page end-------------------------------

    //---------------------------------- Post category update function start-------------------------------
    public function post_categoryupdate(Request $request, string $id)
    {
        try{
        $category = PostCategory::find($id);
        $category->categories = $request->input('categories');
        $category->status = $request->has('status') ? 1 : 0;
        $category->save();
        return redirect('admin/post-category')->with('success','category has been updated.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating the post category: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Post category update function end-------------------------------


    //---------------------------------- Post category destroy start-------------------------------
    public function post_categorydestroy(string $id)
    {
        $category = PostCategory::find($id);
        $category->delete();
        return redirect('admin/post-category')->with('delete','Data Delete Successfully');
    }
    //---------------------------------- Post category destroy end-------------------------------

    //---------------------------------- Post category bulk delete start-------------------------------
    public function post_categorybulk_delete(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->with('warning','Atleast one item is required to be checked');
            } else {
                PostCategory::whereIn('id', $request->checked)->delete();
                return redirect('admin/post-category')->with('delete','Data Delete Successfully.');
            }
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the post category: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Post category bulk delete start-------------------------------

    //---------------------------------- env variable checks start-------------------------------
    public function checkEnvVariables()
    {
        $requiredKeys = [
            'COHERE_API_KEY',
            'OPEN_API_KEY',
            'UNSPLASH_ACCESS_KEY',
            'PIXABAY_API_KEY'
        ];

        $missingKeys = [];

        foreach ($requiredKeys as $key) {
            if (empty(env($key))) {
                $missingKeys[] = $key;
            }
        }

        return response()->json(['missingKeys' => $missingKeys]);
    }
    //---------------------------------- env variable checks end-------------------------------

    //---------------------------------- env variable update start-------------------------------
    public function updateEnvVariables(Request $request)
    {
        $envFile = base_path('.env');
        $envContents = File::get($envFile);

        foreach ($request->all() as $key => $value) {
            if (strpos($envContents, $key . '=') !== false) {
                $envContents = preg_replace("/$key=.*/", "$key=$value", $envContents);
            } else {
                $envContents .= "\n$key=$value";
            }
        }

        File::put($envFile, $envContents);

        return response()->json(['success' => true]);
    }
    //---------------------------------- env variable update end-------------------------------


    //---------------------------------- generate description code start-------------------------------
    public function generateDescription(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'model' => 'required|string|in:chatgpt,cohere',
            ]);

            $title = $request->input('title');
            $model = $request->input('model');
            Log::info("Generating description for title: $title using model: $model");

            $description = $model === 'chatgpt'
                ? $this->generateChatGPTDescription($title)
                : $this->generateCohereDescription($title);

            Log::info('Generated description: ' . $description);

            return response()->json(['content' => $description], 200);
        } catch (\Exception $e) {
            Log::error('Error in generateDescription: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }
    //---------------------------------- generate description code end-------------------------------

    //---------------------------------- generate image code start-------------------------------
    public function generateImages(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'source' => 'required|string|in:pixabay,unsplash,all',
            ]);

            $title = $request->input('title');
            $source = $request->input('source');

            $images = [];

            if ($source === 'pixabay' || $source === 'all') {
                $pixabayImages = $this->fetchPixabayImages($title);
                $images = array_merge($images, $pixabayImages);
            }

            if ($source === 'unsplash' || $source === 'all') {
                $unsplashImages = $this->fetchUnsplashImages($title);
                $images = array_merge($images, $unsplashImages);
            }

            // Shuffle the images to mix results from different sources
            shuffle($images);

            return response()->json(['images' => $images], 200);
        } catch (\Exception $e) {
            Log::error('Error generating images: ' . $e->getMessage());
            return response()->json(['error' => 'Error generating images.'], 500);
        }
    }
    //---------------------------------- generate image code end-------------------------------

    //---------------------------------- generate chatGPT description code start-------------------------------
    private function generateChatGPTDescription($title)
    {
        try {
            $apiKey = $this->openaiApiKey; // Make sure to set this in your configuration
            $url = 'https://api.openai.com/v1/chat/completions';

            Log::info('OpenAI API Key: ' . substr($apiKey, 0, 5) . '...' . substr($apiKey, -5));

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post($url, [
                'model' => 'gpt-3.5-turbo', // You can change this to a different GPT model if needed
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an expert content writer.'
                    ],
                    [
                        'role' => 'user',
                        'content' => "Create a detailed, informative blog post for the title: '$title'. Include an introduction, at least three main sections with subheadings, and a conclusion. The post should be around 1000 words long."
                    ]
                ],
                'max_tokens' => 1500, // Increased token limit
                'temperature' => 0.7,
            ]);

            Log::info('OpenAI API Response: ' . $response->body());

            if (!$response->successful()) {
                throw new \Exception('OpenAI API error: ' . $response->status() . ' - ' . $response->body());
            }

            $responseData = $response->json();
            if (!isset($responseData['choices'][0]['message']['content'])) {
                throw new \Exception('Unexpected OpenAI API response format');
            }

            return trim($responseData['choices'][0]['message']['content']);
        } catch (\Exception $e) {
            Log::error('Error in generateBlogDescription: ' . $e->getMessage());
            throw $e;
        }
    }
    //---------------------------------- generate chatGPT description code end-------------------------------

    //---------------------------------- generate cohere description code start-------------------------------
    private function generateCohereDescription($title)
    {
        try {
            $apiKey = $this->cohereApiKey;
            Log::info('Cohere API Key: ' . substr($apiKey, 0, 5) . '...' . substr($apiKey, -5));

            $url = 'https://api.cohere.ai/v1/generate';

            // Function to handle API request
            $makeRequest = function () use ($url, $apiKey, $title) {
                return Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])->timeout(60) // Increase timeout to 60 seconds
                    ->post($url, [
                        'model' => 'command-xlarge-nightly',
                        'prompt' => "Create a detailed, informative blog post for the title: '$title'. Include an introduction, at least three main sections with subheadings, and a conclusion. The post should be around 1000 words long.",
                        'max_tokens' => 1500,
                        'temperature' => 0.7,
                    ]);
            };

            // Retry mechanism with exponential backoff
            $maxRetries = 3;
            $retryCount = 0;
            $response = null;

            do {
                $response = $makeRequest();
                if ($response->successful()) {
                    break;
                }

                Log::warning('Cohere API error, retrying... (' . ($retryCount + 1) . '/' . $maxRetries . ')');
                $retryCount++;
                sleep(pow(2, $retryCount)); // Exponential backoff
            } while ($retryCount < $maxRetries);

            if (!$response || !$response->successful()) {
                throw new \Exception('Cohere API error after retries: ' . ($response ? $response->status() : 'No response') . ' - ' . ($response ? $response->body() : 'No response body'));
            }

            Log::info('Cohere API Response: ' . $response->body());

            $responseData = $response->json();
            Log::info('Cohere API Response Data: ' . json_encode($responseData));

            if (!isset($responseData['generations'][0]['text'])) {
                throw new \Exception('Unexpected Cohere API response format: ' . json_encode($responseData));
            }

            return trim($responseData['generations'][0]['text']);
        } catch (\Exception $e) {
            Log::error('Error in generateCohereDescription: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }
    //---------------------------------- generate cohere description code end-------------------------------

    //---------------------------------- generate fetchpixableIMAGES code start-------------------------------
    private function fetchPixabayImages($query)
    {
        $apiKey = $this->pixabayApiKey;
        $url = 'https://pixabay.com/api/';
        $response = Http::get($url, [
            'key' => $apiKey,
            'q' => urlencode($query),
            'image_type' => 'photo',
            'per_page' => 20,
        ]);

        $images = [];
        if ($response->successful()) {
            foreach ($response->json()['hits'] as $hit) {
                $images[] = $hit['webformatURL'];
            }
        }

        return $images;
    }
    //---------------------------------- generate fetchpixableIMAGES code end-------------------------------


    //---------------------------------- generate fetch Unsplash image code start-------------------------------
    private function fetchUnsplashImages($query)
    {
        $apiKey = $this->unsplashkey;
        $url = 'https://api.unsplash.com/search/photos';
        $response = Http::withHeaders([
            'Authorization' => 'Client-ID ' . $apiKey,
        ])->get($url, [
            'query' => $query,
            'per_page' => 20,
        ]);

        $images = [];
        if ($response->successful()) {
            foreach ($response->json()['results'] as $result) {
                $images[] = $result['urls']['regular'];
            }
        }

        return $images;
    }
    //---------------------------------- generate fetch Unsplash image code end-------------------------------

    //---------------------------------- copy code start-------------------------------
    public function copy(Request $request)
    {
        $originalPost = Blog::findOrFail($request->id);

        $newPost = $originalPost->replicate();
        $newPost->title = $originalPost->title;
        $newPost->slug = $this->generateUniqueSlug($originalPost->title);
        $newPost->created_at = now();
        $newPost->updated_at = now();

        // Handle image copying
        if ($originalPost->thumbnail_img) {
            $newThumbnailName = $this->copyImage($originalPost->thumbnail_img, 'thumbnail');
            $newPost->thumbnail_img = $newThumbnailName;
        }
        if ($originalPost->banner_img) {
            $newBannerName = $this->copyImage($originalPost->banner_img, 'banner');
            $newPost->banner_img = $newBannerName;
        }

        $newPost->save();

        return response()->json(['success' => true, 'message' => 'Post copied successfully']);
    }
    //---------------------------------- copy code end-------------------------------

    //---------------------------------- generate unique slug start-------------------------------
    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $count = 2;

        while (Blog::where('slug', $slug)->exists()) {
            $slug = Str::slug($title) . '-' . $count;
            $count++;
        }

        return $slug;
    }

    private function copyImage($originalFileName, $type)
    {
        $originalPath = public_path('images/blog/' . $originalFileName);
        $extension = pathinfo($originalPath, PATHINFO_EXTENSION);
        $newFileName = time() . '_' . $type . '_copy.' . $extension;
        $newPath = public_path('images/blog/' . $newFileName);

        if (file_exists($originalPath)) {
            copy($originalPath, $newPath);
            return $newFileName;
        }

        return null;
    }
    //---------------------------------- generate unique slug end-------------------------------

    // ----- post category Code end-----

    //------------------------------- Blog page front start -----------------------------------
    public function blog_page() {
        $blog = Blog::all();
        $blogs = Blog::paginate(3);
        $setting = GeneralSetting::first();
        return view('front.blog',compact('blog','blogs','setting'));
    }
    public function blog_details(string $slug) {
        $currentBlog = Blog::where('slug',$slug)->firstOrFail();
        $comment = BlogComment::all();
        $setting = GeneralSetting::first();
        if (!$currentBlog) {
            Flash::error('Blog not found')->important();
            return redirect('/');
        }

        $blogsExceptCurrent = Blog::where('slug', '!=', $slug)->get();
        $category = PostCategory::all();

        return view('front.blog_details', compact('currentBlog', 'blogsExceptCurrent', 'category','setting','comment'));
    }
    //------------------------------- Blog page front end -----------------------------------

    //------------------------------- Blog comments admin start -----------------------------------
    public function blog_comments_table() {
        $blog = BlogComment::all();
        return view('admin.blog.comments',compact('blog'));
    }
    //------------------------------- Blog comments admin end -----------------------------------

        //------------------------------- Blog comments approve start -----------------------------------
    public function toggleApproval($id)
    {
        $blog = BlogComment::findOrFail($id);
        $blog->approved = !$blog->approved;
        $blog->save();

        return redirect()->back()->with('success', 'Comment status updated successfully.');
    }
    //------------------------------- Blog comments approve end -----------------------------------

    //------------------------------- Blog comments front start -----------------------------------
    public function blog_comment(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string',
            'blog_id' => 'required|exists:blogs,id',
        ]);

        $blogComment = new BlogComment();
        $blogComment->blog_id = $validatedData['blog_id'];
        $blogComment->name = $validatedData['name'];
        $blogComment->email = $validatedData['email'];
        $blogComment->comment = $validatedData['comment'];
        $blogComment->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Your comment has been added successfully.');
    }
    //------------------------------- Blog comments front start -----------------------------------

}
