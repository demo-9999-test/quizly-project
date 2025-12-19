<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;
use App\Models\Quiz;
use Laracasts\Flash\Flash;
class BookmarkController extends Controller
{
    //------------------- bookmark toggle start --------------------------------
    public function toggle(Quiz $quiz)
    {
        $user = auth()->user();

        if ($user->bookmarks()->where('quiz_id', $quiz->id)->exists()) {
            $user->bookmarks()->detach($quiz->id);
            $bookmarked = false;
            $message = 'Quiz removed from bookmarks.';
        } else {
            $user->bookmarks()->attach($quiz->id);
            $bookmarked = true;
            $message = 'Quiz added to bookmarks.';
        }

        Flash::success($message);

        return response()->json([
            'bookmarked' => $bookmarked,
            'message' => $message
        ]);
    }
    //------------------- bookmark toggle end --------------------------------

}
