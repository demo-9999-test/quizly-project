<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\FAQ;
use Laracasts\Flash\Flash;

class FAQController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:faq.view', ['only' => ['index','show']]);
        $this->middleware('permission:faq.create', ['only' => ['store']]);
        $this->middleware('permission:faq.edit', ['only' => ['edit', ' update','updateStatus','updateOrder']]);
        $this->middleware('permission:faq.delete', ['only' => ['destroy','bulk_delete','trash_bulk_delete','trash','restore','trashDelete']]);
    }

        //---------------------------------- Page View Code start-------------------------------
        public function index()
        {
            return view('admin.faq.index');
        }
    //---------------------------------- Page View Code end-------------------------------

    //---------------------------------- Data Store Code start-------------------------------

        public function store(Request $request)
        {
            try{
                $request->validate([
                    'question' => 'required',
                    'answer' => 'required',
                ]);

                // Create a new faq record with specific fields
                $faq = new FAQ;
                $faq->question = $request->input('question');
                $faq->answer = $request->input('answer');
                $faq->status = $request->input('status') ? 1 : 0;
                $faq->save();

                return redirect('admin/faq')->with('success','Data has been added.');
            }catch (\Exception $e) {
                $errorMessage = 'An error occurred while adding FAQ: ' . $e->getMessage();
                return back()->with('error', $errorMessage)->withInput();
            }
        }
        public function copy(string $id)
        {
            $faq = FAQ::find($id);
            if (!$faq) {
                Flash::error('FAQ not found')->important();
                return redirect('admin/faq');
            }

            $newFaq = $faq->replicate();
            $newFaq->question = $newFaq->question;
            $newFaq->save();

            Flash::success('FAQ has been copied successfully.')->important();
            return redirect('admin/faq');
        }
    //---------------------------------- Data Store Code end-------------------------------


    //---------------------------------- All Data Show Code start-------------------------------
        public function show(Request $request)
        {
            $faq = FAQ::orderBy('position')->paginate(7);
            return view('admin.faq.index', compact('faq'));
        }
     //---------------------------------- All Data Show Code end-------------------------------


    //---------------------------------- Edit Page Code start-------------------------------

        public function edit(string $id)
        {
            $faq = FAQ::find($id);
            if (!$faq) {
                Flash::error('faq not found')->important();

                return redirect('admin/faq');
            }
            return view('admin.faq.edit', compact('faq'));
        }
    //---------------------------------- Edit Page Code end-------------------------------


    //---------------------------------- Update Code start-------------------------------

        public function update(Request $request, string $id)
        {
            try{
                $request->validate([
                    'question' => 'required',
                    'answer' => 'required',
                ]);

                $faq = FAQ::find($id);
                if (!$faq) {

                    return redirect('admin/faq')->with('error','faq not found');
                }
                $faq->question = $request->input('question');
                $faq->answer = $request->input('answer');
                $faq->status = $request->input('status') ? 1 : 0;

                $faq->save();

                return redirect('admin/faq')->with('success','faq has been updated.');
            }catch (\Exception $e) {
                $errorMessage = 'An error occurred while updating the FAQ: ' . $e->getMessage();
                return back()->with('error', $errorMessage)->withInput();
            }
        }

    //---------------------------------- Update Code End-------------------------------


    //---------------------------------- Data Delete Code start-------------------------------

        public function destroy($id)
        {
            $faq = FAQ::find($id);
            $faq->delete();
            return redirect('admin/faq')->with('delete','Data Delete Successfully');
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
                }
                else{
                    FAQ::whereIn('id',$request->checked)->delete();

                    return redirect('admin/faq')->with('delete','Data Delete Successfully');
                }
            }
            catch (\Exception $e) {
                $errorMessage = 'An error occurred while deleting the FAQ: ' . $e->getMessage();
                return back()->with('error', $errorMessage)->withInput();
            }
        }

    //---------------------------------- Data Selected Delete Code end-------------------------------

//---------------------------------- Data Selected Delete trash Code start-------------------------------

public function trash_bulk_delete(Request $request){
    // return $request;
    $validator = Validator::make($request->all(), [
        'checked' => 'required',
    ]);
    if ($validator->fails()) {

        return back()->with('warning','Atleast one item is required to be checked');
    }
    else{
        FAQ::whereIn('id',$request->checked)->forceDelete();

        return redirect('admin/faq')->with('delete','Data Delete Successfully');
    }
}
//---------------------------------- Data Selected Delete tarsh Code end-------------------------------

    //---------------------------------- trash Code start-------------------------------
    public function trash()
    {
        $faq = FAQ::onlyTrashed()->get(); // Use onlyTrashed() instead of onlyTrasned()
        // if ($faq->isEmpty()) {
        //     return redirect('admin/faq')->with('error', 'faq not found');
        // }
        return view('admin.faq.trash', compact('faq'));
    }
//---------------------------------- trash Code end-------------------------------


//---------------------------------- Data restore Code start-------------------------------
     public function restore(string $id)
     {
         $faq = FAQ::withTrashed()->find($id);
         if(!is_null($faq)){
            $faq->restore();
         }
         return redirect('admin/faq')->with('success','Data Restore Successfully');
     }
    //---------------------------------- Data restore Code End-------------------------------


    //---------------------------------- Trash data Delete Code start-------------------------------
    public function trashDelete(string $id)
    {
        $faq = FAQ::withTrashed()->find($id);
        if(!is_null($faq)){
            $faq->forceDelete();
         }
        return redirect('admin/faq')->with('delete','Data Delete Successfully');
    }
    //----------------------------------Trash data Delete Code start-------------------------------

    //---------------------------------- Status  Code start-------------------------------

    public function updateStatus(Request $request)
    {
        // return $request;
        $faq = FAQ::find($request->id);
        $faq->status = $request->status;
        $faq->save();
        return response()->json(['message' => 'Status changed successfully'], 200);
    }
    //---------------------------------- Status  Code end-------------------------------

    //  -----------------------darg and drop order update code  start -----------------
    public function updateOrder(Request $request)
    {
        $id = $request->input('id');
        $position = $request->input('position');
        $faq = FAQ::find($id);
        $faq->position = $position;
        $faq->save();
        return response()->json(['success' => true]);
    }
    //  -----------------------darg and drop order update code  end -----------------
}
