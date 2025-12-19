<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Badge;
use App\Models\Testimonial;
use App\Models\Slider;
use App\Models\Blog;
use App\Models\Newsletter;
use App\Models\User;
use App\Models\GeneralSetting;
use App\Models\Quiz;
use Carbon\Carbon;
use App\Models\Homepagesetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Pages;
use Auth;
use App\Models\Advertisement;
use App\Models\Zone;

class HomeController extends Controller
{
    /*---------------------------------- Home page code start ----------------------------------------------*/
    public function index() {
        $slider = Slider::where('status','1')->get();
        $categories = Category::where('status','1')->get();
        $zone = Zone::where('status','1')->get();
        $client = Testimonial::where('status','1')->get();
        $blog = Blog::where('status','1')->get();
        $newsletter = Newsletter::where('status','1')->get();
        $users = User::where('status', '1')
            ->where('id', '!=', Auth::id())
            ->where('role', '!=', 'A')
            ->whereDoesntHave('friends', function($query) {
                $query->where('friend_id', Auth::id());
            })
            ->get();
        $quiz = Quiz::where('status','1')->where('approve_result','0')->get();
        $bookmarkedQuizIds = auth()->check()
        ? auth()->user()->bookmarks()->pluck('quiz_id')->toArray()
        : [];
        $current_date = Carbon::now()->toDateString();
        $advertisement = Advertisement::orderBy('created_at', 'desc')->take(2)->get();
        $gsetting = Generalsetting::first();
        $hsetting = Homepagesetting::first();
        return view('front.home',compact('gsetting','hsetting','current_date','slider','categories','zone','client','blog','quiz','bookmarkedQuizIds','newsletter','users','advertisement'));
    }
    /*---------------------------------- Home page code end ----------------------------------------------*/

    /*---------------------------------- Advertisement code start ----------------------------------------------*/
    public function pagesdetails($slug){
        $setting = GeneralSetting::first();
        $pagedetails = Pages::where('slug', $slug)->first();
        return view('front.pagedetail', compact('pagedetails','setting'));
    }
    /*---------------------------------- Advertisement code end ----------------------------------------------*/
}
