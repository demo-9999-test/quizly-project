<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use Maatwebsite\Excel\Facades\Excel;;
use App\Imports\QuizImport;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use App\Models\Objective;
use App\Models\Subjective;
use App\Models\SubjectiveAnswer;
use App\Models\ObjectiveAnswer;
use Auth;
use App\Models\GeneralSetting;
use Carbon\Carbon;
use Laracasts\Flash\Flash;
use App\Models\User;
use App\Models\checkout;
class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:quiz.view', ['only' => ['index','show']]);
        $this->middleware('permission:quiz.create', ['only' => ['create','create_post','importSave']]);
        $this->middleware('permission:quiz.edit', ['only' => ['edit', ' edit_post','updateStatus','updateOrder']]);
        $this->middleware('permission:quiz.delete', ['only' => ['delete','bulk_delete','trash_bulk_delete','trash','restore','trashDelete']]);
    }
    //---------------------------------- Page View Code Start-------------------------------
    public function index()
    {
        $quizzes = Quiz::all();
        $obj_total_marks = [];
        $sub_total_marks = [];

        foreach ($quizzes as $quiz) {
            $obj_total_marks[$quiz->id] = Objective::where('quiz_id', $quiz->id)->sum('mark');
            $sub_total_marks[$quiz->id] = Subjective::where('quiz_id', $quiz->id)->sum('mark');

            if (Carbon::parse($quiz->end_date)->isPast() && $quiz->status == 1) {
                $quiz->status = 0;
                $quiz->save();
            }
        }

        return view('admin.quiz.index', compact('quizzes', 'obj_total_marks', 'sub_total_marks'));
    }
    //---------------------------------- Page View Code End-------------------------------

    //---------------------------------- Create Page Code Start-------------------------------
    public function create(){
        $category = Category::all();
        return view('admin.quiz.create',compact('category'));
    }
    //---------------------------------- Create Page Code End-------------------------------

    //---------------------------------- Data Store Code start-------------------------------
    public function create_post(Request $request)
    {
        try {
            $request->validate([
                'image' => 'image|mimes:jpeg,jpg,png,svg|nullable',
                'name' => 'required|string|max:255|unique:quizes,name',
                'desc' => 'string|nullable',
                'start_date' => 'required',
                'end_date' => 'required|after_or_equal:start_date',
                'timer' => 'required|numeric',
                'subject' => 'required|string|max:255',
                'status' => 'nullable|boolean',
                'reattempt' => 'nullable|boolean',
                'type' => 'nullable|boolean',
                'service' => 'nullable|boolean',
                'fees' => 'nullable|numeric',
                'category_id' => 'required|exists:categories,id'
            ]);

            $quiz = new Quiz();
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/quiz', $filename);
                $quiz->image = $filename;
            }
            $quiz->name = $request->name;
            $quiz->description = strip_tags($request->desc);
            $quiz->start_date = $request->start_date;
            $quiz->end_date = $request->end_date;
            $quiz->timer = $request->timer;
            $quiz->subject = $request->subject;
            $quiz->status = $request->has('status') ? 1 : 0;
            $quiz->reattempt = $request->has('reattempt') ? 1 : 0;
            $quiz->type = $request->input('type', 0);
            $quiz->service = $request->has('service') ? 1 : 0;
            $quiz->question_order = $request->has('question_order') ? 1 : 0;
            $quiz->fees = $request->fees;
            $quiz->category_id = $request->category_id;

            $quiz->save();
            if ($request->input('action') == 'add') {
                return redirect()->route('quiz.index')->with('success','Quiz added successfully');
            } else {
                return redirect()->route('quiz.create')->with('success','Quiz added successfully');
            }
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while adding the quiz: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data Store Code End-------------------------------

    //---------------------------------- Edit Page Code start-------------------------------
    public function edit($id) {
        $quiz = Quiz::find($id);
        if (!$quiz) {
            abort(404);
        }
        $category = Category::all();
        return view('admin.quiz.edit', compact('quiz','category'));
        
    }
    //---------------------------------- Edit Page Code end-------------------------------

    //---------------------------------- Update Code start-------------------------------
    public function edit_post(Request $request, $id)
    {
        try {
            $request->validate([
                'image' => 'image|mimes:jpeg,jpg,png,svg|nullable',
                'name' => 'required|string|max:255',
                'desc' => 'string|nullable',
                'start_date' => 'required',
                'end_date' => 'required|after_or_equal:start_date',
                'timer' => 'required|numeric',
                'subject' => 'required|string|max:255',
                'status' => 'nullable|boolean',
                'reattempt' => 'nullable|boolean',
                'type' => 'nullable|boolean',
                'service' => 'nullable|boolean',
                'question_order' => 'nullable|boolean',
                'fees' => 'nullable|numeric',
                'category_id' => 'required|exists:categories,id'
            ]);

            $quiz = Quiz::findOrFail($id);
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/quiz', $filename);
                if ($quiz->image != null) {
                    $existingImagePath = public_path('images/quiz/' . $quiz->image);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }
                $quiz->image = $filename;
            }

            $quiz->name = $request->input('name');
            $quiz->description = strip_tags($request->desc);
            $quiz->start_date = $request->input('start_date');
            $quiz->end_date = $request->input('end_date');
            $quiz->timer = $request->input('timer');
            $quiz->subject = $request->input('subject');
            $quiz->status = $request->has('status') ? 1 : 0;
            $quiz->reattempt = $request->has('reattempt') ? 1 : 0;
            $quiz->type = $request->has('type') ? 1 : 0;
            $quiz->service = $request->has('service') ? 1 : 0;
            $quiz->question_order = $request->has('question_order') ? 1 : 0;
            $quiz->fees = $request->fees;
            $quiz->category_id = $request->category_id;

            if ($quiz->isDirty('name')) {
                $quiz->slug = null;
            }

            $quiz->save();

            return redirect()->route('quiz.index')->with('success','Quiz updated successfully');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating the quiz: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Update Code End-------------------------------

    //---------------------------------- Data Delete Code start-------------------------------
    public function delete($id){
        try {
            $quiz = Quiz::findOrFail($id);
            $quiz->delete();
            return redirect()->route('quiz.index')->with('delete','Quiz deleted successfully.');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the quiz: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- Data Delete Code End-------------------------------

    //---------------------------------- Data Selected Delete Code start-------------------------------
    public function bulk_delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('warning','Atleast one item is required to be checked');
        }
        else{
            Quiz::whereIn('id',$request->checked)->delete();
            Flash::success('status','Data Delete Successfully');
            return redirect('admin/quiz');
        }
    }
    //---------------------------------- Data Selected Delete Code end-------------------------------

    //-------------------------------data import code start--------------------------
    public function import()
    {
        return view('admin.quiz.import');
    }
    //-------------------------------data import code end--------------------------

    //------------------------------- importFileSave code start-----------------------
    public function importSave(Request $request)
    {
        try{
            $request->validate([
                'file' => 'required',
            ]);

            Excel::import(new QuizImport, $request->file('file'));

            return redirect()->back()->with('status','imported success');
        }
        catch  (\Exception $e){
            return back()->with('error', 'Error importing data: ' . $e->getMessage());
        }
    }
    //------------------------------- importFileSave code end-----------------------

    //---------------------------------- trash Code start-------------------------------
    public function trash()
    {
        $quiz = Quiz::onlyTrashed()->get();
        return view('admin.quiz.trash', compact('quiz'));
    }
    //---------------------------------- trash Code end-------------------------------

    //---------------------------------- trash restore Code start-------------------------------
    public function restore(string $id)
    {
        try {
        $quiz = Quiz::withTrashed()->find($id);
        if(!is_null($quiz)){
            $quiz->restore();
        }
        return redirect('admin/quiz/trash')->with('success','Trash Data restore Successfully');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while restoring the quiz: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //---------------------------------- trash restore Code end-------------------------------

    //---------------------------------- Trash data Delete Code start-------------------------------
    public function trashDelete(string $id)
    {
        try {
        $quiz = Quiz::withTrashed()->find($id);
        if (!is_null($quiz)) {
            if ($quiz->image != null) {
                $content = @file_get_contents(public_path() . '/images/quiz/' . $quiz->image);
                if ($content) {
                    unlink(public_path() . "/images/quiz/" . $quiz->image);
                }
            }
            $quiz->forceDelete();
            return redirect('admin/quiz/trash')->with('delete', 'Data Delete Successfully');
        }
        return redirect('admin/quiz/trash')->with('delete','Trash Data Delete Successfully');
        }
        catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the quiz: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //----------------------------------Trash data Delete Code start-------------------------------

    //---------------------------------- Data Selected Delete Code start-------------------------------
    public function trash_bulk_delete(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->with('warning', 'Atleast one item is required to be checked');
            }
            else{
                Quiz::whereIn('id',$request->checked)->forceDelete();
                return redirect('admin/quiz/trash')->with('delete','Data Delete Successfully');
            }
        }
            catch (\Exception $e) {
                $errorMessage = 'An error occurred while deleting the quiz: ' . $e->getMessage();
                return back()->with('error', $errorMessage)->withInput();
            }
    }
    //---------------------------------- Data Selected Delete Code end-------------------------------
    
    //---------------------------------- Discover page Code start-------------------------------
    public function discover_page(Request $request)
    {
        $priceFilter = $request->input('price_filter', 'all');
        $typeFilter = $request->input('type_filter', 'all');
        $searchQuery = $request->input('search', '');
        $current_date = Carbon::now()->toDateString();

        $query =  Quiz::where('status','1')->where('approve_result','0');

        if ($priceFilter === 'paid') {
            $query->where('service', 1);
        } elseif ($priceFilter === 'free') {
            $query->where('service', 0);
        }

        if ($typeFilter === 'objective') {
            $query->where('type', 1);
        } elseif ($typeFilter === 'subjective') {
            $query->where('type', 0);
        }

        if (!empty($searchQuery)) {
            $query->where('name', 'LIKE', "%{$searchQuery}%");
        }

        $paginate = $query->paginate(4);

        $setting = GeneralSetting::first();
        $allCategories = Category::all();
        $bookmarkedQuizIds = auth()->check()
        ? auth()->user()->bookmarks()->pluck('quiz_id')->toArray()
        : [];
        return view('front.discover', compact('current_date', 'setting', 'allCategories', 'paginate', 'priceFilter', 'typeFilter', 'searchQuery','bookmarkedQuizIds'));
    }
    //---------------------------------- Discover page Code end-------------------------------
    
    //---------------------------------- Quiz Subjective play page Code start-------------------------------
    public function play_quiz(string $slug) {
        $quiz = Quiz::where('slug', $slug)->firstOrFail();
        $user = Auth::user();
        $setting = GeneralSetting::first();
        $sub = Subjective::where('quiz_id', $quiz->id)->get();
        if($quiz->service == 1){
            if($user->role != 'A'){
                if ($quiz->fees == 0 || $quiz->fees > $user->coins){
                    return redirect('/profile#plans')->with('success','insufficient coins get more coins or but coins.');
                }else{
                    $coins = new CoinsController;
                    $coins->coins_transaction($user->id,'By playing quiz: '.$quiz->name,'debited',$quiz->fees);
                }
            }
        }
        return view('front.play', compact('quiz', 'setting', 'sub'));
    }
    //---------------------------------- Quiz Subjective play page Code end-------------------------------
    
    //---------------------------------- Quiz Objective play page Code start-------------------------------
    public function play_objective(string $slug) {
        $quiz = Quiz::where('slug', $slug)->firstOrFail();
        $setting = GeneralSetting::first();
        $user = Auth::user();
        $obj = Objective::where('quiz_id', $quiz->id)->get();
        if($quiz->service == 1){
            if($quiz->service == 1){
                if ($quiz->fees == 0 || $quiz->fees > $user->coins){
                    return redirect()->back()->with('success','insufficient coins.');
                }else{
                    $coins = new CoinsController;
                    $coins->coins_transaction($user->id,'By playing quiz: '.$quiz->name,'debited',$quiz->fees);
                }
            }
        }
        return view('front.objective_play',compact('quiz', 'setting', 'obj'));
    }
    //---------------------------------- Quiz Objective play page Code end-------------------------------
    
    //---------------------------------- Subjective answer store Code start-------------------------------
    public function store_answers(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);
        $user = Auth::user();

        $existingAnswers = SubjectiveAnswer::where('user_id', $user->id)
                                        ->where('quiz_id', $quiz->id)
                                        ->exists();

        if ($existingAnswers) {
            SubjectiveAnswer::where('user_id', $user->id)
                            ->where('quiz_id', $quiz->id)
                            ->delete();
        }
        foreach ($request->question_id as $key => $question_id) {
            $answer = new SubjectiveAnswer();
            $answer->user_id = $user->id;
            $answer->quiz_id = $quiz->id;
            $answer->question_id = $question_id;
            $answer->answer = $request->answer[$key];
            $answer->save();
        }

        return redirect('/report/'.$quiz->slug.'/'.$user->slug)->with('success', 'Quiz submitted successfully!');
    }
    //---------------------------------- Subjective answer store Code end -------------------------------

    //---------------------------------- Objective answer store Code start -------------------------------
    public function store_objective_answer(Request $request, $id) {
        $quiz = Quiz::findOrFail($id);
        $user = Auth::user();

        ObjectiveAnswer::where('user_id', $user->id)
                       ->where('quiz_id', $quiz->id)
                       ->delete();

        $questionIds = $request->input('question_id', []);
        $userAnswers = $request->input('user_answer', []);
        $correctAnswers = $request->input('correct_answer', []);
        $questionTypes = $request->input('question_type', []);

        foreach ($questionIds as $key => $questionId) {
            $answer = new ObjectiveAnswer();
            $answer->user_id = $user->id;
            $answer->quiz_id = $quiz->id;
            $answer->question_id = $questionId;
            $answer->user_answer = $userAnswers[$questionId] ?? null;
            $answer->correct_answer = $correctAnswers[$key] ?? null;
            $answer->question_type = $questionTypes[$key] ?? null;
            $answer->answer_approved = ($answer->user_answer === $answer->correct_answer) ? 1 : 0;
            $answer->save();
        }
        return redirect('/report/'.$quiz->slug.'/'.$user->slug)->with('success', 'Quiz submitted successfully!');
    }
    //---------------------------------- Objective answer store Code end-------------------------------

    //---------------------------------- Try again Code start-------------------------------
    public function try_again($quiz_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);
        $user = Auth::user();

        if ($quiz->type == 0) {
            // Delete the user's subjective answers
            SubjectiveAnswer::where('user_id', $user->id)
                            ->where('quiz_id', $quiz_id)
                            ->delete();

            // Redirect to play.quiz route
            return redirect()->route('play.quiz', ['id' => $quiz_id,'slug' => $quiz->slug]);
        } else {
            // Delete the user's objective answers
            ObjectiveAnswer::where('user_id', $user->id)
                        ->where('quiz_id', $quiz_id)
                        ->delete();

            // Redirect using the slug of the quiz
            return redirect()->route('play.objective', ['id' => $quiz_id, 'slug' => $quiz->slug]);
        }
    }
    //---------------------------------- Try again Code start-------------------------------

    //---------------------------------- Report Quiz code start -------------------------------
    public function quiz_report(string $quiz_slug, $user_id) {
        $user = Auth::user();
        $quiz = Quiz::where('slug',$quiz_slug)->firstOrFail();
        $setting = GeneralSetting::first();

        $subAns = SubjectiveAnswer::where('user_id', $user->id)
                           ->where('quiz_id', $quiz->id)
                           ->get();
        $objAns = ObjectiveAnswer::where('user_id', $user->id)
        ->where('quiz_id', $quiz->id)
        ->get();
        return view('front.report',compact('user','setting','subAns','objAns','quiz'));
    }
    //---------------------------------- Report Quiz code end -------------------------------

    //---------------------------------- Quiz Approval code start -------------------------------
    public function approveResult(Request $request, $id)
    {
        $result = Quiz::findOrFail($id);

        $result->approve_result = $request->has('approve_result');
        $result->save();

        if ($result->approve_result) {
            $this->sendNotifications($result);
        }

        $result->approve();

        return redirect()->back()->with('success', 'Quiz result approved successfully');
    }

    private function sendNotifications(Quiz $quiz)
    {
        $quiz->sendResultApprovedNotifications();
    }
    //---------------------------------- Quiz Approval code end -------------------------------

    //---------------------------------- User report code start -------------------------------
    public function my_report($user_slug) {
        $user = User::where('slug', $user_slug)->firstOrFail();
        $setting = GeneralSetting::first();
        $objective_quiz_ids = ObjectiveAnswer::where('user_id', $user->id)
            ->pluck('quiz_id')
            ->unique();

        $subjective_quiz_ids = SubjectiveAnswer::where('user_id', $user->id)
            ->pluck('quiz_id')
            ->unique();

        $all_quiz_ids = $objective_quiz_ids->merge($subjective_quiz_ids)->unique();

        $quizzes = Quiz::whereIn('id', $all_quiz_ids)->get();

        $checkouts = checkout::where('user_id', $user->id)->paginate(4);
        return view('front.checkreports', compact('user', 'setting', 'quizzes','checkouts'));
    }
    //---------------------------------- User report code end -------------------------------

    //---------------------------------- Admin quiz report code start -------------------------------
    public function quizReport()
    {
        // Fetch all quizzes with pagination
        $quizzes = Quiz::where('status',1)->paginate(10, ['*'], 'all_quizzes');

        $quizReports = $quizzes->map(function ($quiz) {
            $subjectiveParticipants = SubjectiveAnswer::where('quiz_id', $quiz->id)->distinct('user_id')->count('user_id');
            $objectiveParticipants = ObjectiveAnswer::where('quiz_id', $quiz->id)->distinct('user_id')->count('user_id');
            $totalParticipants = $subjectiveParticipants + $objectiveParticipants;

            return [
                'quiz' => $quiz,
                'totalParticipants' => $totalParticipants,
            ];
        });

        // Fetch objective quizzes with pagination
        $objectiveQuizzes = Quiz::where('type', 1)
            ->withCount(['objectiveAnswers as participants_count' => function ($query) {
                $query->select(\DB::raw('count(distinct user_id)'));
            }])
            ->paginate(5, ['*'], 'objective_quizzes');

        // Fetch subjective quizzes with pagination
        $subjectiveQuizzes = Quiz::where('type', 0)
            ->withCount(['subjectiveAnswers as participants_count' => function ($query) {
                $query->select(\DB::raw('count(distinct user_id)'));
            }])
            ->paginate(5, ['*'], 'subjective_quizzes');

        return view('admin.quiz.reports', compact('quizzes', 'quizReports', 'objectiveQuizzes', 'subjectiveQuizzes'));
    }
    //---------------------------------- Admin quiz report code end -------------------------------

    public function search(Request $request) {
        try {
            $query = $request->input('query');
            if (empty($query)) {
                return response()->json(['error' => 'Query cannot be empty'], 400);
            }

            $user = auth()->user(); // Get the authenticated user

            // Fetch quizzes based on query and status
            $quizzes = Quiz::where('name', 'like', "%$query%")
                ->where('status', 1)
                ->get()
                ->map(function ($quiz) use ($user) {

                    // Check if user has attempted the quiz
                    $hasAttemptedObj = \App\Models\ObjectiveAnswer::where('quiz_id', $quiz->id)
                        ->where('user_id', $user->id)
                        ->exists();
                    $hasAttemptedSub = \App\Models\SubjectiveAnswer::where('quiz_id', $quiz->id)
                        ->where('user_id', $user->id)
                        ->exists();

                    // Determine if the quiz should be displayed based on attempt and reattempt status
                    $canAttempt = false;

                    // If reattempt is available, allow it regardless of previous attempts
                    if ($quiz->reattempt == 1) {
                        $canAttempt = true;
                    } else {
                        // If not reattemptable, only allow the quiz if it hasn't been attempted yet
                        if (($quiz->type == 1 && !$hasAttemptedObj) || ($quiz->type != 1 && !$hasAttemptedSub)) {
                            $canAttempt = true;
                        }
                    }
                    return [
                        'id' => $quiz->id,
                        'slug' => $quiz->slug,
                        'name' => $quiz->name,
                        'type' => $quiz->type,
                        'status' => $quiz->status,
                        'canAttempt' => $canAttempt, // Add this field to indicate if the user can attempt
                        'approve_result' => $quiz->approve_result
                    ];
                });

            return response()->json($quizzes);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => 'An error occurred while searching'], 500);
        }
    }
}
