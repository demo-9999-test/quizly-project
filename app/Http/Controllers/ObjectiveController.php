<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Objective;
use App\Models\Matche;
use App\Models\Quiz;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportMcq;
use App\Imports\Importtruefalse;
use App\Imports\ImportFillBlank;
use App\Imports\ImportMatchFollowing;
use App\Models\user;
use App\Models\GeneralSetting;
use App\Models\ObjectiveAnswer;
use Laracasts\Flash\Flash;

class ObjectiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:objective.view', ['only' => ['index', 'show']]);
        $this->middleware('permission:objective.create', ['only' => ['create', 'create_post', 'importSave']]);
        $this->middleware('permission:objective.edit', ['only' => ['edit', ' edit_post', 'updateStatus', 'updateOrder']]);
        $this->middleware('permission:objective.delete', ['only' => ['delete', 'bulk_delete', 'trash_bulk_delete', 'trash', 'restore', 'trashDelete']]);
    }
    //---------------------------------- Page View Code Start-------------------------------
    public function index($id)
    {
        $quiz = Quiz::find($id);
        $obj = Objective::all();

        foreach ($obj as $objective) {
            if ($objective->ques_type == 'match_following') {
                $objective->option_a = explode(' || ', $objective->option_a);
                $objective->option_b = explode(' || ', $objective->option_b);
                $objective->correct_answer = explode(' || ', $objective->correct_answer);
            }
        }

        return view('admin.quiz.objective.index', compact('obj', 'quiz'));
    }
    //---------------------------------- Page View Code End-------------------------------

    //---------------------------------- Create Page Code Start-------------------------------
    public function create($id)
    {
        $quiz = Quiz::find($id);
        return view('admin.quiz.objective.create', compact('quiz'));
    }
    //---------------------------------- Create Page Code End-------------------------------

    //---------------------------------- Data Store Code start-------------------------------
    public function create_post(Request $request, $id)
    {
        try {
            $quiz = Quiz::find($id);
            if ($request->ques_type == 'true_false') {
                $request->validate([
                    'question' => 'required|string|max:255',
                    'option_a' => 'required|string',
                    'option_b' => 'required|string',
                    'correct_answer' => 'required|string',
                    'ques_type' => 'required|string',
                    'video' => 'string|nullable',
                    'audio' => 'string|nullable',
                    'image' => 'image|mimes:jpeg,jpg,png,svg|nullable',
                    'mark' => 'required|numeric',
                ]);

                $objective = new Objective();
                $objective->question = $request->question;
                $objective->option_a = $request->option_a;
                $objective->option_b = $request->option_b;
                $objective->option_c = null;
                $objective->option_d = null;
                $objective->ques_type = $request->ques_type;
                $objective->correct_answer = $request->correct_answer;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('images/quiz/objective/true_false', $filename);
                    $objective->image = $filename;
                }
                $objective->video = $request->video;
                $objective->audio = $request->audio;
                $objective->mark = $request->mark;
                $objective->quiz_id = $quiz->id;
                $objective->save();
            } elseif ($request->ques_type == 'multiple_choice') {
                $request->validate([
                    'question' => 'required|string|max:255',
                    'option_a' => 'required|string',
                    'option_b' => 'required|string',
                    'option_c' => 'required|string',
                    'option_d' => 'required|string',
                    'correct_answer' => 'required|string',
                    'ques_type' => 'required|string',
                    'video' => 'string|nullable',
                    'audio' => 'string|nullable',
                    'image' => 'image|mimes:jpeg,jpg,png,svg|nullable',
                    'mark' => 'required|numeric',
                ]);

                $objective = new Objective();
                $objective->question = $request->question;
                $objective->option_a = $request->option_a;
                $objective->option_b = $request->option_b;
                $objective->option_c = $request->option_c;
                $objective->option_d = $request->option_d;
                $objective->correct_answer = $request->correct_answer;
                $objective->ques_type = $request->ques_type;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('images/quiz/objective/multiple_choice', $filename);
                    $objective->image = $filename;
                }
                $objective->video = $request->video;
                $objective->audio = $request->audio;
                $objective->mark = $request->mark;
                $objective->quiz_id = $quiz->id;
                $objective->save();
            } elseif ($request->ques_type == 'fill_blank') {
                $request->validate([
                    'question' => 'required|string|max:255',
                    'correct_answer' => 'required|string',
                    'ques_type' => 'required|string',
                    'video' => 'string|nullable',
                    'audio' => 'string|nullable',
                    'image' => 'image|mimes:jpeg,jpg,png,svg|nullable',
                    'mark' => 'required|numeric',
                ]);
                $objective = new Objective();
                $objective->question = $request->question;
                $objective->correct_answer = $request->correct_answer;
                $objective->ques_type = $request->ques_type;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('images/quiz/objective/fill_blank', $filename);
                    $objective->image = $filename;
                }
                $objective->video = $request->video;
                $objective->audio = $request->audio;
                $objective->mark = $request->mark;
                $objective->quiz_id = $quiz->id;
                $objective->save();
            } elseif ($request->ques_type == 'match_following') {
                $request->validate([
                    'question' => 'required|string|max:255',
                    'option_a' => 'required|array|min:1',
                    'option_a.*' => 'required|string|max:255',
                    'option_b' => 'required|array|min:1',
                    'option_b.*' => 'required|string|max:255',
                    'correct_answer' => 'required|array|min:1',
                    'correct_answer.*' => 'required|string|max:255',
                    'video' => 'string|nullable',
                    'audio' => 'string|nullable',
                    'image' => 'image|mimes:jpeg,jpg,png,svg|nullable',
                    'mark' => 'required|numeric',
                    'ques_type' => 'required|string',
                ]);

                $objective = new Objective();
                $objective->question = $request->question;
                $objective->option_a = implode(' || ', $request->option_a);
                $objective->option_b = implode(' || ', $request->option_b);

                $objective->correct_answer = implode(' || ', $request->correct_answer);

                $objective->ques_type = $request->ques_type;

                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('images/quiz/objective/match_following', $filename);
                    $objective->image = $filename;
                }
                $objective->mark = $request->mark;
                $objective->video = $request->video;
                $objective->audio = $request->audio;
                $objective->quiz_id = $quiz->id;
                $objective->save();
            }

            if ($request->input('action') == 'add') {
                return redirect()->route('objective.index', ['id' => $quiz->id])->with('success', 'Question added successfully');
            } else {
                return redirect()->route('objective.create', ['id' => $quiz->id])->with('success', 'Question added successfully');
            }
        } catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding the question: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data Store Code End-------------------------------

    //---------------------------------- Edit Page Code start-------------------------------
    public function edit($id, $obj_id)
    {
        $quiz = Quiz::find($id);
        $obj = Objective::find($obj_id);

        $obj->option_a = explode(' || ', $obj->option_a);
        $obj->option_b = explode(' || ', $obj->option_b);
        $obj->correct_answer = explode(' || ', $obj->correct_answer);
        if (!$obj) {
            abort(404);
        }

        return view('admin.quiz.objective.edit', compact('quiz', 'obj'));
    }
    //---------------------------------- Edit Page Code end-------------------------------

    //---------------------------------- Update Code start-------------------------------
    public function edit_post(Request $request, $id, $obj_id)
    {
        try {
            $quiz = Quiz::find($id);
            if ($request->ques_type == 'true_false') {
                $request->validate([
                    'question' => 'required|string|max:255',
                    'option_a' => 'required|string',
                    'option_b' => 'required|string',
                    'correct_answer' => 'required|string',
                    'video' => 'string|nullable',
                    'audio' => 'string|nullable',
                    'image' => 'image|mimes:jpeg,jpg,png,svg|nullable',
                    'ques_type' => 'required|string',
                    'mark' => 'required|numeric',
                ]);

                $obj = Objective::findOrFail($obj_id);
                $obj->question = $request->input('question');
                $obj->option_a = $request->input('option_a');
                $obj->option_b = $request->input('option_b');
                $obj->correct_answer = $request->input('correct_answer');
                $obj->video = $request->input('video');
                $obj->audio = $request->input('audio');
                $obj->mark = $request->input('mark');
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('images/quiz/objective/true_false', $filename);
                    if ($obj->image != null) {
                        $existingImagePath = public_path('images/quiz/objective/true_false/' . $obj->image);
                        if (file_exists($existingImagePath)) {
                            unlink($existingImagePath);
                        }
                    }
                    $obj->image = $filename;
                }
                $obj->save();
            } elseif ($request->ques_type == 'multiple_choice') {

                $request->validate([
                    'question' => 'required|string|max:255',
                    'option_a' => 'required|string|max:255',
                    'option_b' => 'required|string|max:255',
                    'option_c' => 'required|string|max:255',
                    'option_d' => 'required|string|max:255',
                    'correct_answer' => 'required|string|max:255',
                    'ques_type' => 'required|string',
                    'video' => 'string|nullable',
                    'audio' => 'string|nullable',
                    'image' => 'image|mimes:jpeg,jpg,png,svg|nullable',
                    'mark' => 'required|numeric',
                ]);

                $obj = Objective::findOrFail($obj_id);
                $obj->question = $request->input('question');
                $obj->option_a = $request->input('option_a');
                $obj->option_b = $request->input('option_b');
                $obj->option_c = $request->input('option_c');
                $obj->option_d = $request->input('option_d');
                $obj->correct_answer = $request->input('correct_answer');
                $obj->video = $request->input('video');
                $obj->audio = $request->input('audio');
                $obj->mark = $request->input('mark');
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('images/quiz/objective/multiple_choice', $filename);
                    if ($obj->image != null) {
                        $existingImagePath = public_path('images/quiz/objective/multiple_choice/' . $obj->image);
                        if (file_exists($existingImagePath)) {
                            unlink($existingImagePath);
                        }
                    }
                    $obj->image = $filename;
                }
                $obj->save();
            } elseif ($request->ques_type == 'fill_blank') {
                $request->validate([
                    'question' => 'required|string|max:255',
                    'correct_answer' => 'required|string|max:255',
                    'video' => 'string|nullable',
                    'audio' => 'string|nullable',
                    'ques_type' => 'required|string',
                    'image' => 'image|mimes:jpeg,jpg,png,svg|nullable',
                    'mark' => 'required|numeric',
                ]);
                $obj = Objective::findOrFail($obj_id);
                $obj->question = $request->input('question');
                $obj->correct_answer = $request->input('correct_answer');
                $obj->video = $request->input('video');
                $obj->audio = $request->input('audio');
                $obj->mark = $request->input('mark');
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('images/quiz/objective/fill_blank', $filename);
                    if ($obj->image != null) {
                        $existingImagePath = public_path('images/quiz/objective/fill_blank/' . $obj->image);
                        if (file_exists($existingImagePath)) {
                            unlink($existingImagePath);
                        }
                    }
                    $obj->image = $filename;
                }
                $obj->save();
            } elseif ($request->ques_type == 'match_following') {
                $request->validate([
                    'question' => 'required|string|max:255',
                    'option_a' => 'required|array|min:1',
                    'option_a.*' => 'required|string|max:255',
                    'option_b' => 'required|array|min:1',
                    'option_b.*' => 'required|string|max:255',
                    'correct_answer' => 'required|array|min:1',
                    'correct_answer.*' => 'required|string|max:255',
                    'video' => 'string|nullable',
                    'audio' => 'string|nullable',
                    'image' => 'image|mimes:jpeg,jpg,png,svg|nullable',
                    'mark' => 'numeric',
                ]);
                $obj = Objective::findOrFail($obj_id);
                $obj->option_a = explode(' || ', $obj->option_a);
                $obj->option_b = explode(' || ', $obj->option_b);
                $obj->correct_answer = explode(' || ', $obj->correct_answer);
                $obj->ques_type = $request->ques_type;
                $obj->mark = $request->input('mark');
                if ($request->hasFile('image')) {
                    if ($obj->image) {
                        $oldImagePath = public_path('images/quiz/objective/match_following/' . $obj->image);
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }

                    // Upload and save the new image
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('images/quiz/objective/match_following', $filename);
                    $obj->image = $filename;
                }

                $obj->video = $request->video;
                $obj->audio = $request->audio;
                $obj->quiz_id = $request->quiz_id;

                $obj->save();
            }

            return redirect('admin/objective/' . $quiz->id)->with('success', 'Question updated successfully!');
        } catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating the answer: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }

    //---------------------------------- Update Code End-------------------------------

    //---------------------------------- Data Delete Code start-------------------------------
    public function delete($id, $obj_id)
    {
        $quiz = Quiz::find($id);
        if (!$quiz) {
            return redirect()->back()->with('error', 'Question not found!');
        }

        $obj = Objective::find($obj_id);
        if (!$obj) {
            return redirect()->back()->with('error', 'Question not found!');
        }

        $obj->delete();
        return redirect('admin/objective/' . $quiz->id)->with('delete', 'Question deleted successfully!');
    }
    //---------------------------------- Data Delete Code End-------------------------------

    //---------------------------------- Data Selected Delete Code start-------------------------------
    public function bulk_delete(Request $request, $id)
    {
        $quiz = Quiz::find($id);
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('warning', 'Atleast one item is required to be checked');
        } else {
            Objective::whereIn('id', $request->checked)->delete();
            return redirect('admin/objective/' . $quiz->id)->with('delete', 'Data Deleted Successfully');
        }
    }
    //---------------------------------- Data Selected Delete Code end-------------------------------

    public function import($id)
    {
        $quiz = Quiz::findOrFail($id);
        return view('admin.quiz.objective.import', compact('quiz'));
    }
    //-------------------------------data import code end--------------------------

    //-------------------------------data import code start--------------------------
    public function importMcq(Request $request, $id)
    {
        try {
            $quiz = Quiz::findOrFail($id);
            Excel::import(new ImportMcq, $request->file('file')->store('files'));
            return view('admin.quiz.objective.import', compact('quiz'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error importing data: ' . $e->getMessage());
        }
    }
    //-------------------------------data import code end--------------------------

    //------------------------------- importFileSave code start-----------------------
    public function importTrueFalse(Request $request, $id)
    {
        try {
            $quiz = Quiz::findOrFail($id);
            Excel::import(new Importtruefalse, $request->file('file')->store('files'));
            return view('admin.quiz.objective.import', compact('quiz'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error importing data: ' . $e->getMessage());
        }
    }
    //------------------------------- importFileSave code end-----------------------

    //------------------------------- importFileSave code start-----------------------
    public function importFillBlank(Request $request, $id)
    {
        try {
            $quiz = Quiz::findOrFail($id);
            Excel::import(new importFillBlank, $request->file('file')->store('files'));
            return view('admin.quiz.objective.import', compact('quiz'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error importing data: ' . $e->getMessage());
        }
    }
    public function importMatchFollowing(Request $request, $id)
    {
        try {
            $quiz = Quiz::findOrFail($id);
            Excel::import(new ImportMatchFollowing, $request->file('file')->store('files'));
            return view('admin.quiz.objective.import', compact('quiz'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error importing data: ' . $e->getMessage());
        }
    }
    //------------------------------- importFileSave code end-----------------------

    //---------------------------------- trash Code start-------------------------------
    public function trash($id)
    {
        $quiz = Quiz::find($id);
        $obj = Objective::onlyTrashed()->get();
        return view('admin.quiz.objective.trash', compact('quiz', 'obj'));
    }
    //---------------------------------- trash Code end---------------------------------------

    //---------------------------------- Data restore Code start-------------------------------
    public function restore($id, $obj_id)
    {
        $quiz = Quiz::find($id);
        $obj = Objective::withTrashed()->find($obj_id);
        if (!is_null($obj)) {
            $obj->restore();
        }
        return redirect('admin/objective/trash/' . $quiz->id)->with('success', 'Trash Data restore Successfully');
    }
    //---------------------------------- Data restore Code End-------------------------------

    //---------------------------------- Trash data Delete Code start-------------------------------
    public function trashDelete($id, $obj_id)
    {
        $quiz = Quiz::find($id);
        $obj = Objective::withTrashed()->find($obj_id);
        if (!is_null($obj)) {
            $obj->forceDelete();
            return redirect('admin/objective/trash/' . $quiz->id)->with('delete', 'Data Delete Successfully');
        }
        return redirect('admin/objective/trash/' . $quiz->id)->with('delete', 'Trash Data Delete Successfully');
    }
    //----------------------------------Trash data Delete Code start-------------------------------

    //---------------------------------- Data Selected Delete Code start-------------------------------
    public function trash_bulk_delete(Request $request, $id)
    {
        $quiz = Quiz::find($id);

        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('warning', 'Atleast one item is required to be checked');
        } else {
            Objective::whereIn('id', $request->checked)->forceDelete();
            return redirect('admin/objective/' . $quiz->id)->with('delete', 'Data Delete Successfully');
        }
    }
    //---------------------------------- Data Selected Delete Code end-------------------------------

    //--------------------------------- Result page code start ----------------------------------
    public function result_page($quiz_id, $user_id)
    {
        $setting = GeneralSetting::first();
        $quiz = Quiz::findOrFail($quiz_id);
        $totalQuestions = Objective::where('quiz_id', $quiz_id)->count();
        $totalMarks = Objective::where('quiz_id', $quiz_id)->sum('mark');
        $userAnswer = ObjectiveAnswer::where('quiz_id', $quiz_id)->where('user_id', $user_id)->with('question')->cursor();
        $userCorrectAnswers = ObjectiveAnswer::where('quiz_id', $quiz_id)
            ->where('user_id', $user_id)
            ->where('answer_approved', '1')
            ->count();

        // $userTotal = ($userCorrectAnswers / $totalQuestions) * $totalMarks;
        if ($totalQuestions > 0) {
            $userTotal = ($userCorrectAnswers / $totalQuestions) * $totalMarks;
        } else {
            $userTotal = 0;
        }
        
        $passingMarks = ceil($totalMarks * 0.33);

        $isPassed = $userTotal >= $passingMarks;
        $user = User::where('id', $user_id)->first();
        return view('front.objective_result', compact('setting', 'quiz', 'totalMarks', 'passingMarks', 'userTotal', 'isPassed', 'userCorrectAnswers', 'totalQuestions', 'userAnswer', 'user'));
    }
    //--------------------------------- Result page code end ----------------------------------

    //---------------------------------- Check Answers table Code start-------------------------------
    public function checkAnswers($id)
    {
        $answers = ObjectiveAnswer::where('quiz_id', $id)
            ->with('user:id,name,image')
            ->get()
            ->groupBy('user_id')
            ->map(function ($userAnswers) {
                return [
                    'user' => $userAnswers->first()->user,
                    'total' => $userAnswers->count(),
                    'attempted' => $userAnswers->whereNotNull('user_answer')->count(),
                    'skipped' => $userAnswers->whereNull('user_answer')->count(),
                ];
            });

        return view('admin.quiz.objective.result_table', compact('answers', 'id'));
    }
    //---------------------------------- Check Answers table Code end-------------------------------

    //---------------------------------- Check result Code start-----------------------------
    public function checkResult($id, $user_id)
    {
        $quiz_id =  $id;
        $question = ObjectiveAnswer::where('quiz_id', $id)->where('user_id', $user_id)->get();
        $quiz = Quiz::where('id', $id)->first();
        $user = User::where('id', $user_id)->first();
        return view('admin.quiz.objective.objective_result', compact('quiz', 'user', 'quiz_id', 'question'));
    }
    //---------------------------------- Check result Code start-----------------------------
}
