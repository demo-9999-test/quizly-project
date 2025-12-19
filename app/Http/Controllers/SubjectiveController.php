<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SubjectiveAnswer;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Subjective;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportSubjective;
use Illuminate\Support\Facades\Validator;
use App\Models\GeneralSetting;
use Laracasts\Flash\Flash;
class SubjectiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:subjective.view', ['only' => ['index','show','checkAnswers']]);
        $this->middleware('permission:subjective.create', ['only' => ['create','create_post','importSave']]);
        $this->middleware('permission:subjective.edit', ['only' => ['edit', ' edit_post','updateStatus','updateOrder']]);
        $this->middleware('permission:subjective.delete', ['only' => ['delete','bulk_delete','trash_bulk_delete','trash','restore','trashDelete']]);
    }
    //---------------------------------- Page View Code Start-------------------------------
    public function index($id){
        $quiz = Quiz::find($id);
        $sub = Subjective::all();
        return view('admin.quiz.subjective.index', compact('sub','quiz'));
    }
    //---------------------------------- Page View Code End-----------------------------------

    //---------------------------------- Create Page Code Start-------------------------------
    public function create($id){
        $quiz = Quiz::find($id);
        return view('admin.quiz.subjective.create',compact('quiz'));
    }
    //---------------------------------- Create Page Code End-------------------------------

    //---------------------------------- Data Store Code start-------------------------------
    public function create_post(Request $request,$id){
        try{
            $quiz = Quiz::find($id);
            $request->validate([
                'question' => 'required|string|max:255',
                'video' => 'string|nullable',
                'audio' => 'string|nullable',
                'image' => 'image|mimes:jpeg,jpg,png,svg|nullable',
                'mark' => 'numeric',
            ]);
            $sub = new Subjective();
            $sub->question = $request->question;
            $sub->video = $request->video;
            $sub->audio = $request->audio;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/quiz/subjective', $filename);
                $sub->image = $filename;
            }
            $sub->mark = $request->mark;
            $sub->quiz_id = $quiz->id;
            $sub->save();

            if ($request->input('action') == 'add') {
                return redirect()->route('subjective.index',['id'=> $quiz->id])->with('success','Question added successfully');;
            } else {
                return redirect()->route('subjective.create',['id'=> $quiz->id])->with('success','Question added successfully');
            }
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding the question: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data Store Code End-------------------------------

    //---------------------------------- Edit Page Code start-------------------------------
    public function edit($id, $sub_id) {
        $quiz = Quiz::find($id);
        $sub = Subjective::find($sub_id);

        if (!$sub) {
            abort(404);
        }

        return view('admin.quiz.subjective.edit', compact('quiz', 'sub'));
    }
    //---------------------------------- Edit Page Code end-------------------------------

    //---------------------------------- Update Code start-------------------------------
    public function edit_post(Request $request, $id, $sub_id){
        try {
            $quiz = Quiz::find($id);
            $request->validate([
                'question' => 'required|string|max:255',
                'video' => 'string|nullable',
                'audio' => 'string|nullable',
                'image' => 'image|mimes:jpeg,jpg,png,svg|nullable',
                'mark' => 'numeric',
            ]);
            $sub = Subjective::findOrFail($sub_id);

            $sub->question = $request->input('question');
            $sub->video = $request->input('video');
            $sub->audio = $request->input('audio');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/quiz/subjective/', $filename);
                if ($sub->image != null) {
                    $existingImagePath = public_path('images/quiz/subjective/' . $sub->image);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }
                $sub->image = $filename;
            }
            $sub->mark = $request->input('mark');
            $sub->save();
            return redirect('admin/subjective/'.$quiz->id)->with('success', 'Question updated successfully!');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating the question: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Update Code end-------------------------------

    //---------------------------------- Data Delete Code start-------------------------------
    public function delete($id,$sub_id){
        $quiz = Quiz::find($id);
        if (!$quiz) {
            return redirect()->back()->with('error', 'Question not found!');
        }
        $sub = Subjective::find($sub_id);
        if (!$sub) {
            return redirect()->back()->with('error', 'Question not found!');
        }
        $sub->delete();
        return redirect('admin/subjective/'.$quiz->id)->with('delete', 'Question deleted successfully!');
    }
    //---------------------------------- Data Delete Code End-------------------------------

    //---------------------------------- Data Selected Delete Code start-------------------------------
    public function bulk_delete(Request $request,$id){
        $quiz=Quiz::find($id);
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('warning', 'Atleast one item is required to be checked');
        }
        else{
            Subjective::whereIn('id',$request->checked)->delete();
            return redirect('admin/subjective/'.$quiz->id)->with('delete', 'Data Deleted Successfully');
        }
    }
    //---------------------------------- Data Selected Delete Code end-------------------------------

    //-------------------------------data import code start--------------------------
    public function import($id)
    {
        $quiz = Quiz::findOrFail($id);
        return view('admin.quiz.subjective.import',compact('quiz'));
    }
    //-------------------------------data import code end--------------------------

    //------------------------------- importFileSave code start-----------------------
    public function importSave(Request $request, $id){
        try {
            $quiz = Quiz::findOrFail($id);

            Excel::import(new ImportSubjective, $request->file('file')->store('files'));

            return view('admin.quiz.subjective.import', compact('quiz'))
                ->with('success', 'Data imported successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error importing data: ' . $e->getMessage());
        }
    }
    //------------------------------- importFileSave code end-----------------------

    //---------------------------------- trash Code start-------------------------------
    public function trash($id)
    {
        $quiz = Quiz::find($id);
        $sub = Subjective::onlyTrashed()->get();
        return view('admin.quiz.subjective.trash', compact('quiz','sub'));
    }
    //---------------------------------- trash Code end-------------------------------

    //---------------------------------- Data restore Code start-------------------------------
    public function restore($id,$sub_id)
    {
        $quiz = Quiz::find($id);
        $sub = Subjective::withTrashed()->find($sub_id);
        if(!is_null($sub)){
            $sub->restore();
        }
        return redirect('admin/subjective/trash/' .$quiz->id)->with('success','Trash Data restore Successfully');
    }
    //---------------------------------- Data restore Code End-------------------------------

    //---------------------------------- Trash data Delete Code start-------------------------------
    public function trashDelete($id, $sub_id)
    {
        $quiz = Quiz::find($id);
        $sub = Subjective::withTrashed()->find($sub_id);
        if (!is_null($sub)) {
            if ($sub->image != null) {
                $content = @file_get_contents(public_path() . '/images/quiz/subjective/' . $sub->image);
                if ($content) {
                    unlink(public_path() . "/images/quiz/subjective/" . $sub->image);
                }
            }
            $sub->forceDelete();
            return redirect('admin/subjective/trash/'.$quiz->id)->with('delete', 'Data Delete Successfully');
        }
        return redirect('admin/subjective/trash/' .$quiz->id )->with('delete','Trash Data Delete Successfully');
    }
    //----------------------------------Trash data Delete Code start-------------------------------

    //---------------------------------- Data Selected Delete Code start-------------------------------
    public function trash_bulk_delete(Request $request,$id){
        $quiz = Quiz::find($id);
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('warning', 'Atleast one item is required to be checked');
        }
        else{
            Subjective::whereIn('id',$request->checked)->forceDelete();
            return redirect('admin/subjective/'.$quiz->id)->with('success','Data Delete Successfully');
        }
    }
    //---------------------------------- Data Selected Delete Code end-------------------------------

    //---------------------------------- Checl Answers table Code start-------------------------------
    public function checkAnswers($id) {
        $answers = SubjectiveAnswer::where('quiz_id', $id)
            ->with('user:id,name,image')
            ->get()
            ->groupBy('user_id')
            ->map(function ($userAnswers) {
                return [
                    'user' => $userAnswers->first()->user,
                    'total' => $userAnswers->count(),
                    'attempted' => $userAnswers->whereNotNull('answer')->count(),
                    'skipped' => $userAnswers->whereNull('answer')->count(),
                ];
            });

        return view('admin.quiz.subjective.result_table', compact('answers', 'id'));
    }
    //---------------------------------- Checl Answers table Code end-------------------------------

    //---------------------------------- Checl result Code start-----------------------------
    public function checkResult($id,$user_id){
        $quiz_id =  $id;
        $question = SubjectiveAnswer::where('quiz_id', $id)->where('user_id',$user_id)->get();
        $quiz = Quiz::where('id',$id)->first();
        $user = User::where('id', $user_id)->first();
        return view('admin.quiz.subjective.subjective_result',compact('quiz','user','quiz_id','question'));
    }
    //---------------------------------- Checl result Code start-----------------------------

    //---------------------------------- correct answer Code start -----------------------------
    public function toggleApprove(Request $request, $id)
    {
        $answer = SubjectiveAnswer::where('id', $id)
            ->where('quiz_id', $request->quiz_id)
            ->where('user_id', $request->user_id)
            ->where('question_id', $request->question_id)
            ->firstOrFail();

        $answer->answer_approved = $request->has('answer_approved');
        $answer->save();

        return redirect()->back()->with('success', 'Answer approval status updated successfully');
    }
    //---------------------------------- correct answer Code end -----------------------------

    //---------------------------------- Result page code start -----------------------------
    public function result_page($quiz_id, $user_id)
    {
        $setting = GeneralSetting::first();
        $quiz = Quiz::findOrFail($quiz_id);
        $totalQuestions = Subjective::where('quiz_id', $quiz_id)->count();
        $totalMarks = Subjective::where('quiz_id', $quiz_id)->sum('mark');
        $userAnswer = SubjectiveAnswer::where('quiz_id', $quiz_id)->where('user_id', $user_id)->with('question')->cursor();
        $userCorrectAnswers = SubjectiveAnswer::where('quiz_id', $quiz_id)
                                            ->where('user_id', $user_id)
                                            ->where('answer_approved', '1')
                                            ->count();

        // Calculate user's total score
        $userTotal = ($userCorrectAnswers / $totalQuestions) * $totalMarks;

        $passingMarks = ceil($totalMarks * 0.33);

        $isPassed = $userTotal >= $passingMarks;
        $user = User::where('id',$user_id)->first();
        return view('front.subjective_result', compact('setting', 'quiz', 'totalMarks', 'passingMarks', 'userTotal', 'isPassed', 'userCorrectAnswers', 'totalQuestions','userAnswer','user'));
    }
    //---------------------------------- Result page code end -----------------------------
}

