<?php

namespace App\Http\Controllers;

use App\Models\Battle;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Battlegame;
use Carbon\Carbon;
use App\Models\GeneralSetting;
use Illuminate\Support\Str;
use App\Models\Quiz;
use App\Models\Objective;
use App\Models\Battlequiz;
use App\Models\User;
use Intervention\Image\Facades\Image;
use ColorThief\ColorThief;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class BattleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:battle.view', ['only' => ['index', 'show']]);
        $this->middleware('permission:battle.create', ['only' => ['create', 'importSave', 'store']]);
        $this->middleware('permission:battle.edit', ['only' => ['edit', ' update', 'updateStatus', 'updateOrder']]);
        $this->middleware('permission:battle.delete', ['only' => ['delete', 'bulk_delete', 'trash_bulk_delete', 'trash', 'restore', 'trashDelete']]);
    }

    //---------------------------------- Page View Code Start-------------------------------
    public function index()
    {
        $battle = Battle::first();
        return view('admin.battle.index', compact('battle'));
    }
    //---------------------------------- Page View Code End-------------------------------

    //--------------------------------- Create Update code start --------------------------
    public function createOrUpdate(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'room_time' => 'required|integer',
                'desc' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $battle = Battle::first();

            if (!$battle) {
                $battle = new Battle();
            }

            $battle->name = $request->name;
            $battle->room_time = $request->room_time;
            $battle->description = $request->desc;
            $battle->status = $request->has('status') ? 1 : 0;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('battle_images', 'public');
                $battle->image = $imagePath;
            }

            $battle->save();

            return redirect()->back()->with('success', 'Battle information updated successfully.');
        } catch (\Exception $e) {
            $errorMessage = 'An error occurred while updating the battle: ' . $e->getMessage();
            return back()->with('error', $errorMessage)->withInput();
        }
    }
    //--------------------------------- Create Update code end --------------------------------


    //---------------------------------- Battle setup code start ---------------------------------------
    public function set_battle_page()
    {
        $setting = Generalsetting::first();
        $mode = Battle::first();
        $quiz = Quiz::where('type', '1')->get();
        return view('front.battle.set_up', compact('setting', 'mode', 'quiz'));
    }
    //---------------------------------- Battle setup code end ---------------------------------------


    //---------------------------------- Invite link for user start ---------------------------------------
    public function invite(Request $request)
    {
        $request->validate([
            'room_name' => 'required|string|max:255',
            'bid_amount' => 'required|numeric|min:1|max:99999',
            'code' => 'required|string|min:6',
            'quiz_id' => 'required|exists:quizes,id',
            'battle_id' => 'required|exists:battles,id'
        ]);
        $user = Auth::user();

        if ($user->role != 'A') {
            if ($user->coins < $request->bid_amount) {
                return redirect()->back()->with('success', 'Insufficient coins you cannot create room');
            }
        }
        $expiresAt = now()->addMinutes(10);

        $battle = Battlegame::create([
            'creator_id' => auth()->id(),
            'room_name' => $request->room_name,
            'bid_amount' => $request->bid_amount,
            'battle_id' => $request->battle_id,
            'quiz_id' => $request->quiz_id,
            'code' => $request->code,
            'expires_at' => $expiresAt,
        ]);

        return redirect()->route('battle.room', $battle->id)->with('success', 'Room created successfully');
    }
    //---------------------------------- Invite link for user end ---------------------------------------

    //---------------------------------- Join link for user start ---------------------------------------

    public function join(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $battle = Battlegame::where('code', $request->code)
            ->where('expires_at', '>', Carbon::now())
            ->where('status', 'pending')
            ->first();

        if (!$battle) {
            \Log::info("Join failed: invalid or expired code", ['code' => $request->code]);
            return redirect()->back()->with('error', 'Invalid or expired code');
        }

        if ($battle->opponent_id !== null) {
            return redirect()->back()->with('error', 'This room is already joined by another player.');
        }

        if ($battle->creator_id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot join your own room');
        }

        $user = Auth::user();

        if ($user->role != 'A' && $user->coins < $battle->bid_amount) {
            return redirect()->back()->with('error', 'Insufficient coins to join the room');
        }

        $battle->update([
            'opponent_id' => auth()->id(),
            'status' => 'active',
        ]);

        return redirect()->route('battle.room', $battle->id)->with('success', 'Room joined successfully');
    }

    //---------------------------------- Join link for user end ---------------------------------------

    //---------------------------------- check opponent code start ---------------------------------------
    public function checkOpponent($id)
    {
        $battle = Battlegame::find($id);
        return response()->json([
            'hasOpponent' => !is_null($battle->opponent_id)
        ]);
    }
    //---------------------------------- check opponent code end ---------------------------------------

    //---------------------------------- battle room code start ---------------------------------------
    public function showRoom($id)
    {
        $battle = Battlegame::findOrFail($id);
        $quiz = Quiz::where('id', $battle->quiz_id)->first();
        $battle_type = Battle::where('id', $battle->battle_id)->first();
        $creator = User::findOrFail($battle->creator_id);
        $creatorBannerColor = $this->getColorFromImage(public_path('images/users/' . $creator->image));

        if ($battle->creator_id !== auth()->id() && $battle->opponent_id !== auth()->id()) {
            return redirect()->route('home')->with('error', 'You are not part of this battle');
        }

        $opponent = null;
        $opponentBannerColor = null;
        if ($battle->opponent_id) {
            $opponent = User::findOrFail($battle->opponent_id);
            $opponentBannerColor = $this->getColorFromImage(public_path('images/users/' . $opponent->image));
        }

        return view('front.battle.room', compact('battle', 'quiz', 'battle_type', 'creator', 'creatorBannerColor', 'opponent', 'opponentBannerColor'));
    }
    //---------------------------------- battle room code end ---------------------------------------

    //--------------------------------- get color from image code start ------------------------------
    private function getColorFromImage(string $imagePath): string
    {
        if (!file_exists($imagePath)) {
            \Log::warning("Image file does not exist: $imagePath");
            return 'rgba(105, 73, 255, 0.05);';
        }

        if (!is_readable($imagePath)) {
            \Log::warning("Image file is not readable: $imagePath");
            return 'rgba(105, 73, 255, 0.05);';
        }

        try {
            $image = Image::make($imagePath);
        } catch (\Exception $e) {
            \Log::error("Failed to create image: " . $e->getMessage());
            return 'rgba(105, 73, 255, 0.05);';
        }

        try {
            $colorThief = new ColorThief();
            $dominantColor = $colorThief->getColor($image->getCore());
            return sprintf("#%02x%02x%02x", $dominantColor[0], $dominantColor[1], $dominantColor[2]);
        } catch (\Exception $e) {
            \Log::error("Failed to get color: " . $e->getMessage());
            return 'rgba(105, 73, 255, 0.05);';
        }
    }
    //--------------------------------- get color from image code end ------------------------------

    //---------------------------------- start-battle code start ---------------------------------------
    public function startBattle($battle_id, $quiz_id)
    {
        $battle = Battlegame::where('id', $battle_id)->first();
        $quiz = Quiz::where('id', $quiz_id)->firstOrFail();
        $user = Auth::user();
        $setting = GeneralSetting::first();
        $obj = Objective::where('quiz_id', $quiz->id)->get();

        $coins = new CoinsController;
        $coins->coins_transaction($user->id, 'By doing battle', 'debited', $battle->bid_amount);

        return view('front.battle.quiz', compact('battle', 'quiz', 'obj', 'setting'));
    }
    //---------------------------------- start-battle code end---------------------------------------

    //---------------------------------- store-battle code start ---------------------------------------
    public function store_battle(Request $request, $id, $question_id, $battle_id)
    {
        $quiz = Quiz::findOrFail($id);
        $user = Auth::user();
        $battle = Battlegame::findorFail($battle_id);

        Battlequiz::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->delete();

        $questionIds = $request->input('question_id', []);
        $userAnswers = $request->input('user_answer', []);
        $correctAnswers = $request->input('correct_answer', []);
        $questionTypes = $request->input('question_type', []);

        foreach ($questionIds as $key => $questionId) {
            $answer = new Battlequiz();
            $answer->user_id = $user->id;
            $answer->quiz_id = $quiz->id;
            $answer->battle_id = $battle->id;
            $answer->question_id = $questionId;
            $answer->user_answer = $userAnswers[$questionId] ?? null;
            $answer->correct_answer = $correctAnswers[$key] ?? null;
            $answer->question_type = $questionTypes[$key] ?? null;
            $answer->answer_approved = ($answer->user_answer === $answer->correct_answer) ? 1 : 0;
            $answer->save();
        }

        if ($user->id === $battle->creator_id) {
            $battle->creator_completed = 1;
        } else {
            $battle->opponent_completed = 1;
        }
        $battle->save();

        return redirect('battle/result/' . $quiz->slug . '/' . $user->slug . '/' . $battle->id)->with('success', 'Quiz submitted successfully!');
    }
    //---------------------------------- store-battle code end ---------------------------------------

    //---------------------------------- battle result page code start ---------------------------------------
    public function result($quiz_slug, $user_slug, $battle_id)
    {
        $setting = GeneralSetting::first();
        $battle = Battlegame::findOrFail($battle_id);
        $quiz = Quiz::where('slug', $quiz_slug)->firstOrFail();
        $current_user = auth()->user();
        $opponent = ($current_user->id === $battle->creator_id) ? $battle->opponent : $battle->creator;

        if ($current_user->id !== $battle->creator_id && $current_user->id !== $battle->opponent_id) {
            return redirect()->route('home')->with('error', 'You are not part of this battle');
        }

        if ($battle->creator_completed == 0 || $battle->opponent_completed == 0) {
            return view('front.battle.waiting', compact('battle', 'current_user', 'opponent', 'quiz_slug', 'user_slug'));
        }

        $battle_game = Battlequiz::where('battle_id', $battle->id)->get();
        $questions = [];

        foreach ($battle_game as $battleGame) {
            $question = Objective::where('id', $battleGame->question_id)
                ->where('quiz_id', $quiz->id)
                ->first();
            if ($question) {
                $questions[] = $question;
            }
        }
        $scores = $this->calculateScores($battle_id, $quiz->id, $current_user->id, $opponent->id);
        $winner = null;
        if ($scores[$current_user->id] > $scores[$opponent->id]) {
            $winner = $current_user;
        } elseif ($scores[$opponent->id] > $scores[$current_user->id]) {
            $winner = $opponent;
        }

        if ($winner) {
            $coins = new CoinsController;
            $coins->coins_transaction($winner->id, 'By playing battle', 'credited', $battle->bid_amount * 2);
        }

        return view('front.battle.result', compact('setting', 'battle', 'battle_game', 'questions', 'current_user', 'opponent', 'scores', 'winner'));
    }
    //---------------------------------- battle result page code end ---------------------------------------

    //---------------------------------- battle score calculate code start ---------------------------------------
    private function calculateScores($battle_id, $quiz_id, $user1_id, $user2_id)
    {
        $scores = [$user1_id => 0, $user2_id => 0];

        $battleQuizzes = Battlequiz::where('battle_id', $battle_id)->get();

        foreach ($battleQuizzes as $battleQuiz) {
            $question = Objective::where('id', $battleQuiz->question_id)
                ->where('quiz_id', $quiz_id)
                ->first();

            if ($question && $battleQuiz->answer_approved == 1) {
                if ($battleQuiz->user_id == $user1_id) {
                    $scores[$user1_id] += $question->mark;
                } elseif ($battleQuiz->user_id == $user2_id) {
                    $scores[$user2_id] += $question->mark;
                }
            }
        }

        return $scores;
    }
    //---------------------------------- battle score calculate code end ---------------------------------------

    //---------------------------------- battle waiting code start ---------------------------------------
    public function checkBattleStatus($battle_id, $quiz_slug, $user_slug)
    {
        if (request()->ajax()) {
            $battle = Battlegame::findOrFail($battle_id);
            if ($battle->creator_completed && $battle->opponent_completed) {
                return 'redirect';
            }
            return 'waiting';
        }
        return redirect()->route('battle.result', ['quiz_slug' => $quiz_slug, 'user_slug' => $user_slug, 'battle_id' => $battle_id]);
    }
    //---------------------------------- battle waiting code start ---------------------------------------
}
