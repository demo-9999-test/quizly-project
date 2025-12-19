<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pages;
use Laracasts\Flash\Flash;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pages.view', ['only' => ['index','show']]);
        $this->middleware('permission:pages.create', ['only' => ['store']]);
        $this->middleware('permission:pages.edit', ['only' => ['edit', ' update','updateStatus','updateOrder']]);
        $this->middleware('permission:pages.delete', ['only' => ['destroy','bulk_delete','trash_bulk_delete','trash','restore','trashDelete']]);
    }
    //---------------------------------- Page View Code start-------------------------------
    public function index()
    {
        return view('admin.pages.index');
    }
//---------------------------------- Page View Code end-------------------------------

//---------------------------------- Data Store Code start-------------------------------
    public function store(Request $request)
    {
        try{
            $request->validate([
                'title' => 'required',
                'slug' => 'required',
                'desc' => 'required',
                'page_link' => 'required',
            ]);

            // Create a new pages record with specific fields
            $pages = new Pages;
            $pages->title = $request->input('title');
            $pages->slug = $request->input('slug');
            $pages->desc = $request->input('desc');
            $pages->page_link = $request->input('page_link');
            $action = $request->input('status');
            if ($action === 'draft') {
                $pages->status = 0; // Draft status
            } elseif ($action === 'publish') {
                $pages->status = 1; // Publish status
            }
            $pages->save();

            return redirect('admin/pages')->with('success','Data has been added.');
        }catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding Pages: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    public function copy(string $id)
    {
        $page = Pages::find($id);
        if (!$page) {
            Flash::error('Page not found')->important();
            return redirect('admin/pages');
        }

        $newPage = $page->replicate();
        $newPage->title = $page->title;

        // Generate a unique slug
        $originalSlug = preg_replace('/-copy-\d+$/', '', $page->slug);
        $count = 1;
        do {
            $newSlug = $originalSlug . '-copy-' . $count;
            $count++;
        } while (Pages::where('slug', $newSlug)->exists());

        $newPage->slug = $newSlug;
        $newPage->status = 0; // Set as draft
        $newPage->save();

        Flash::success('Page has been copied successfully.')->important();
        return redirect('admin/pages');
    }
//---------------------------------- Data Store Code end-------------------------------

//---------------------------------- All Data Show Code start-------------------------------

    public function show(Request $request)
    {
        $pages = Pages::orderBy('position')->paginate(7);
        return view('admin.pages.index', compact('pages'));
    }
//---------------------------------- All Data Show Code end-------------------------------

//---------------------------------- Edit Page Code start---------------------------------
    public function edit(string $id)
    {
        $pages = Pages::find($id);
        if (!$pages) {
            return redirect('admin/pages')->with('error','page not found');
        }
        return view('admin.pages.edit', compact('pages'));
    }
//---------------------------------- Edit Page Code end-------------------------------

//---------------------------------- Update Code start-------------------------------
    public function update(Request $request, string $id)
    {
        try{
            $pages = Pages::find($id);
            if (!$pages) {
                Flash::error('pages not found')->important();
                return redirect('admin/pages');
            }
            $pages->title = $request->input('title');
            $pages->slug = $request->input('slug');
            $pages->desc = $request->input('desc');
            $pages->page_link = $request->input('page_link');
            $action = $request->input('status');
            if ($action === 'draft') {
            $pages->status = 0; // Draft status
            } elseif ($action === 'publish') {
                $pages->status = 1; // Publish status
            }
            $pages->save();
            return redirect('admin/pages')->with('success','Data has been updated.');
        }catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating Pages: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
//---------------------------------- Update Code End-------------------------------

//---------------------------------- Data Delete Code start-------------------------------
    public function destroy(string $id)
    {
        // return $id;
        $pages = Pages::find($id);
        $pages->delete();

        return redirect('admin/pages')->with('delete','Data has been Deleted.');
    }
//---------------------------------- Data Delete Code End-------------------------------

//---------------------------------- Data Selected Delete Code start-------------------------------
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
            Pages::whereIn('id',$request->checked)->delete();
            return redirect('admin/pages')->with('delete','Data Delete Successfully.');
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
        Pages::whereIn('id',$request->checked)->forceDelete();
        return redirect('admin/pages')->with('delete','Data Delete Successfully.');
    }
}
//---------------------------------- Data Selected Delete tarsh Code end-------------------------------

//---------------------------------- trash Code start-------------------------------
public function trash()
{
    $pages = Pages::onlyTrashed()->get();
    return view('admin.pages.trash', compact('pages'));
}
//---------------------------------- trash Code end-------------------------------

//---------------------------------- Data restore Code start-------------------------------
public function restore(string $id)
{
    $pages = Pages::withTrashed()->find($id);
    if(!is_null($pages)){
    $pages->restore();
    }

    return redirect('admin/pages')->with('success','Trash Data restore Successfully.');
}
//---------------------------------- Data restore Code End-------------------------------

//---------------------------------- Trash data Delete Code start-------------------------------
public function trashDelete(string $id)
{
    $pages = Pages::withTrashed()->find($id);
    if(!is_null($pages)){
        $pages->forceDelete();
    }

    return redirect('admin/pages')->with('delete','Trash Data Delete Successfully.');
}
//----------------------------------Trash data Delete Code start-------------------------------

//---------------------------------- Status  Code start-------------------------------
public function updateStatus(Request $request)
{
    // return $request;
    $Pages = Pages::find($request->id);
    $Pages->status = $request->status;
    $Pages->save();
    Flash::success('Status change Successfully.')->important();

    return redirect('admin/pages');
}
//---------------------------------- Status  Code end-------------------------------

//-----------------------darg and drop order update code  start -----------------
public function updateOrder(Request $request)
{
    $id = $request->input('id');
    $position = $request->input('position');

    $pages = Pages::find($id);
    $pages->position = $position;
    $pages->save();

    return response()->json(['success' => true]);
}
//  -----------------------darg and drop order update code  end -----------------
}


