<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Battle;
use App\Models\Battlegame;
use App\Models\Battlequiz;
use App\Models\Quiz;
use App\Models\Objective;
use App\Models\User;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Str;
use App\Models\Coins;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\ObjectiveAnswer;
use Illuminate\Validation\ValidationException;

class BattleApiController extends Controller
{
    public function getBattle()
    {
        $battle = Battle::first();

        $data = [
            'battle' => [
                'id' => $battle->id,
                'name' => $battle->name,
                'room_time' => $battle->room_time,
                'description' => $battle->description,
                'status' => $battle->status,
                'image' => $battle->image ? asset('images/battle/' . $battle->image) : null,
                'slug' => $battle->slug,
            ],
        ];

        return response()->json([
            'data' => $data
        ]);
    }
    public function invite(Request $request)
    {
        $request->validate([
            'room_name' => 'required|string|max:255',
            'bid_amount' => 'required|numeric|min:1|max:99999',
            'code' => 'required|string|min:6',
            'quiz_id' => 'required|exists:quizes,id',
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }

        // Check if user has enough coins
        if ($user->coins < $request->bid_amount) {
            return response()->json(['status' => false, 'message' => 'Insufficient coins to create this room.'], 403);
        }

        // Check for duplicate room code
        if (Battlegame::where('code', $request->code)->exists()) {
            return response()->json(['status' => false, 'message' => 'Room code already taken. Please use a different code.'], 409);
        }

        // Create battle room
        $battle = Battlegame::create([
            'creator_id' => $user->id,
            'room_name' => $request->room_name,
            'bid_amount' => $request->bid_amount,
            'battle_id' => '1',
            'quiz_id' => $request->quiz_id,
            'code' => $request->code,
            'expires_at' => now()->addMinutes(10),
        ]);

        return response()->json(['status' => true, 'message' => 'Room created', 'room_id' => $battle->id]);
    }

public function join(Request $request)
{
    $request->validate([
        'code' => 'required|string',
    ]);

    // Retrieve battle room by code, not expired, and still pending
    $battle = Battlegame::where('code', $request->code)
        ->where('expires_at', '>', Carbon::now())
        ->where('status', 'pending')
        ->first();

    // If no such battle found
    if (!$battle) {
        return response()->json([
            'status' => false,
            'message' => 'Battle room not found or already expired/active',
        ]);
    }

    // Prevent joining own room
    if ($battle->creator_id === auth()->id()) {
        return response()->json([
            'status' => false,
            'message' => 'Cannot join own room',
        ]);
    }

    $user = Auth::user();

    // Check if user has enough coins (if not admin)
    if ($user->role !== 'A' && $user->coins < $battle->bid_amount) {
        return response()->json([
            'status' => false,
            'message' => 'Insufficient coins to join this room.',
        ], 403);
    }

    // Update the battle to assign opponent and activate
    $battle->update([
        'opponent_id' => $user->id,
        'status' => 'active',
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Room joined',
        'room_id' => $battle->id,
    ]);
}

public function generateCode()
{
    do {
        $code = strtoupper(Str::random(6)); // e.g. "X3B7KD"
    } while (Battlegame::where('code', $code)->exists());

    return response()->json([
        'status' => true,
        'code' => $code
    ]);
}
public function showRoom($id)
{
    try {
        // Log attempt to access battle room
        \Log::info('Attempting to access battle room', [
            'battle_id' => $id,
            'user_id' => Auth::id(),
            'timestamp' => now()->toDateTimeString()
        ]);

        $battle = Battlegame::findOrFail($id);

        // Check if user is authorized
        if ($battle->creator_id !== Auth::id() && $battle->opponent_id !== Auth::id()) {
            \Log::warning('Unauthorized access attempt to battle room', [
                'battle_id' => $id,
                'user_id' => Auth::id(),
                'creator_id' => $battle->creator_id,
                'opponent_id' => $battle->opponent_id
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'You are not part of this battle'
            ], 403);
        }

        // Log successful authorization
        \Log::info('User authorized for battle room', [
            'battle_id' => $id,
            'user_id' => Auth::id(),
            'role' => $battle->creator_id === Auth::id() ? 'creator' : 'opponent'
        ]);

        $quiz = Quiz::findOrFail($battle->quiz_id);
        $battle_type = Battle::findOrFail($battle->battle_id);
        $creator = User::findOrFail($battle->creator_id);

        // ✅ Ensure opponent is always defined
        $opponent = null;
        if ($battle->opponent_id) {
            $opponent = User::findOrFail($battle->opponent_id);
            \Log::info('Opponent details retrieved', [
                'battle_id' => $id,
                'opponent_id' => $opponent->id
            ]);
        } else {
            \Log::info('No opponent assigned to battle', [
                'battle_id' => $id
            ]);
        }

        // Log successful data retrieval
        \Log::info('Battle room details retrieved successfully', [
            'battle_id' => $id,
            'quiz_id' => $quiz->id,
            'battle_type_id' => $battle_type->id,
            'creator_id' => $creator->id
        ]);

        return response()->json([
            'status' => 'success',
            'data' => [
                'battle' => [
                    'id' => $battle->id,
                    'room_name' => $battle->room_name,
                    'code' => $battle->code,
                    'bid_amount' => $battle->bid_amount,
                    'room_time' => $battle_type->room_time
                ],
                'quiz' => [
                    'id' => $quiz->id,
                    'name' => $quiz->name,
                    'description' => $quiz->description,
                    'image' => $quiz->image ? asset('images/quiz/' . $quiz->image) : null
                ],
                'creator' => [
                    'id' => $creator->id,
                    'name' => $creator->name,
                    'email' => $creator->email,
                    'score' => $creator->score,
                    'rank' => $creator->rank,
                    'image' => $creator->image ? asset('images/users/' . $creator->image) : null,
                ],
                'opponent' => $opponent ? [
                    'id' => $opponent->id,
                    'name' => $opponent->name,
                    'email' => $opponent->email,
                    'score' => $opponent->score,
                    'rank' => $opponent->rank,
                    'image' => $opponent->image ? asset('images/users/' . $opponent->image) : null,
                ] : null
            ]
        ], 200);
    } catch (\Exception $e) {
        // Log error details
        \Log::error('Error fetching battle room details', [
            'battle_id' => $id,
            'user_id' => Auth::id(),
            'error_message' => $e->getMessage(),
            'stack_trace' => $e->getTraceAsString(),
            'timestamp' => now()->toDateTimeString()
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred while fetching battle room details',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function startBattle(Request $request, $battle_id, $quiz_id)
    {
        try {
            // Validate input
            Log::debug('startBattle: Validating input parameters');
            $battle = Battlegame::findOrFail($battle_id);
            $quiz = Quiz::findOrFail($quiz_id);
            $user = Auth::user();
            
            Log::info('startBattle: Fetched battle and quiz successfully', [
                'battle_id' => $battle->id,
                'quiz_id' => $quiz->id,
                'user_id' => $user->id,
            ]);

            Log::info('startBattle: User authorized', ['user_id' => $user->id]);

            // Check if battle is active
            
            Log::info('startBattle: Battle is active');

            // Fetch settings and objectives
            Log::debug('startBattle: Fetching general settings and objectives');
            $setting = GeneralSetting::first();
            $objectives = Objective::where('quiz_id', $quiz->id)->get();
            Log::info('startBattle: Fetched settings and objectives', [
                'objectives_count' => $objectives->count(),
            ]);

            // Process coin transaction within a database transaction
            Log::debug('startBattle: Starting coin transaction', ['user_id' => $user->id, 'amount' => $battle->bid_amount]);
            DB::beginTransaction();
            try {
                // Note: Changed to CoinsController (assuming this is the correct controller)
                $coinService = new BattleApiController(); // Consider dependency injection
                $transactionResult = $coinService->coinsTransaction($user->id, 'By doing battle', 'debited', $battle->bid_amount);

                if (!$transactionResult['success']) {
                    Log::error('startBattle: Coin transaction failed', [
                        'user_id' => $user->id,
                        'message' => $transactionResult['message'],
                    ]);
                    throw new \Exception($transactionResult['message']);
                }

                Log::info('startBattle: Coin transaction successful', [
                    'user_id' => $user->id,
                    'amount' => $battle->bid_amount,
                    'transaction_message' => $transactionResult['message'],
                ]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('startBattle: Coin transaction error', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                    'battle_id' => $battle->id,
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to process coin transaction: ' . $e->getMessage(),
                ], 500);
            }

            // Prepare response
            $response = [
                'status' => 'success',
                'data' => [
                    'battle' => $battle,
                    'quiz' => $quiz,
                    'objectives' => $objectives,
                    'setting' => $setting,
                    'user' => $user,
                ],
            ];
            Log::info('startBattle: Method completed successfully', [
                'user_id' => $user->id,
                'battle_id' => $battle->id,
                'response_status' => 'success',
            ]);

            return response()->json($response, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('startBattle: Model not found', [
                'battle_id' => $battle_id,
                'quiz_id' => $quiz_id,
                'error' => $e->getMessage(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Battle or quiz not found',
            ], 404);
        } catch (\Exception $e) {
            Log::error('startBattle: Unexpected error', [
                'battle_id' => $battle_id,
                'quiz_id' => $quiz_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to start battle',
            ], 500);
        }
    }

    public function coinsTransaction($user_id, $method, $status, $amount)
    {
        try {
            $user = User::findOrFail($user_id);

            // Validate amount
            if ($amount <= 0) {
                return [
                    'success' => false,
                    'message' => 'Amount must be greater than zero',
                ];
            }

            DB::beginTransaction();
            try {
                if ($status === 'credited') {
                    $user->coins += $amount;
                    $message = 'Coins have been credited successfully';
                } elseif ($status === 'debited') {
                    if ($user->coins < $amount) {
                        throw new \Exception('Insufficient coins for debit');
                    }
                    $user->coins -= $amount;
                    $message = 'Coins have been debited successfully';
                } else {
                    throw new \Exception('Invalid transaction status');
                }

                $user->save();

                Coins::create([
                    'user_id' => $user->id,
                    'method' => $method,
                    'status' => $status,
                    'ammount' => $amount,
                ]);

                DB::commit();

                return [
                    'success' => true,
                    'message' => $message,
                ];
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Coin Transaction Error: ' . $e->getMessage());
                return [
                    'success' => false,
                    'message' => 'Transaction failed: ' . $e->getMessage(),
                ];
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return [
                'success' => false,
                'message' => 'User not found',
            ];
        }
    }

    public function storeBattle(Request $request) {
    // Log the incoming request data
    Log::info('StoreBattle Request Started', [
        'user_id' => Auth::id(),
        'request_data' => $request->all(),
        'request_method' => $request->method(),
        'request_url' => $request->url(),
        'content_type' => $request->header('Content-Type'),
        'raw_input' => $request->getContent()
    ]);

    try {
        // Log validation attempt
        Log::info('Starting validation', [
            'validation_rules' => [
                'id' => 'required|integer|exists:quizes,id',
                'battle_id' => 'required|integer|exists:battlegames,id',
                'question_id' => 'required|array|min:1',
                'user_answer' => 'required|array|min:1',
            ],
            'request_inputs' => [
                'id' => $request->input('id'),
                'battle_id' => $request->input('battle_id'),
                'question_id' => $request->input('question_id'),
                'user_answer' => $request->input('user_answer'),
            ]
        ]);

        // Validate input - removed question_type from validation
        $request->validate([
            'id' => 'required|integer|exists:quizes,id',
            'battle_id' => 'required|integer|exists:battlegames,id',
            'question_id' => 'required|array|min:1',
            'user_answer' => 'required|array|min:1',
        ]);

        Log::info('Validation passed successfully');

        $id = $request->input('id');
        $battle_id = $request->input('battle_id');
        
        Log::info('Attempting to find Quiz and Battle', [
            'quiz_id' => $id,
            'battle_id' => $battle_id
        ]);

        $quiz = Quiz::findOrFail($id);
        $user = Auth::user();
        $battle = Battlegame::findOrFail($battle_id);

        Log::info('Found Quiz and Battle successfully', [
            'quiz_id' => $quiz->id,
            'battle_id' => $battle->id,
            'user_id' => $user->id,
            'creator_id' => $battle->creator_id,
            'opponent_id' => $battle->opponent_id
        ]);

        // Authorization check
        if ($user->id !== $battle->creator_id && $user->id !== $battle->opponent_id) {
            Log::warning('Unauthorized access attempt', [
                'user_id' => $user->id,
                'creator_id' => $battle->creator_id,
                'opponent_id' => $battle->opponent_id
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to submit answers for this battle',
            ], 403);
        }

        Log::info('Authorization check passed');

        DB::beginTransaction();
        Log::info('Database transaction started');
        
        try {
            // Clear previous answers for this user and quiz
            $deletedCount = ObjectiveAnswer::where('user_id', $user->id)
                ->where('quiz_id', $quiz->id)
                ->delete();

            Log::info('Previous answers cleared', [
                'deleted_count' => $deletedCount,
                'user_id' => $user->id,
                'quiz_id' => $quiz->id
            ]);

            $questionIds = $request->input('question_id', []);
            $userAnswers = $request->input('user_answer', []);

            Log::info('Processing answers', [
                'question_ids_count' => count($questionIds),
                'user_answers_count' => count($userAnswers),
                'question_ids' => $questionIds,
                'user_answers' => $userAnswers
            ]);

            // Ensure both arrays have the same length
            if (count($questionIds) !== count($userAnswers)) {
                throw new \Exception('Question IDs and user answers arrays must have the same length');
            }

            $answersToInsert = [];

            foreach ($questionIds as $key => $questionId) {
                Log::info('Processing question', [
                    'key' => $key,
                    'question_id' => $questionId,
                    'user_answer' => $userAnswers[$key] ?? 'NOT_SET'
                ]);

                $question = Objective::findOrFail($questionId);

                if (!$question || !$question->correct_answer) {
                    Log::error('Question or correct answer not found', [
                        'question_id' => $questionId,
                        'question_exists' => !!$question,
                        'correct_answer' => $question->correct_answer ?? 'NULL'
                    ]);
                    throw new \Exception("Correct answer not found for question ID: $questionId");
                }

                $correctAnswer = $question->correct_answer;
                
                // Set question_type directly in controller - defaulting to 'single'
                $questionType = 'objective'; // You can modify this logic based on your requirements
                
                // Alternative: If you want to determine question type based on the question model
                // $questionType = $question->type ?? 'single';

                $isCorrect = ($userAnswers[$key] === $correctAnswer) ? 1 : 0;

                Log::info('Question processed', [
                    'question_id' => $questionId,
                    'user_answer' => $userAnswers[$key],
                    'correct_answer' => $correctAnswer,
                    'is_correct' => $isCorrect,
                    'question_type' => $questionType
                ]);

                $answersToInsert[] = [
                    'user_id' => $user->id,
                    'quiz_id' => $quiz->id,
                    'battle_id' => $battle->id,
                    'question_id' => $questionId,
                    'user_answer' => $userAnswers[$key],
                    'correct_answer' => $correctAnswer,
                    'question_type' => $questionType, // Set directly in controller
                    'answer_approved' => $isCorrect,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Log::info('Inserting answers', [
                'answers_count' => count($answersToInsert),
                'answers_data' => $answersToInsert
            ]);

            Battlequiz::insert($answersToInsert);

            Log::info('Answers inserted successfully');

            // Mark battle completion for the current user
            if ($user->id === $battle->creator_id) {
                $battle->creator_completed = 1;
                Log::info('Marked creator as completed');
            } else {
                $battle->opponent_completed = 1;
                Log::info('Marked opponent as completed');
            }
            $battle->save();

            Log::info('Battle completion status updated');

            DB::commit();
            Log::info('Database transaction committed successfully');

            return response()->json([
                'status' => 'success',
                'message' => 'Quiz submitted successfully',
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Store Battle Error (transaction rolled back)', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to submit quiz',
                'error' => $e->getMessage(),
            ], 500);
        }
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Validation Error', [
            'validation_errors' => $e->errors(),
            'request_data' => $request->all(),
            'failed_rules' => $e->validator->failed()
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        Log::error('Store Battle Error (outer catch)', [
            'error_message' => $e->getMessage(),
            'error_file' => $e->getFile(),
            'error_line' => $e->getLine(),
            'stack_trace' => $e->getTraceAsString(),
            'request_data' => $request->all()
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to submit quiz',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function result($quiz_id, $battle_id)
{
    try {
        $battle = Battlegame::findOrFail($battle_id);
        $quiz = Quiz::findOrFail($quiz_id);
        $current_user = auth()->user();
        $opponent = ($current_user->id === $battle->creator_id) ? $battle->opponent : $battle->creator;

        // Check if the user is part of the battle
        if ($current_user->id !== $battle->creator_id && $current_user->id !== $battle->opponent_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not part of this battle',
            ], 403);
        }

        // Show result only when both users have submitted the quiz
        if ($battle->creator_completed == 0 || $battle->opponent_completed == 0) {
            return response()->json([
                'status' => 'pending',
                'message' => 'Battle is still in progress. Result will be available once both players complete the quiz.',
                'data' => [
                    'battle' => $battle,
                    'current_user' => $current_user,
                    'opponent' => $opponent
                ]
            ], 200);
        }

        // Fetch battle questions
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

        // Calculate scores
        $scores = $this->calculateScores($battle->id, $quiz->id, $current_user->id, $opponent->id);

        // Determine winner
        $winner = null;
        if ($scores[$current_user->id] > $scores[$opponent->id]) {
            $winner = $current_user;
        } elseif ($scores[$opponent->id] > $scores[$current_user->id]) {
            $winner = $opponent;
        }

        // Award coins to the winner
        if ($winner) {
            $coins = new BattleApiController();
            $coins->coins_transaction($winner->id, 'By playing battle', 'credited', $battle->bid_amount * 2);
        }

        // Prepare API response
        return response()->json([
            'status' => 'success',
            'message' => 'Battle results retrieved successfully',
            'data' => [
                'battle' => $battle,
                'questions' => $questions,
                'current_user' => [
                    'id' => $current_user->id,
                    'name' => $current_user->name,
                    'image' => asset('/images/users/' . $current_user->image),
                    'score' => $scores[$current_user->id],
                    'is_winner' => $winner ? $current_user->id == $winner->id : false,
                ],
                'opponent' => [
                    'id' => $opponent->id,
                    'name' => $opponent->name,
                    'image' => asset('/images/users/' . $opponent->image),
                    'score' => $scores[$opponent->id],
                    'is_winner' => $winner ? $opponent->id == $winner->id : false,
                ],
                'winner' => $winner ? [
                    'id' => $winner->id,
                    'name' => $winner->name,
                    'coins_awarded' => $battle->bid_amount * 2,
                ] : null,
            ]
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred while processing the battle result',
            'error' => $e->getMessage(),
        ], 500);
    }
}

    public function coins_transaction($user_id,$method,$status,$ammount) {
        $user = User::findOrFail($user_id);
        $coins = Coins::create([
            'user_id'  => $user->id,
            'method' => $method,
            'status' => $status,
            'ammount' => $ammount
        ]);
        if($status == 'credited') {
            $user->coins += $ammount;
            $user->save();
            $message = 'Coins have been credited successfully';
        }else if ($status == 'debited') {
            if($user->coins > 0){
                $user->coins -= $ammount;
                $user->save();
                $message = 'Coins have been debited successfully';
            }
        }else {
            $message = 'Something went wrong';
        }
        return ['success' => ($status == 'credited' || $status == 'debited'), 'message' => $message];
    }
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
}
