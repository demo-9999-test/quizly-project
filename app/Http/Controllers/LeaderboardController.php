<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Leaderboard;
use App\Models\Quiz;
use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class LeaderboardController extends Controller
{
    //--------------------- store function code start ----------------------
    public function store($userId, $quizId, $type)
    {
        try {
            // Check if the quiz is approved
            $quiz = Quiz::find($quizId);
            if (!$quiz || $quiz->approve_result != 1) {
                throw new \Exception('Quiz not approved yet');
            }
            $totalScore = 0;
            $totalPossibleScore = 0;

            // Calculate score based on quiz type
            if ($type == 1) {
                // Objective quiz scoring
                $objectiveAnswers = DB::table('objective_answers')
                    ->join('objectives', 'objective_answers.question_id', '=', 'objectives.id')
                    ->where('objective_answers.user_id', $userId)
                    ->where('objective_answers.quiz_id', $quizId)
                    ->select(
                        DB::raw('SUM(CASE WHEN objective_answers.answer_approved = 1 THEN objectives.mark ELSE 0 END) as score'),
                        DB::raw('SUM(objectives.mark) as total_marks')
                    )
                    ->first();

                if ($objectiveAnswers) {
                    $totalScore += $objectiveAnswers->score;
                    $totalPossibleScore += $objectiveAnswers->total_marks;
                }
            } else {
                // Subjective quiz scoring
                $subjectiveAnswers = DB::table('subjective_answers')
                    ->join('subjectives', 'subjective_answers.question_id', '=', 'subjectives.id')
                    ->where('subjective_answers.user_id', $userId)
                    ->where('subjective_answers.quiz_id', $quizId)
                    ->select(
                        DB::raw('SUM(CASE WHEN subjective_answers.answer_approved = 1 THEN subjectives.mark ELSE 0 END) as score'),
                        DB::raw('SUM(subjectives.mark) as total_marks')
                    )
                    ->first();

                if ($subjectiveAnswers) {
                    $totalScore += $subjectiveAnswers->score;
                    $totalPossibleScore += $subjectiveAnswers->total_marks;
                }
            }
            $quizScore = $totalPossibleScore > 0 ? ($totalScore / $totalPossibleScore) * 100 : 0;

            // Update leaderboard
            Leaderboard::updateOrCreate(
                ['user_id' => $userId],
                [
                    'total_score' => DB::raw("COALESCE(total_score, 0) + $quizScore")
                ]
            );
            User::where('id', $userId)->update([
                'score' => DB::raw("COALESCE(score, 0) + $quizScore")
            ]);
            $badge = new BadgeController;
            $badge->checkAndAssignBadges($userId);
            $this->updateRanks();
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            \Log::error('Error updating leaderboard: ' . $e->getMessage());
        }
    }
    //--------------------- store function code end ----------------------

    //--------------------- leaderboard_page function code start ----------------------
    public function leaderboard_page()
    {
        $setting = GeneralSetting::first();
        $perPage = 6; // Number of items per page

        // All-time leaderboard
        $allTime = Leaderboard::orderBy('total_score', 'desc')->get();
        $allTime_rank1 = $allTime->shift();
        $allTime_rank2 = $allTime->shift();
        $allTime_rank3 = $allTime->shift();
        $allTime_rest = $this->paginateCollection($allTime, $perPage);

        // Monthly leaderboard
        $startOfMonth = now()->startOfMonth();
        $monthly = Leaderboard::where('updated_at', '>=', $startOfMonth)
                            ->orderBy('total_score', 'desc')
                            ->get();
        $monthly_rank1 = $monthly->shift();
        $monthly_rank2 = $monthly->shift();
        $monthly_rank3 = $monthly->shift();
        $monthly_rest = $this->paginateCollection($monthly, $perPage);

        // Today's leaderboard
        $startOfDay = now()->startOfDay();
        $today = Leaderboard::where('updated_at', '>=', $startOfDay)
                            ->orderBy('total_score', 'desc')
                            ->get();
        $today_rank1 = $today->shift();
        $today_rank2 = $today->shift();
        $today_rank3 = $today->shift();
        $today_rest = $this->paginateCollection($today, $perPage);

        $allEmpty = $allTime->isEmpty() && $monthly->isEmpty() && $today->isEmpty();

        return view('front.leadboard', compact(
            'allTime_rank1', 'allTime_rank2', 'allTime_rank3', 'allTime_rest',
            'monthly_rank1', 'monthly_rank2', 'monthly_rank3', 'monthly_rest',
            'today_rank1', 'today_rank2', 'today_rank3', 'today_rest',
            'setting', 'allEmpty'
        ));
    }
    //--------------------- leaderboard_page function code end ----------------------

    //--------------------- paginateCollection function code start ----------------------
    private function paginateCollection($items, $perPage)
    {
        $pageStart = request('page', 1);
        $offSet = ($pageStart * $perPage) - $perPage;
        $itemsForCurrentPage = $items->slice($offSet, $perPage);

        return new LengthAwarePaginator(
            $itemsForCurrentPage,
            $items->count(),
            $perPage,
            LengthAwarePaginator::resolveCurrentPage(),
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
    }
    //--------------------- paginateCollection function code end ----------------------

    //--------------------- leaderboard_admin function code start ----------------------
    public function leaderboard_admin() {
        $leaderboard = Leaderboard::orderBy('total_score', 'desc')->get();
        return view('admin.leadboard.index', compact('leaderboard'));
    }
    //--------------------- leaderboard_admin function code end ----------------------
}
