<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
use App\Models\GeneralSetting;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:contact.view', ['only' => ['show']]);
        $this->middleware('permission:contact.create', ['only' => ['store']]);
        $this->middleware('permission:contact.delete', ['only' => ['destroy','bulk_delete']]);
    }

    //--------------------------- Show code start --------------------------
    public function show()
    {
            $contacts = Contact::paginate(10);
        return view('admin.contact.show', ['contacts' => $contacts]);
    }
    //--------------------------- Show code end --------------------------

    //--------------------------- store code start --------------------------
    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'mobile' => 'required',
            ]);
            $contact = new Contact;
            $contact->name = $request->input('name');
            $contact->subject = $request->input('subject');
            $contact->email = $request->input('email');
            $contact->mobile = $request->input('mobile');
            $contact->msg = $request->input('msg');
            $contact->save();
            return redirect('admin/contact')->with('success','Data has been added.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding the contact: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //--------------------------- store code end --------------------------

    //--------------------------- destroy code start --------------------------
    public function destroy($id)
    {
        $contact = Contact::find($id);
        $contact->delete();

        return redirect('admin/contact')->with('delete','Data Deleted Successfully');
    }
    //--------------------------- destroy code end --------------------------

    //--------------------------- bulk_delete code start --------------------------
    public function bulk_delete(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {

            return back()->with('warning','Atleast one item is required to be checked');
        }
        else{
            Contact::whereIn('id',$request->checked)->delete();
            return redirect('admin/contact')->with('success','Data Delete Successfully');
        }
    }
    //--------------------------- bulk_delete code end --------------------------

    //--------------------------- Contact us front page start -------------------------------
    public function contact_page() {
        $setting = Generalsetting::first();
        return view('front.contact_us',compact('setting'));
    }
    //--------------------------- Contact us front page end -------------------------------
    //-------------------------- Send message code start ----------------------------------
    public function send_message(Request $request) {
        try{
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'number' => 'required|numeric',
                'message' => 'required'
            ]);
            $contact = new Contact;
            $contact->name = $request->input('name');
            $contact->subject = $request->input('subject');
            $contact->email = $request->input('email');
            $contact->mobile = $request->input('number');
            $contact->msg = $request->input('message');
            $contact->save();
            return redirect()->back()->with('success','Message sent successfully');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while sending message: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //-------------------------- Send message code end ----------------------------------

}
