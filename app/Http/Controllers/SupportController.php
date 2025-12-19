<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportType;
use App\Models\SupportIssue;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Mail\SupportTicketCreated;
use Illuminate\Support\Facades\Mail;
use App\Mail\SupportReplyNotification;
use App\Models\GeneralSetting;
class SupportController extends Controller
{
    /**
     * Constructor to set up middleware for different permissions
     */
    public function __construct()
    {
        // Middleware for support type operations
        $this->middleware('permission:support_type.view', ['only' => ['SupportType']]);
        $this->middleware('permission:support_type.create', ['only' => ['store']]);
        $this->middleware('permission:support_type.edit', ['only' => ['SupportTypeEdit','SupportTypeUpdate']]);
        $this->middleware('permission:support_type.delete', ['only' => ['SupportTypedestroy','SupportTypebulk_delete']]);

        // Middleware for support issue operations
        $this->middleware('permission:support.view', ['only' => ['Support']]);
        $this->middleware('permission:support.create', ['only' => ['create']]);
        $this->middleware('permission:support.edit', ['only' => ['SupportIssueEdit','SupportIssueUpdate']]);
        $this->middleware('permission:support.delete', ['only' => ['destroy','bulk_delete']]);

        // Middleware for managing all support operations
        $this->middleware('permission:support.manage', ['only' => ['Support','create','SupportIssueEdit','SupportIssueUpdate','destroy','bulk_delete','SupportReply']]);
    }

    /**
     * Display a listing of support issues
     */
    public function index()
    {
        $supports = SupportIssue::orderBy('created_at', 'desc')->get();
        $users = User::where('role','U')->orderBy('id' ,'desc')->get();
        $supportstypes = SupportType::all();
        return view('admin.support.index',compact('supports','users','supportstypes'));
    }

    /**
     * Delete a support issue
     */
    public function destroy($id)
    {
        $contact = SupportIssue::find($id);

        if (!$contact) {
            return redirect('admin/support_admin')->with('error', 'Support issue not found.');
        }

        $contact->delete();

        return redirect('admin/support_admin')->with('delete', 'Support deleted successfully');
    }

    /**
     * Bulk delete support issues
     */
    function Supportbulk_delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('warning','Atleast one item is required to be checked');
        }
        else{
            SupportType::whereIn('id',$request->checked)->delete();
            return redirect('admin/support_type')->with('delete','Support deleted successfully');
        }
    }

    /**
     * Display all support types
     */
     function SupportType() {
        $supports = SupportType::all();
        return view('admin.support.support-type',compact('supports'));
    }

    /**
     * Store a new support type
     */
    public function store(Request $request){
        try{
            $request->validate([
                'name' => 'required',
            ]);
            $support = new SupportType;
            $support->name = $request->input('name');
            $support->status = $request->has('status') && $request->status ? 1 : 0;
            $support->save();
            return redirect('admin/support_type')->with('success','Type added successfully');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding type: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }

    /**
     * Show the form for editing a support type
     */
    public function SupportTypeEdit(string $id)
    {
        $supports_types = SupportType::find($id);
        return view('admin.support.support_type_edit', compact('supports_types'));
    }

    /**
     * Update a support type
     */
    public function SupportTypeUpdate(Request $request, $id)
    {
        try{
            $request->validate([
                'name' => 'required',
            ]);
            $support = SupportType::find($id);
            $support->name = $request->input('name');
            $support->status = $request->has('status') && $request->status ? 1 : 0;
            $support->save();

            return redirect('admin/support_type')->with('success','Type updated successfully');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating type: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }

    /**
     * Delete a support type
     */
    public function SupportTypedestroy($id)
    {
        $contact = SupportType::find($id);
        $contact->delete();
        return redirect('admin/support_type')->with('delete','Type deleted successfully');
    }

    /**
     * Bulk delete support types
     */
    public function SupportTypebulk_delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('warning','Atleast one item is required to be checked');
        }
        else{
            SupportType::whereIn('id',$request->checked)->delete();
            return redirect('admin/support_type')->with('delete','Type deleted successfully');
        }
    }

    /**
     * Show the support creation form
     */
    public function Support()
    {
        $supports = SupportType::all();
        $supportsissues = SupportIssue::where('user_id',Auth::user()->id)->get();
        return view('admin.support.support_create',compact('supports','supportsissues'));
    }

    /**
     * Create a new support issue
     */
    public function create(Request $request)
    {
        $request->validate([
            'priority' => 'required',
            'support_id' => 'required',
            'message' => 'required'
        ]);

        $randomNumber = 'TIC' . rand(100000, 999999);
        $support = new SupportIssue;
        $support->user_id = $request->filled('user_id') ? $request->input('user_id') : Auth::user()->id;
        $support->ticket_id = $randomNumber;
        $support->support_id = $request->input('support_id');
        $support->status ="0";
        $support->priority = $request->input('priority');
        $support->message = $request->input('message');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('images/support_issue', $filename);
            $support->image = $filename;
        }
        $support->save();

        $adminEmails = User::where('role', 'A')->pluck('email')->toArray();
        Mail::to($adminEmails)->send(new SupportTicketCreated($support));

        if(Auth::user()->role=='A' || Auth::user()->role=='A'){
            return redirect('admin/support_admin')->with('success','Support added successfully');
        } else {
            return redirect('admin/support')->with('success','Support added successfully');
        }
    }

    /**
     * Show the form for editing a support issue
     */
    public function SupportIssueEdit(string $id)
    {
        $supportsissues = SupportIssue::find($id);
        $supports_types = SupportType::all();
        return view('admin.support.support_edit', compact('supportsissues','supports_types'));
    }

    /**
     * Update a support issue
     */
    public function SupportIssueUpdate(Request $request, $id)
    {
        $request->validate([
            'priority' => 'required',
            'support_id' => 'required',
            'message' => 'required'
        ]);

        $support = SupportIssue::find($id);
        $support->support_id = $request->input('support_id');
        $support->priority = $request->input('priority');
        $support->message = $request->input('message');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('images/support_issue', $filename);
            if ($support->image != null) {
                $existingImagePath = public_path('images/support_issue/' . $support->image);
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }
            $support->image = $filename;
        }
        $support->save();
        return redirect('admin/support')->with('success','Support updated successfully');
    }

    /**
     * Bulk delete support issues
     */
    public function bulk_delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('warning','Atleast one item is required to be checked');
        }
        else{
            SupportIssue::whereIn('id',$request->checked)->delete();
            return redirect('admin/support')->with('delete','Support deleted successfully');
        }
    }

    /**
     * Reply to a support issue
     */
    public function SupportReply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required'
        ]);

        $support = SupportIssue::find($id);
        $support->reply = $request->input('reply');
        $support->reply_to = "Admin";
        $support->status = "1";
        $support->save();

        // Send email notification to the user
        Mail::to($support->Users->email)->send(new SupportReplyNotification($support));

        return redirect('admin/support_admin');
    }
    /**
     * Support Front
     */
    public function showSupportForm()
    {
        $types = SupportType::all();
        $setting = Generalsetting::first();
        return view('front.support', compact('types','setting'));
    }
    public function submitSupportRequest(Request $request)
    {
        $validatedData = $request->validate([
            'priority' => 'required|in:L,M,H,C',
            'support_id' => 'required|exists:support_types,id',
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $randomNumber = 'TIC' . rand(100000, 999999);

        $support = new SupportIssue;
        $support->user_id = Auth::id();
        $support->ticket_id = $randomNumber;
        $support->support_id = $validatedData['support_id'];
        $support->status = 0;
        $support->priority = $validatedData['priority'];
        $support->message = $validatedData['message'];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('images/support_issue', $filename);
            $support->image = $filename;
        }

        $support->save();
        return redirect()->back()->with('success','Your support message submited successfully');
    }
}
