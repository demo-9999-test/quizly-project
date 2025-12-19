<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friendship;
use App\Models\GeneralSetting;
use App\Models\SocialMedia;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use ColorThief\ColorThief;
use App\Models\SubjectiveAnswer;
use App\Models\ObjectiveAnswer;
use App\Models\Quiz;

class FriendshipController extends Controller
{
    public function myFriends()
    {
        $authUserId = auth()->id();
        $friendIds = Friendship::where(function ($query) use ($authUserId) {
            $query->where('user_id', $authUserId)
                ->orWhere('friend_id', $authUserId);
        })
            ->where('status', 'accepted')
            ->get()
            ->map(function ($friendship) use ($authUserId) {
                return $friendship->user_id == $authUserId ? $friendship->friend_id : $friendship->user_id;
            });

        $friends = User::whereIn('id', $friendIds)->get();

        $friends->transform(function ($friend) {
            $imagePath = public_path('images/users/' . $friend->image);
            $friend->bannerColor = $this->getColorFromImage($imagePath);

            // Add full image URL
            $friend->image_url = $friend->image
                ? asset('images/users/' . $friend->image)
                : null;

            return $friend;
        });

        return response()->json(['friends' => $friends]);
    }
    public function myFriends1()
    {
        $authUserId = auth()->id();
        $friendIds = Friendship::where(function ($query) use ($authUserId) {
            $query->where('user_id', $authUserId)
                ->orWhere('friend_id', $authUserId);
        })
            ->where('status', 'accepted')
            ->get()
            ->map(function ($friendship) use ($authUserId) {
                return $friendship->user_id == $authUserId ? $friendship->friend_id : $friendship->user_id;
            });

        $friends = User::whereIn('id', $friendIds)->get();

        $friends->transform(function ($friend) {
            $imagePath = public_path('images/users/' . $friend->image);
            $friend->bannerColor = $this->getColorFromImage($imagePath);

            // Add full image URL
            $friend->image_url = $friend->image
                ? asset('images/users/' . $friend->image)
                : null;

            return $friend;
        });
        return response()->json(['friends' => $friends]);
    }

    public function findFriends(Request $request)
    {
        $authUser = auth()->user();

        $query = User::where('status', '1')
            ->where('id', '!=', $authUser->id)
            ->where('role', '!=', 'A')
            ->whereDoesntHave('friends', function ($q) use ($authUser) {
                $q->where('friend_id', $authUser->id);
            });

        switch ($request->input('sort')) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'date_newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'date_oldest':
                $query->orderBy('created_at', 'asc');
                break;
        }

        $users = $query->get();

        $users->transform(function ($user) {
            $imagePath = public_path('images/users/' . $user->image);
            $user->bannerColor = $this->getColorFromImage($imagePath);

            $user->image_url = $user->image
                ? asset('images/users/' . $user->image)
                : null;
            return $user;
        });

        return response()->json(['users' => $users]);
    }

        public function searchUsers(Request $request)
        {
            // 1️⃣  Get the logged‑in user (Laravel’s helper is the shortest)
            $authUser = $request->user();
            if (!$authUser) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }

            // 2️⃣  Sanitise the incoming search term
            $query = trim($request->input('query', ''));

            /* 3️⃣  Collect IDs of all *accepted* friends in ONE efficient query.
                    The CASE expression flips the columns so we always get “the other
                    person” as friend_id, regardless of who sent the request. */
            $friendIds = Friendship::query()
                ->where('status', 'accepted')
                ->where(function ($q) use ($authUser) {
                    $q->where('user_id', $authUser->id)
                    ->orWhere('friend_id', $authUser->id);
                })
                ->selectRaw(
                    'CASE WHEN user_id = ? THEN friend_id ELSE user_id END AS friend_id',
                    [$authUser->id]
                )
                ->pluck('friend_id');   // returns a Collection of integers

            /* 4️⃣  Pull the matching friends.
                    - If $query is empty we simply return every friend.
                    - If it isn’t, we add a name/email LIKE filter. */
            $friends = User::query()
                ->whereIn('id', $friendIds)
                ->when($query !== '', function ($q) use ($query) {
                    $q->where(function ($inner) use ($query) {
                        $inner->where('name',  'like', "%{$query}%")
                            ->orWhere('email', 'like', "%{$query}%");
                    });
                })
                ->get(['id', 'name', 'email']);   // limit columns if you wish

            return response()->json($friends);
        }

    private function getColorFromImage(string $imagePath): string
    {
        if (!file_exists($imagePath) || !is_readable($imagePath)) {
            return 'rgba(105, 73, 255, 0.05);';
        }

        try {
            $image = Image::make($imagePath);
            $colorThief = new ColorThief();
            $dominantColor = $colorThief->getColor($image->getCore());
            return sprintf("#%02x%02x%02x", ...$dominantColor);
        } catch (\Exception $e) {
            return 'rgba(105, 73, 255, 0.05);';
        }
    }

    public function acceptRequest(Friendship $friendship)
    {
        try {
            // Verify the friendship request belongs to the authenticated user
            if ($friendship->friend_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to accept this friend request.'
                ], 403);
            }

            // Verify the friendship is still pending
            if ($friendship->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'This friend request is no longer pending.'
                ], 400);
            }

            // Update the original friendship request
            $friendship->update(['status' => 'accepted']);

            // Create a reciprocal friendship entry
            Friendship::create([
                'user_id' => auth()->id(),
                'friend_id' => $friendship->user_id,
                'status' => 'accepted'
            ]);

            // Update the notification
            auth()->user()->notifications()
                ->where('type', 'App\Notifications\FriendRequestNotification')
                ->where('data->friendship_id', $friendship->id)
                ->update(['data->status' => 'accepted']);

            return response()->json([
                'success' => true,
                'message' => 'Friend request accepted successfully.',
                'data' => [
                    'friendship' => $friendship->fresh(),
                    'friend' => array_merge($friendship->user->toArray(), [
                        'image_url' => $friendship->user->image
                            ? asset('images/users/' . $friendship->user->image)
                            : null
                    ])
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while accepting the friend request.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function rejectRequest(Friendship $friendship)
    {
        try {
            // Verify the friendship request belongs to the authenticated user
            if ($friendship->friend_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to reject this friend request.'
                ], 403);
            }

            // Verify the friendship is still pending
            if ($friendship->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'This friend request is no longer pending.'
                ], 400);
            }

            $friendship->update(['status' => 'rejected']);

            auth()->user()->notifications()
                ->where('type', 'App\Notifications\FriendRequestNotification')
                ->where('data->friendship_id', $friendship->id)
                ->update(['data->status' => 'rejected']);

            return response()->json([
                'success' => true,
                'message' => 'Friend request rejected successfully.',
                'data' => [
                    'friendship' => $friendship->fresh()
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while rejecting the friend request.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function removeFriend(User $user)
    {
        try {
            // Check if they are actually friends
            $friendshipExists = Friendship::where(function ($query) use ($user) {
                $query->where('user_id', auth()->id())
                    ->where('friend_id', $user->id)
                    ->where('status', 'accepted');
            })->orWhere(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->where('friend_id', auth()->id())
                    ->where('status', 'accepted');
            })->exists();

            if (!$friendshipExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not friends with this user.'
                ], 400);
            }

            // Remove all friendship records between the users
            Friendship::where(function ($query) use ($user) {
                $query->where('user_id', auth()->id())
                    ->where('friend_id', $user->id);
            })->orWhere(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->where('friend_id', auth()->id());
            })->delete();

            return response()->json([
                'success' => true,
                'message' => 'Friend removed successfully.',
                'data' => [
                    'removed_user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email
                    ]
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while removing the friend.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function sendFriendRequest(User $user)
    {
        try {
            // Check if user is trying to send request to themselves
            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot send a friend request to yourself.'
                ], 400);
            }

            // Check if friendship already exists
            $existingFriendship = Friendship::where(function ($query) use ($user) {
                $query->where('user_id', auth()->id())
                    ->where('friend_id', $user->id);
            })->orWhere(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->where('friend_id', auth()->id());
            })->first();

            if ($existingFriendship) {
                if ($existingFriendship->status === 'accepted') {
                    return response()->json([
                        'success' => false,
                        'message' => 'You are already friends with this user.'
                    ], 400);
                } elseif ($existingFriendship->status === 'pending') {
                    if ($existingFriendship->user_id === auth()->id()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'You have already sent a friend request to this user.'
                        ], 400);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'This user has already sent you a friend request. Please check your pending requests.'
                        ], 400);
                    }
                }
            }

            // Create new friendship request
            $friendship = Friendship::create([
                'user_id' => auth()->id(),
                'friend_id' => $user->id,
                'status' => 'pending'
            ]);

            // Send notification (if you have FriendRequestNotification)
            try {
                $user->notify(new \App\Notifications\FriendRequestNotification($friendship));
            } catch (\Exception $e) {
                // Continue even if notification fails
                \Log::warning('Failed to send friend request notification: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Friend request sent successfully.',
                'data' => [
                    'friendship_id' => $friendship->id,
                    'sender' => [
                        'id' => auth()->user()->id,
                        'name' => auth()->user()->name,
                        'email' => auth()->user()->email,
                        'avatar' => auth()->user()->avatar ?? null
                    ],
                    'recipient' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'avatar' => $user->avatar ?? null
                    ],
                    'status' => 'pending',
                    'sent_at' => $friendship->created_at->toDateTimeString()
                ]
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error sending friend request: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending the friend request.',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    public function pendingRequestsApi(Request $request)
    {
        // Get user_id from request (query parameter or request body)
        $user_id = $request->input('user_id');

        // Validate that user_id is provided
        if (!$user_id) {
            return response()->json([
                'success' => false,
                'message' => 'User ID is required',
            ], 400);
        }

        // Optional: Verify that the user exists
        $user = User::find($user_id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        // Get pending requests where user is either sender or receiver
        $pendingRequests = Friendship::where('status', 'pending')
            ->where(function ($query) use ($user_id) {
                $query->where('user_id', $user_id)    // requests sent by user
                    ->orWhere('friend_id', $user_id); // requests received by user
            })
            ->with([
                'user:id,name,email,slug,image',   // sender's info
                'friend:id,name,email,slug,image'  // receiver's info
            ])
            ->get()
            ->map(function ($request) use ($user_id) {
                // Add a field to indicate if this user sent or received the request
                $request->request_type = $request->user_id == $user_id ? 'sent' : 'received';

                // Add the other user's info for easier frontend handling
                $request->other_user = $request->user_id == $user_id
                    ? $request->friend  // if user sent request, other user is the friend
                    : $request->user;   // if user received request, other user is the sender

                return $request;
            });

        return response()->json([
            'success' => true,
            'data' => $pendingRequests,
        ]);
    }

    public function cancelRequestApi(Friendship $friendship)
    {
        if ($friendship->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $recipientUser = User::find($friendship->friend_id);

        // Delete the friend request notification
        $recipientUser->notifications()
            ->where('type', 'App\Notifications\FriendRequestNotification')
            ->where('data->friendship_id', $friendship->id)
            ->delete();

        // Delete the friendship request
        $friendship->delete();

        return response()->json(['message' => 'Friend request cancelled successfully.']);
    }
    public function quizReportApi(string $quiz_slug, $user_id)
{
    $user = Auth::user();
    $quiz = Quiz::where('slug', $quiz_slug)->first();

    if (!$quiz) {
        return response()->json([
            'status' => false,
            'message' => 'Quiz not found.'
        ], 404);
    }

    $setting = GeneralSetting::first();

    $subAns = SubjectiveAnswer::where('user_id', $user->id)
                ->where('quiz_id', $quiz->id)
                ->get();

    $objAns = ObjectiveAnswer::where('user_id', $user->id)
                ->where('quiz_id', $quiz->id)
                ->get();
    $response = [
        'status' => true,
        'user' => [
            'name' => $user->name,
            'email' => $user->email,
        ],
        'quiz' => [
            'id' => $quiz->id,
            'name' => $quiz->name,
            'type' => $quiz->type,
            'approve_result' => $quiz->approve_result,
            'reattempt' => $quiz->reattempt,
        ],
        'report' => [],
    ];

    if ($quiz->type == 0) {
        // Subjective
        $total = $subAns->count();
        $attempted = $subAns->whereNotNull('answer')->count();
        $skipped = $subAns->whereNull('answer')->count();
    } else {
        // Objective
        $total = $objAns->count();
        $attempted = $objAns->whereNotNull('user_answer')->count();
        $skipped = $objAns->whereNull('user_answer')->count();
    }

    $response['report'] = [
        'total_questions' => $total,
        'attempted_questions' => $attempted,
        'skipped_questions' => $skipped,
        'result_link' => $quiz->approve_result
            ? route($quiz->type == 0 ? 'sub.front_result' : 'obj.front_result', ['quiz_id' => $quiz->id, 'user_id' => $user->id])
            : null,
        'result_status' => $quiz->approve_result ? 'available' : 'pending',
        'can_reattempt' => !$quiz->approve_result && $quiz->reattempt == 1,
        'reattempt_link' => !$quiz->approve_result && $quiz->reattempt == 1
            ? route('try.again', ['quiz_id' => $quiz->id])
            : null,
    ];

    return response()->json($response);
}
}
