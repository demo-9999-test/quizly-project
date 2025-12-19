<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friendship;
use App\Notifications\FriendRequestNotification;
use App\Models\GeneralSetting;
use Intervention\Image\Facades\Image;
use ColorThief\ColorThief;
use Auth;
use App\Models\SocialMedia;

class FriendshipController extends Controller
{
    //--------------------- sendRequest function code start ----------------------
    public function sendRequest(User $user)
    {
        $friendship = Friendship::create([
            'user_id' => auth()->id(),
            'friend_id' => $user->id,
            'status' => 'pending'
        ]);
        $user->notify(new FriendRequestNotification($friendship));

        return redirect()->back()->with('success', 'Friend request sent.');
    }
    //--------------------- sendRequest function code end ----------------------

    //--------------------- cancelRequest function code start ----------------------
    public function cancelRequest(Friendship $friendship)
    {
        if ($friendship->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Get the recipient user
        $recipientUser = User::find($friendship->friend_id);

        // Delete the notification
        $recipientUser->notifications()
            ->where('type', 'App\Notifications\FriendRequestNotification')
            ->where('data->friendship_id', $friendship->id)
            ->delete();

        // Delete the friendship
        $friendship->delete();

        return redirect()->back()->with('success', 'Friend request cancelled.');
    }
    //--------------------- cancelRequest function code end ----------------------

    //--------------------- acceptRequest function code start ----------------------
    public function acceptRequest(Friendship $friendship)
    {
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

        return redirect()->back()->with('success', 'Friend request accepted.');
    }
    //--------------------- acceptRequest function code end ----------------------

    //--------------------- rejectRequest function code start ----------------------
    public function rejectRequest(Friendship $friendship)
    {
        $friendship->update(['status' => 'rejected']);
        auth()->user()->notifications()
            ->where('type', 'App\Notifications\FriendRequestNotification')
            ->where('data->friendship_id', $friendship->id)
            ->update(['data->status' => 'rejected']);
        return redirect()->back()->with('success', 'Friend request rejected.');
    }
    //--------------------- rejectRequest function code end ----------------------

    //--------------------- removeFriend function code start ----------------------
    public function removeFriend(User $user)
    {
        Friendship::where(function ($query) use ($user) {
            $query->where('user_id', auth()->id())
                ->where('friend_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('friend_id', auth()->id());
        })->delete();
        return redirect()->back()->with('success', 'Friend removed.');
    }
    //--------------------- removeFriend function code end ----------------------

    //--------------------- friends_page function code start ----------------------
    public function friends_page($user_slug) {
        // Fetch the user by the slug
        $user = User::where('slug', $user_slug)->firstOrFail();

        // Check if the slug belongs to the authenticated user
        if ($user->id === auth()->id()) {
            return redirect()->route('profile.page');
        }

        // Fetch general settings
        $setting = GeneralSetting::first();

        // Determine if there is a friendship between the authenticated user and the profile user
        $friendship = Friendship::where(function ($query) use ($user) {
            $query->where('user_id', auth()->id())
                  ->where('friend_id', $user->id)
                  ->orWhere('user_id', $user->id)
                  ->where('friend_id', auth()->id());
        })->first();

        $badges = $user->badges;
        $socialMedia = SocialMedia::where('user_id', $user->id)->get();

        return view('front.friends_page', compact('user', 'setting', 'friendship', 'badges','socialMedia'));
    }
    //--------------------- friends_page function code end ----------------------

    //--------------------- searchUsers function code start ----------------------
    public function searchUsers(Request $request)
    {
        $query = $request->input('query');

        $users = User::where('status', '1')
            ->where('id', '!=', auth()->id())
            ->where('role', '!=', 'A')
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%");
            })
            ->whereDoesntHave('friends', function($q) {
                $q->where('friend_id', auth()->id());
            })
            ->take(9)
            ->get();

        $suggestions = User::where('name', 'LIKE', "{$query}%")
            ->where('id', '!=', auth()->id())
            ->where('role', '!=', 'A')
            ->select('name', 'slug', 'image')
            ->take(5)
            ->get();

        return response()->json([
            'users' => $users,
            'suggestions' => $suggestions
        ]);
    }
    //--------------------- searchUsers function code end ----------------------

    //--------------------- find_friends function code start ----------------------
    public function find_friends(Request $request)
    {
        $setting = GeneralSetting::first();

        $query = User::where('status', '1')
            ->where('id', '!=', Auth::id())
            ->where('role', '!=', 'A')
            ->whereDoesntHave('friends', function($query) {
                $query->where('friend_id', Auth::id());
            });

        // Apply sorting based on the selected option
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
            default:
                $query->get();
        }

        $users = $query->paginate(9)->appends(['sort' => $request->input('sort')]);

        $usersWithColors = $users->map(function ($user) {
            $imagePath = public_path('images/users/'.$user->image);
            $bannerColor = $this->getColorFromImage($imagePath);
            $user->bannerColor = $bannerColor;
            return $user;
        });

        return view('front.find_friends_page', compact('users', 'setting', 'usersWithColors'))->render();
    }
    //--------------------- find_friends function code end ----------------------

    //--------------------- getColorFromImage function code start ----------------------
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
    //--------------------- getColorFromImage function code end ----------------------

    //--------------------- my_friends function code start ----------------------
    public function my_friends() {
        $user = Auth::user();
        $setting = GeneralSetting::first();

        // Fetch accepted friendships
        $acceptedFriendships = Friendship::where('user_id', $user->id)
            ->where('status', 'accepted')
            ->get();

        $acceptedFriendIds = $acceptedFriendships->pluck('friend_id');

        $friends = User::whereIn('id', $acceptedFriendIds)->get();

        $friendsWithColors = $friends->map(function ($friend) {
            $imagePath = public_path('images/users/'.$friend->image);
            $bannerColor = $this->getColorFromImage($imagePath);
            $friend->bannerColor = $bannerColor;
            return $friend;
        });

        // Fetch pending sent requests
        $pendingSentRequests = Friendship::where('user_id', $user->id)
            ->where('status', 'pending')
            ->with('friend')
            ->get();

        // Fetch received friend requests
        $receivedRequests = Friendship::where('friend_id', $user->id)
            ->where('status', 'pending')
            ->with('user')
            ->get();

        return view('front.my_friends', compact('user', 'setting', 'friendsWithColors', 'pendingSentRequests', 'receivedRequests'));
    }
    //--------------------- my_friends function code end ----------------------
}
