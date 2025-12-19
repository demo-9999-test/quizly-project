<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
use App\Models\Newsletter;
use DrewM\MailChimp\MailChimp;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Log;
class NewsletterController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:newsletter.view', ['only' => ['index','show']]);
        $this->middleware('permission:newsletter.create', ['only' => ['store']]);
        $this->middleware('permission:newsletter.edit', ['only' => ['edit', ' update','updateStatus','updateOrder']]);
        $this->middleware('permission:newsletter.delete', ['only' => ['destroy','bulk_delete','trash_bulk_delete','trash','restore','trashDelete']]);
    }
    //---------------------------------- Page View Code start-------------------------------
    public function index() {
        $newsletter = Newsletter::all();
        return view('admin.newsletter.index',compact('newsletter'));
    }
    //---------------------------------- Page View Code end-------------------------------


    //---------------------------------- Data Store Code start-------------------------------
    public function store(Request $request)
    {
        try{
            $messages = [
                'title.required' => 'Client Name is required.',
                'btn_text.required' => 'Rating is required.',
                'details.required' => 'Details are required.',
                'image.required' => 'Image is required.',
                'image.image' => 'The file must be an image.',
                'image.mimes' => 'The image must be a file of type: jpeg, png.',
            ];

            // Validate the request data with custom error messages
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'btn_text' => 'required',
                'details' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg',
                'status' => 'required|in:draft,publish', // Add this line
            ], $messages);

            // Check if the validation fails
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $message) {
                    Flash::warning($message)->important();
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $newsletter = new Newsletter;
            $newsletter->title = $request->input('title');
            $newsletter->btn_text = $request->input('btn_text');
            $newsletter->details = $request->input('details');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/newsletter', $filename);
                $newsletter->image = $filename;
            }

            $action = $request->input('status');
            if ($action === 'draft') {
                $newsletter->status = 0; // Draft status
            } elseif ($action === 'publish') {
                $newsletter->status = 1; // Publish status
            }

            $newsletter->save();
            return redirect('admin/newsletter')->with('success','Data has been added.');
        }catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding Newsletter data: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data Store Code end-------------------------------

    //---------------------------------- Edit Page Code start-------------------------------
    public function edit(string $id){
        $newsletter = Newsletter::find($id);
        if (!$newsletter) {
            return redirect('admin/newsletter')->with('error','Newsletter data not found');
        }

        return view('admin.newsletter.edit', compact('newsletter'));
    }
    //---------------------------------- Edit Page Code end-------------------------------

    //---------------------------------- Update Code start-------------------------------
    public function update(Request $request, string $id){
        try{
            $newsletter = Newsletter::find($id);
            if (!$newsletter) {
                return redirect('admin/newsletter')->with('error','Newsletter data not found.');
            }
            $newsletter->title = $request->input('title');
            $newsletter->btn_text = $request->input('btn_text');
            $newsletter->details =$request->input('details');
            $action = $request->input('status');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/newsletter', $filename);
                if ($newsletter->image != null) {
                    $existingImagePath = public_path('images/newsletter/' . $newsletter->image);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }

                $newsletter->image = $filename;
            }
            if ($action === 'draft') {
                $newsletter->status = 0;
            } elseif ($action === 'publish') {
                $newsletter->status = 1;
            }
            $newsletter->save();
            return redirect('admin/newsletter')->with('success','Newsletter has been updated.');
        }catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding Newsletter data: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Update Code End-------------------------------

    //---------------------------------- Status  Code start-------------------------------
    public function updateStatus(Request $request)
    {
        $newsletter = Newsletter::find($request->id);
        $newsletter->status = $request->status;
        $newsletter->save();
        Flash::success('Status change successfully.');
        return redirect('admin/newsletter');
    }
    //---------------------------------- Status  Code end-------------------------------

    //---------------------------------- Data Delete Code start-------------------------------

    public function destroy(string $id){
        $newsletter = Newsletter::find($id);
        $newsletter->delete();
        return redirect('admin/newsletter')->with('delete','Data Delete Successfully');
    }
    //---------------------------------- Data Delete Code End-------------------------------

    //---------------------------------- Data Selected Delete Code start-------------------------------

    public function bulk_delete(Request $request){
        // return $request;
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('warning','Atleast one item is required to be checked');
        }
        else{
            Newsletter::whereIn('id',$request->checked)->delete();
            return redirect('admin/newsletter')->with('delete','Data Delete Successfully');
        }
    }
    //---------------------------------- Data Selected Delete Code end-------------------------------

    //---------------------------------- Data Selected Delete Code start-------------------------------

    public function trash_bulk_delete(Request $request){
        // return $request;
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('warning','Atleast one item is required to be checked');
        }
        else{
            Newsletter::whereIn('id',$request->checked)->forceDelete();
            return redirect('admin/newsletter')->with('delete','Data Delete Successfully');
        }
    }
    //---------------------------------- Data Selected Delete Code end-------------------------------

    //---------------------------------- trash Code start-------------------------------
    public function trash()
    {
        $newsletter = Newsletter::onlyTrashed()->get();
        return view('admin.newsletter.trash', compact('newsletter'));
    }
    //---------------------------------- trash Code end-------------------------------

    //---------------------------------- Data restore Code start-------------------------------
    public function restore(string $id)
    {
        $newsletter = Newsletter::withTrashed()->find($id);
        if(!is_null($newsletter)){
            $newsletter->restore();
        }
        return redirect('admin/newsletter')->with('success','Trash Data restore Successfully');
    }
    //---------------------------------- Data restore Code End-------------------------------

    //---------------------------------- Trash data Delete Code start-------------------------------
    public function trashDelete(string $id)
    {
        $newsletter = Newsletter::withTrashed()->find($id);
        if (!is_null($newsletter)) {
            if ($newsletter->image != null) {
                $content = @file_get_contents(public_path() . '/images/newsletter/' . $newsletter->image);
                if ($content) {
                    unlink(public_path() . "/images/newsletter/" . $newsletter->image);
                }
            }
            $newsletter->forceDelete();

            return redirect('admin/post/trash')->with('delete','Data Delete Successfully');
        }
        return redirect('admin/newsletter')->with('delete','Trash Data Delete Successfully');
    }
    //----------------------------------Trash data Delete Code start-------------------------------


    //----------------------------------Subscribe Code start-------------------------------
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $mailchimp = new MailChimp(env('MAILCHIMP_APIKEY'));

        $listId = env('MAILCHIMP_LIST_ID');
        $response = $mailchimp->get("lists/$listId/members/" . md5(strtolower($request->email)));

        if ($mailchimp->success() && isset($response['status']) && $response['status'] === 'subscribed') {
            return redirect()->back()->with('error', 'You are already subscribed to our newsletter.');
        }

        $result = $mailchimp->post("lists/$listId/members", [
            'email_address' => $request->email,
            'status' => 'pending'
        ]);

        if ($mailchimp->success()) {
            NewsletterSubscriber::create([
                'email' => $request->email,
                'status' => 'pending'
            ]);

            return redirect()->back()->with('success', 'Thank you for subscribing to our newsletter!');
        } else {
            return redirect()->back()->with('error', 'Failed to subscribe. Please try again later.');
        }
    }
    //----------------------------------Subscribe Code end-------------------------------

    //----------------------------------mailchimpWebhook Code start-------------------------------
    public function mailchimpWebhook(Request $request)
    {
        // Log the request headers and data for debugging

        try {
            $data = $request->json()->all();

            // Check if this is a subscription event
            if ($data['type'] == 'subscribe') {
                $email = $data['data']['email'];
                $listId = $data['data']['list_id'];

                $subscriber = NewsletterSubscriber::where('email', $email)->first();

                if ($subscriber) {
                    $subscriber->status = 'subscribed';
                    $subscriber->mailchimp_list_id = $listId;
                    $subscriber->save();
                } else {
                    // Handle the case where the subscriber doesn't exist
                }
            }

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            Log::error('Mailchimp Webhook Error:', ['message' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    //----------------------------------mailchimpWebhook Code end -------------------------------

    //----------------------------------newsletter reports Code star t-------------------------------
    public function reports() {
        $subscribers = NewsletterSubscriber::all();
        $activeStatus = NewsletterSubscriber::where('status','subscribed')->count();
        $nonactiveStatus = NewsletterSubscriber::where('status','pending')->count();
        return view('admin.newsletter.reports',compact('subscribers','nonactiveStatus','activeStatus'));
    }
    //----------------------------------newsletter reports Code end -------------------------------


}
