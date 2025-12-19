<?php

namespace App\Http\Controllers\Api\Main;

use App\Http\Controllers\Controller;
use App\Models\AccountDeletionRequest;
use App\Models\Advertisement;
use App\Models\Affiliate;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\Badge;
use App\Models\Bookmark;
use App\Models\Category;
use App\Models\checkout;
use App\Models\FAQ;
use App\Models\FooterSetting;
use App\Models\Friendship;
use App\Models\GeneralSetting;
use App\Models\Newsletter;
use Illuminate\Support\Collection;
use App\Models\Pages;
use App\Models\PostCategory;
use App\Models\Quiz;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\Coins;
use App\Models\User;
use App\Models\ContactUs;
use App\Models\Coupon;
use App\Models\Homepagesetting;
use App\Models\Leaderboard;
use App\Models\Objective;
use App\Models\ObjectiveAnswer;
use App\Models\Packages;
use App\Models\Reason;
use App\Models\SocialMedia;
use App\Models\SubjectiveAnswer;
use App\Models\Zone;
use App\Models\QuizAttempt; // ✅ Add this
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\LanguageSetting;
use Laracasts\Flash\Flash;
use Laravolt\Avatar\Facade as Avatar;

class MainController extends Controller
{
protected function checkUserAttempt($userId, $quizId)
{
    if (!$userId) return false;

    return QuizAttempt::where('user_id', $userId)
                  ->where('quiz_id', $quizId)
                  ->exists();
}

protected function canReattempt($userId, $quiz)
{
    if (!$userId || !$quiz->reattempt_duration) return false;

    $lastAttempt = QuizAttempt::where('user_id', $userId)
                          ->where('quiz_id', $quiz->id)
                          ->latest()
                          ->first();

    if (!$lastAttempt) {
        return true;
    }

    $reattemptAfter = Carbon::parse($lastAttempt->created_at)
                            ->addMinutes((int) $quiz->reattempt_duration);

    return now()->greaterThanOrEqualTo($reattemptAfter);
}

protected function getAvailableActions($hasAttempted, $userId)
{
    if (!$userId) {
        return ['login_required'];
    }

    return $hasAttempted ? ['view_results'] : ['start_quiz'];
}

protected function getAttemptSummary($userId, $quizId, $quiz)
{
    $attempt = QuizAttempt::where('user_id', $userId)
                      ->where('quiz_id', $quizId)
                      ->latest()
                      ->first();

    if (!$attempt) return [];

    return [
        'score' => $attempt->score,
        'completed_at' => Carbon::parse($attempt->completed_at)->toDateTimeString(),
        'time_spent' => $attempt->time_spent,
        'allowed_time' => (int) $quiz->duration
    ];
}

    public function homepage()
    {
        $slider = Slider::where('status', '1')->get()->map(function ($item) {
            $item->images = asset('images/slider/' . $item->images);
            return $item;
        });

        $categories = Category::where('status', '1')->get()->map(function ($item) {
            if (empty($item->image) || !file_exists(public_path($item->image))) {

                $item->image = Avatar::create($item->name)->toBase64();
            } else {
                $item->image = asset($item->image);
            }
            return $item;
        });

        $zone = Zone::where('status', '1')->get()->map(function ($item) {
            $item->image = asset('images/zone/' . $item->image);
            return $item;
        });

        $testimonial = Testimonial::where('status', '1')->get()->map(function ($item) {
            $item->images = asset('images/testimonial/' . $item->images);
            return $item;
        });

        $blog = Blog::where('status', '1')->get()->map(function ($item) {
            $item->thumbnail_img = asset('images/blog/' . $item->thumbnail_img);
            $item->banner_img = asset('images/blog/' . $item->banner_img);
            return $item;
        });

        $newsletter = Newsletter::where('status', '1')->get()->map(function ($item) {
            $item->image = asset('images/newsletter/' . $item->image);
            return $item;
        });

        $users = User::where('status', '1')
            ->where('id', '!=', Auth::id())
            ->where('role', '!=', 'A')
            ->whereDoesntHave('friends', function ($query) {
                $query->where('friend_id', Auth::id());
            })
            ->get()->map(function ($item) {
                $item->image = asset('images/users/' . $item->image);
                return $item;
            });

        $quiz = Quiz::where('status', '1')->where('approve_result', '0')->get()->map(function ($item) {
            $item->image = asset('images/quiz/' . $item->image);
            return $item;
        });

        $bookmarkedQuizIds = auth()->check()
            ? auth()->user()->bookmarks()->pluck('quiz_id')->toArray()
            : [];

        $advertisement = Advertisement::orderBy('created_at', 'desc')->take(2)->get()->map(function ($item) {
            $item->image = asset('images/advertisement/' . $item->image);
            return $item;
        });

        $friend = User::where('role', '!=', 'A')
            ->where('id', '!=', Auth::id())
            ->take(6)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'slug' => $user->slug,
                    'image' => $user->image
                        ? asset('images/users/' . $user->image)
                        : Avatar::create($user->name)->toBase64(),
                ];
            });

        $gsetting = Generalsetting::first();
        $current_date = Carbon::now()->toDateString();

        return response()->json([
            'data' => [
                'slider' => $slider,
                'categories' => $categories,
                'zone' => $zone,
                'testimonial' => $testimonial,
                'blog' => $blog,
                'quiz' => $quiz,
                'bookmarkedQuizIds' => $bookmarkedQuizIds,
                'newsletter' => $newsletter,
                'users' => $users,
                'advertisement' => $advertisement,
                'gsetting' => $gsetting,
                'current_date' => $current_date,
                'friend' => $friend,
            ]
        ]);
    }


    public function blog()
    {
        $blogs = Blog::where('status', '1')
            ->with('postcategory')
            ->get()
            ->map(function ($item) {
                $item->thumbnail_img = asset('images/blog/' . $item->thumbnail_img);
                $item->banner_img = asset('images/blog/' . $item->banner_img);
                return $item;
            });

        return response()->json($blogs);
    }

    public function blogDetails(string $slug)
    {
        $currentBlog = Blog::with('postcategory')->where('slug', $slug)->first();

        if (!$currentBlog) {
            return response()->json([
                'message' => 'Blog not found'
            ], 404);
        }

        $currentBlog->thumbnail_img = asset('images/blog/' . $currentBlog->thumbnail_img);
        $currentBlog->banner_img = asset('images/blog/' . $currentBlog->banner_img);
        $currentBlog->category_name = $currentBlog->postcategory->categories ?? null;

        return response()->json([
            'current_blog' => $currentBlog,
        ]);
    }

    public function faq()
    {
        $faq = FAQ::all();

        if (!$faq) {
            return response()->json([
                'message' => 'FAQ not found'
            ], 404);
        }

        return response()->json([
            'data' => $faq
        ]);
    }

    public function pages()
    {
        $pages = Pages::all();

        if (!$pages) {
            return response()->json([
                'message' => 'Page not found'
            ], 404);
        }

        return response()->json([
            'data' => $pages
        ]);
    }

    public function quiz(Request $request)
    {
        $userId = $request->user_id;

        $quizzes = Quiz::where('status', 1)
            ->with(['questions', 'objectiveAnswers', 'subjectiveAnswers', 'category', 'objectiveQuestions'])
            ->get()
            ->map(function ($quiz) use ($userId) {
                return [
                    'id' => $quiz->id,
                    'name' => $quiz->name,
                    'slug' => $quiz->slug,
                    'description' => $quiz->description,
                    'timer' => $quiz->timer,
                    'image' => $quiz->image ? asset('images/quiz/' . $quiz->image) : null,
                    'start_date' => $quiz->start_date,
                    'end_date' => $quiz->end_date,
                    'status' => $quiz->status,
                    'reattempt' => $quiz->reattempt,
                    'type' => $quiz->type,
                    'category_name' => $quiz->category_name,
                    'question_order' => $quiz->question_order,
                    'subject' => $quiz->subject,
                    'service' => $quiz->service,
                    'fees' => $quiz->fees,
                    'approve_result' => $quiz->approve_result,
                    'created_at' => $quiz->created_at,
                    'updated_at' => $quiz->updated_at,
                    'deleted_at' => $quiz->deleted_at,
                    'is_bookmarked' => $userId ? $quiz->isBookmarkedByUser($userId) : false,
                    'questions' => $quiz->questions->map(function ($question) {
                        return [
                            'id' => $question->id,
                            'correct_answer' => $question->correct_answer,
                            'question_type' => $question->question_type,
                            'question' => [
                                'id' => $question->id,
                                'question' => $question->question,
                            ],
                        ];
                    }),
                    'objective_questions' => $quiz->objectiveQuestions->map(function ($objective) {
                        return [
                            'id' => $objective->id,
                            'question' => $objective->question,
                            'options' => [
                                'option_a' => $objective->option_a,
                                'option_b' => $objective->option_b,
                                'option_c' => $objective->option_c,
                                'option_d' => $objective->option_d,
                            ],
                            'correct_answer' => $objective->correct_answer,
                            'quiz_id' => $objective->quiz_id,
                        ];
                    }),
                    'objective_answers' => $quiz->objectiveAnswers->map(function ($answer) {
                        return [
                            'id' => $answer->id,
                            'correct_answer' => $answer->correct_answer,
                            'question_type' => $answer->question_type,
                            'question' => [
                                'id' => $answer->question->id,
                                'question' => $answer->question->question,
                            ],
                        ];
                    }),
                    'subjective_answers' => $quiz->subjectiveAnswers->map(function ($answer) {
                        return [
                            'id' => $answer->id,
                            'correct_answer' => $answer->correct_answer,
                            'question_type' => $answer->question_type,
                            'question' => [
                                'id' => $answer->question->id,
                                'question' => $answer->question->question,
                            ],
                        ];
                    }),
                ];
            });

        return response()->json([
            'data' => $quizzes
        ]);
    }

    public function quizcategory(Request $request)
    {
        $categoryName = $request->category_name;

        if (!$categoryName) {
            return response()->json([
                'message' => 'category_name is required.'
            ], 400);
        }

        $quizzes = Quiz::where('status', 1)
            ->whereHas('category', function ($q) use ($categoryName) {
                $q->where('name', $categoryName);
            })
            ->with([
                'questions',
                'objectiveAnswers.question',
                'subjectiveAnswers.question',
                'category',
                'objectiveQuestions' // This should load from Objective model
            ])
            ->get()
            ->map(function ($quiz) {
                // Get unique question IDs from objective_answers to fetch actual questions
                $questionIds = $quiz->objectiveAnswers->pluck('question.id')->unique();

                // Fetch objective questions with options
                $objectiveQuestions = [];
                if ($questionIds->isNotEmpty()) {
                    $objectiveQuestions = \App\Models\Objective::whereIn('id', $questionIds)
                    ->get()
                    ->map(function ($objective) {
                        return [
                            'id' => $objective->id,
                            'question' => $objective->question,
                            'options' => [
                                'option_a' => $objective->option_a,
                                'option_b' => $objective->option_b,
                                'option_c' => $objective->option_c,
                                'option_d' => $objective->option_d,
                            ],
                            'correct_answer' => $objective->correct_answer,
                            'quiz_id' => $objective->quiz_id,
                        ];
                    });
                }

                return [
                    'id' => $quiz->id,
                    'name' => $quiz->name,
                    'slug' => $quiz->slug,
                    'description' => $quiz->description,
                    'timer' => $quiz->timer,
                    'image' => $quiz->image ? asset('images/quiz/' . $quiz->image) : null,
                    'start_date' => $quiz->start_date,
                    'end_date' => $quiz->end_date,
                    'status' => $quiz->status,
                    'reattempt' => $quiz->reattempt,
                    'type' => $quiz->type,
                    'category_name' => $quiz->category->name ?? null,
                    'question_order' => $quiz->question_order,
                    'subject' => $quiz->subject,
                    'service' => $quiz->service,
                    'fees' => $quiz->fees,
                    'approve_result' => $quiz->approve_result,
                    'created_at' => $quiz->created_at,
                    'updated_at' => $quiz->updated_at,
                    'deleted_at' => $quiz->deleted_at,
                    'is_bookmarked' => false, // You can implement this logic as needed
                    'questions' => $quiz->questions->map(function ($question) {
                        return [
                            'id' => $question->id,
                            'correct_answer' => $question->correct_answer,
                            'question_type' => $question->question_type,
                            'question' => [
                                'id' => $question->id,
                                'question' => $question->question,
                            ],
                        ];
                    }),
                    // Add objective questions with options
                    'objective_questions' => $objectiveQuestions,
                    'objective_answers' => $quiz->objectiveAnswers->map(function ($answer) {
                        return [
                            'id' => $answer->id,
                            'correct_answer' => $answer->correct_answer,
                            'question_type' => $answer->question_type,
                            'question' => [
                                'id' => $answer->question->id,
                                'question' => $answer->question->question,
                            ],
                        ];
                    }),
                    'subjective_answers' => $quiz->subjectiveAnswers->map(function ($answer) {
                        return [
                            'id' => $answer->id,
                            'correct_answer' => $answer->correct_answer,
                            'question_type' => $answer->question_type,
                            'question' => [
                                'id' => $answer->question->id,
                                'question' => $answer->question->question,
                            ],
                        ];
                    }),
                ];
            });

        return response()->json([
            'data' => $quizzes
        ]);
    }

    public function quizDetails($slug, Request $request)
    {
        $userId = $request->user_id;

        $quiz = Quiz::with(['questions', 'objectiveQuestions'])->where('slug', $slug)->where('status', 1)->first();

        if (!$quiz) {
            return response()->json([
                'status' => false,
                'message' => 'Quiz not found.'
            ], 404);
        }

        $data = [
            'id' => $quiz->id,
            'name' => $quiz->name,
            'slug' => $quiz->slug,
            'description' => $quiz->description,
            'timer' => $quiz->timer,
            'image' => $quiz->image ? asset('images/quiz/' . $quiz->image) : null,
            'start_date' => $quiz->start_date,
            'end_date' => $quiz->end_date,
            'status' => $quiz->status,
            'reattempt' => $quiz->reattempt,
            'type' => $quiz->type,
            'category_name' => $quiz->category_name,
            'question_order' => $quiz->question_order,
            'subject' => $quiz->subject,
            'service' => $quiz->service,
            'fees' => $quiz->fees,
            'approve_result' => $quiz->approve_result,
            'created_at' => $quiz->created_at,
            'updated_at' => $quiz->updated_at,
            'deleted_at' => $quiz->deleted_at,
            'is_bookmarked' => $userId ? $quiz->isBookmarkedByUser($userId) : false,

            'questions' => $quiz->questions->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question' => $question->question,
                ];
            }),

            'objective_questions' => $quiz->objectiveQuestions->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question' => $question->question,
                    'question' => $question->question,
                    'option_1' => $question->option_a,
                    'option_2' => $question->option_b,
                    'option_3' => $question->option_c,
                    'option_4' => $question->option_d,
                    'correct_answer' => $question->correct_answer,
                ];
            }),

            'subjective_questions' => $quiz->questions->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question' => $question->question,
                ];
            }),
        ];

        return response()->json([
            'data' => $data
        ]);
    }


    public function footerSettings()
    {
        $footer = FooterSetting::first();
        $general = GeneralSetting::first();
        $pages = Pages::where('status', 1)->orderBy('position')->get(['title']);

        if (!$footer || !$general) {
            return response()->json([
                'status' => false,
                'message' => 'Settings not found.',
            ], 404);
        }

        $data = [
            'footer' => [
                'title' => $footer->title,
                'image' => $footer->image ? asset('images/footer/' . $footer->image) : null,
                'footer_logo' => $footer->footer_logo ? asset('images/footer/' . $footer->footer_logo) : null,
                'fb_url' => $footer->fb_url,
                'linkedin_url' => $footer->linkedin_url,
                'twitter_url' => $footer->twitter_url,
                'insta_url' => $footer->insta_url,
                'desc' => $footer->desc,
                'copyright_text' => $footer->copyright_text,
            ],
            'general' => [
                'contact' => $general->contact,
                'email' => $general->email,
                'address' => $general->address,
                'signup_img' => $general->signup_img ? asset('images/signup_img/' . $general->signup_img) : null,
            ],
            'pages' => [
                'pages' => $pages,
            ]
        ];
        dd($general->signup_img);

        return response()->json([
            'data' => $data
        ]);
    }

    public function contactus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'mobile'  => 'required|string|max:20',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation errors',
                'errors'  => $validator->errors(),
            ], 422);
        }

        ContactUs::create($request->only('name', 'subject', 'email', 'mobile', 'message'));

        return response()->json([
            'status'  => true,
            'message' => 'Message sent successfully!',
        ], 200);
    }

    public function bookmarkadd(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizes,id',
        ]);

        $userId = Auth::id();

        $exists = Bookmark::where('user_id', $userId)
            ->where('quiz_id', $request->quiz_id)
            ->exists();

        if ($exists) {
            return response()->json(['status' => false, 'message' => 'Already bookmarked.']);
        }

        Bookmark::create([
            'user_id' => $userId,
            'quiz_id' => $request->quiz_id,
        ]);

        return response()->json(['status' => true, 'message' => 'Bookmark added successfully.']);
    }

    public function bookmarkremove(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizes,id',
        ]);

        $userId = Auth::id();

        $deleted = Bookmark::where('user_id', $userId)
            ->where('quiz_id', $request->quiz_id)
            ->delete();

        if ($deleted) {
            return response()->json(['status' => true, 'message' => 'Bookmark removed successfully.']);
        }

        return response()->json(['status' => false, 'message' => 'Bookmark not found.']);
    }

 public function profileData()
{
    $user = Auth::user();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthenticated user'
        ], 401);
    }

    $affiliate = Affiliate::first();
    $socialMedia = SocialMedia::where('user_id', $user->id)->get();
    $faq = FAQ::where('status', '1')->get();
    $bookmarks = $user->bookmarks()->with('category')->get();
    $badges = Badge::get()->map(function ($badge) {
        return [
            'id' => $badge->id,
            'name' => $badge->name,
            'description' => $badge->description,
            'image' => asset('images/badge/' . $badge->image),
            'score' => $badge->score,
            'status' => $badge->status,
            'assigned_at' => optional($badge->pivot)->created_at,
        ];
    });

    return response()->json([
        'status' => true,
        'data' => [
            'user' => $user,
            'affiliate' => $affiliate,
            'social_media' => $socialMedia,
            'faq' => $faq,
            'bookmarks' => $bookmarks,
            'badges' => $badges,
        ]
    ]);
}

    public function updateProfile(Request $request)
    {
        $currentUserId = Auth::id();

        if (!$currentUserId) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        $user = User::find($currentUserId);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ], 404);
        }

        $validationRules = [];

        if ($request->has('name')) {
            $validationRules['name'] = 'string|max:255';
        }

        if ($request->has('email')) {
            $validationRules['email'] = 'email|max:255';
        }

        if ($request->has('mobile')) {
            $validationRules['mobile'] = 'string|max:15';
        }

        if ($request->has('gender')) {
            $validationRules['gender'] = 'string|max:10';
        }

        if ($request->has('desc')) {
            $validationRules['desc'] = 'nullable|string';
        }

        if ($request->has('address')) {
            $validationRules['address'] = 'nullable|string';
        }

        if ($request->has('city')) {
            $validationRules['city'] = 'nullable|string';
        }

        if ($request->has('state')) {
            $validationRules['state'] = 'nullable|string';
        }

        if ($request->has('country')) {
            $validationRules['country'] = 'nullable|string';
        }

        if ($request->has('pincode')) {
            $validationRules['pincode'] = 'nullable|string|max:6';
        }

        if ($request->hasFile('image')) {
            $validationRules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        if ($request->has('old_password') || $request->has('password') || $request->has('confirm_password')) {
            $validationRules['old_password'] = 'required_with:password';
            $validationRules['password'] = 'nullable|min:6|required_with:confirm_password';
            $validationRules['confirm_password'] = 'nullable|same:password';
        }

        $request->validate($validationRules);

        DB::beginTransaction();

        try {
            $fillableFields = ['name', 'email', 'mobile', 'gender', 'desc', 'address', 'city', 'state', 'country', 'pincode'];

            foreach ($fillableFields as $field) {
                if ($request->has($field)) {
                    $user->{$field} = $request->input($field);
                }
            }

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images/users', $filename);

                if ($user->image != null) {
                    $existingImagePath = public_path('images/users/' . $user->image);
                    if (file_exists($existingImagePath)) {
                        unlink($existingImagePath);
                    }
                }

                $user->image = $filename;
            }

            $user->save();

            if ($request->has('social_media_type') && $request->has('social_media_url')) {
                $socialMediaData = [];
                foreach ($request->input('social_media_type') as $key => $type) {
                    $url = $request->input('social_media_url')[$key] ?? null;
                    if ($type && $url) {
                        $socialMediaData[] = [
                            'type' => $type,
                            'url' => $url,
                        ];
                    }
                }

                $user->socialMedia()->delete();

                foreach ($socialMediaData as $socialMediaEntry) {
                    $socialMedia = new SocialMedia($socialMediaEntry);
                    $user->socialMedia()->save($socialMedia);
                }
            }

            if ($request->has('password') && $request->has('old_password')) {
                if (!Hash::check($request->old_password, $user->password)) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => 'Old password is incorrect.'
                    ], 400);
                }

                $user->password = bcrypt($request->password);
                $user->save();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully.',
                'user' => $user->fresh()->makeHidden(['password', 'image'])->append('image_url')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Failed to update profile: ' . $e->getMessage(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function howtoplay()
    {
        $user = Auth::id();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated user'
            ], 401);
        }

        $faq = FAQ::where('status', '1')->get();

        return response()->json([
            'status' => true,
            'data' => [
                'user' => $user,
                'faq' => $faq,
            ]
        ]);
    }

 public function search(Request $request) {
    try {
        $query = trim($request->input('query'));

        if (!$query) {
            return response()->json([]); // Return empty if query is empty
        }

        $user = auth()->user();

        // Fetch quizzes based on query and status
        $quizzes = Quiz::where('name', 'like', "%{$query}%")
            ->where('status', 1)
            ->get()
            ->map(function ($quiz) use ($user) {

                $hasAttemptedObj = \App\Models\ObjectiveAnswer::where('quiz_id', $quiz->id)
                    ->where('user_id', $user->id)
                    ->exists();

                $hasAttemptedSub = \App\Models\SubjectiveAnswer::where('quiz_id', $quiz->id)
                    ->where('user_id', $user->id)
                    ->exists();

                $canAttempt = false;

                if ($quiz->reattempt == 1) {
                    $canAttempt = true;
                } else {
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
                    'canAttempt' => $canAttempt,
                    'approve_result' => $quiz->approve_result
                ];
            });

        return response()->json($quizzes);
        
    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        return response()->json(['error' => 'An error occurred while searching'], 500);
    }
}

    public function notification()
    {
        $setting = GeneralSetting::first();

        $user = auth()->user();
        $notifications = $user ? $user->unreadNotifications : collect();

        return response()->json([
            'notifications' => $notifications,
        ]);
    }

    public function deleteNotification($id)
    {
        $user = auth()->user();

        $notification = $user->notifications()->where('id', $id)->first();

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found or does not belong to the authenticated user.',
            ], 404);
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted successfully.'
        ]);
    }

    public function myReport(string $quiz_slug, Request $request)
    {
        // Authenticate the user
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        // Fetch quiz by slug
        $quiz = Quiz::where('slug', $quiz_slug)->first();
        if (!$quiz) {
            return response()->json([
                'status' => 'error',
                'message' => 'Quiz not found',
            ], 404);
        }

        // Fetch general settings
        $setting = GeneralSetting::first();

        // Fetch subjective answers
        $subAns = SubjectiveAnswer::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->get();

        // Fetch objective answers
        $objAns = ObjectiveAnswer::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->get();

        // Calculate metrics for subjective answers
        $subTotalAnswers = $subAns->count();
        $subNonNullAnswers = $subAns->filter(function ($answer) {
            return $answer->answer !== null;
        })->count();
        $subNullAnswers = $subTotalAnswers - $subNonNullAnswers;

        // Calculate metrics for objective answers
        $objTotalAnswers = $objAns->count();
        $objNonNullAnswers = $objAns->filter(function ($answer) {
            return $answer->user_answer !== null;
        })->count();
        $objNullAnswers = $objTotalAnswers - $objNonNullAnswers;

        // Prepare response data
        $response = [
            'status' => 'success',
            'data' => [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'image' => $user->image ? asset('/images/users/' . $user->image) : null,
                ],
                'setting' => [
                    'breadcrumb_img' => $setting && $setting->breadcrumb_img ? asset('images/breadcrumb/' . $setting->breadcrumb_img) : null,
                ],
                'quiz' => [
                    'id' => $quiz->id,
                    'name' => $quiz->name,
                    'slug' => $quiz->slug,
                    'type' => $quiz->type,
                    'approve_result' => $quiz->approve_result,
                    'reattempt' => $quiz->reattempt,
                ],
                'report' => [
                    'subjective' => $quiz->type == 0 ? [
                        'total_questions' => $subTotalAnswers,
                        'attempted_questions' => $subNonNullAnswers,
                        'skipped_questions' => $subNullAnswers,
                        'result_status' => $quiz->approve_result == 1 ? 'available' : 'pending',
                        'result_url' => $quiz->approve_result == 1 ? route('sub.front_result', ['quiz_id' => $quiz->id, 'user_id' => $user->id]) : null,
                    ] : null,
                    'objective' => $quiz->type != 0 ? [
                        'total_questions' => $objTotalAnswers,
                        'attempted_questions' => $objNonNullAnswers,
                        'skipped_questions' => $objNullAnswers,
                        'result_status' => $quiz->approve_result == 1 ? 'available' : 'pending',
                        'result_url' => $quiz->approve_result == 1 ? route('obj.front_result', ['quiz_id' => $quiz->id, 'user_id' => $user->id]) : null,
                    ] : null,
                ],
                'links' => [
                    'home_page' => route('home.page'),
                    'try_again' => ($quiz->approve_result == 0 && $quiz->reattempt == 1) ? route('try.again', ['quiz_id' => $quiz->id]) : null,
                ],
            ],
        ];

        return response()->json($response, 200);
    }

public function quizReport(string $quiz_slug, Request $request)
{
    $user_id = Auth::id() ?? $request->user_id;

    if (!$user_id) {
        return response()->json([
            'status' => false,
            'message' => 'User not authenticated or user_id not provided.'
        ], 401);
    }

    $user = User::findOrFail($user_id);
    $quiz = Quiz::where('id', $quiz_slug)->firstOrFail();
    $setting = GeneralSetting::first();

    // Fetch both types of questions
    $totalObjectiveQuestions = $quiz->objectiveQuestions()->count();
    $totalSubjectiveQuestions = $quiz->questions()->count();
    $totalQuestions = $totalObjectiveQuestions + $totalSubjectiveQuestions;

    // Fetch user answers
    $subAns = SubjectiveAnswer::where('user_id', $user->id)
        ->where('quiz_id', $quiz->id)
        ->get();

    $objAns = ObjectiveAnswer::where('user_id', $user->id)
        ->where('quiz_id', $quiz->id)
        ->get();

    // Count attempted answers
    $attemptedSubjective = $subAns->whereNotNull('answer')->count();
    $attemptedObjective = $objAns->whereNotNull('user_answer')->count();
    $attemptedQuestions = $attemptedSubjective + $attemptedObjective;

    // Skipped = total - attempted
    $skippedQuestions = $totalQuestions - $attemptedQuestions;

    return response()->json([
        'status' => true,
        'message' => 'Quiz report fetched successfully.',
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'image' => $user->image ? asset('images/users/' . $user->image) : null
        ],
        'quiz' => [
            'id' => $quiz->id,
            'name' => $quiz->name,
            'slug' => $quiz->slug,
            'type' => $quiz->type,
            'approve_result' => $quiz->approve_result,
        ],
        'report' => [
            'total_questions' => $totalQuestions,
            'attempted_questions' => $attemptedQuestions,
            'skipped_questions' => $skippedQuestions
        ],
        'answers' => [
            'subjective' => $subAns,
            'objective' => $objAns
        ]
    ]);
}

    public function result($quiz_id, $user_id)
    {
        $setting = GeneralSetting::first();
        $quiz = Quiz::findOrFail($quiz_id);

        $totalQuestions = Objective::where('quiz_id', $quiz_id)->count();
        $totalMarks = Objective::where('quiz_id', $quiz_id)->sum('mark');

        $userAnswers = ObjectiveAnswer::where('quiz_id', $quiz_id)
            ->where('user_id', $user_id)
            ->with('question')
            ->get();

        $userCorrectAnswers = ObjectiveAnswer::where('quiz_id', $quiz_id)
            ->where('user_id', $user_id)
            ->where('answer_approved', '1')
            ->count();

        $userTotal = $totalQuestions > 0
            ? ($userCorrectAnswers / $totalQuestions) * $totalMarks
            : 0;

        $passingMarks = ceil($totalMarks * 0.33);
        $isPassed = $userTotal >= $passingMarks;

        $user = User::findOrFail($user_id);

        return response()->json([
            'setting' => $setting,
            'quiz' => $quiz,
            'total_marks' => $totalMarks,
            'passing_marks' => $passingMarks,
            'user_total' => round($userTotal, 2),
            'is_passed' => $isPassed,
            'correct_answers' => $userCorrectAnswers,
            'total_questions' => $totalQuestions,
            'answers' => $userAnswers,
            'user' => $user,
        ]);
    }

  public function plans(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $currency = DB::table('currencies')->select('code', 'symbol')->where('default', '1')->first();

    $plan = Packages::orderBy('preward', 'asc')->get()->map(function ($item) use ($currency) {
        $item->currency = $currency->code;
        $item->symbol = $currency->symbol;
        return $item;
    });

    return response()->json([
        'user' => $user,
        'plan' => $plan,
        'currency' => $currency
    ]);
}

    public function coupon()
    {
        $coupons = Coupon::all();

        return response()->json([
            'data' => $coupons
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
            'order_amount' => 'required|numeric',
        ]);

        $coupon = Coupon::where('coupon_code', $request->coupon_code)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code.',
            ], 404);
        }

        if ($coupon->start_date > Carbon::now()) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon is not active yet.',
            ]);
        }

        if ($coupon->expiry_date < Carbon::now()) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon has expired.',
            ]);
        }

        if (!$coupon->active_user) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon is currently inactive.',
            ]);
        }

        if ($request->order_amount < $coupon->min_amount) {
            return response()->json([
                'success' => false,
                'message' => 'Order amount is less than the minimum required for this coupon.',
            ]);
        }

        $discount = 0;
        if ($coupon->discount_type === 'percentage') {
            $discount = ($request->order_amount * $coupon->amount) / 100;
            if ($coupon->max_amount && $discount > $coupon->max_amount) {
                $discount = $coupon->max_amount;
            }
        } else {
            $discount = $coupon->amount;
        }

        $final_amount = $request->order_amount - $discount;

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully.',
            'data' => [
                'original_amount' => $request->order_amount,
                'discount' => $discount,
                'final_amount' => $final_amount,
            ]
        ]);
    }

    public function getLeaderboard(Request $request)
    {
        $perPage = 6;

        $allTime = Leaderboard::orderBy('total_score', 'desc')->get();
        $allTime_rank1 = $allTime->shift();
        $allTime_rank2 = $allTime->shift();
        $allTime_rank3 = $allTime->shift();
        $allTime_rest = $this->paginateCollection($allTime, $perPage);

        $startOfMonth = now()->startOfMonth();
        $monthly = Leaderboard::where('updated_at', '>=', $startOfMonth)->orderBy('total_score', 'desc')->get();
        $monthly_rank1 = $monthly->shift();
        $monthly_rank2 = $monthly->shift();
        $monthly_rank3 = $monthly->shift();
        $monthly_rest = $this->paginateCollection($monthly, $perPage);

        $startOfDay = now()->startOfDay();
        $today = Leaderboard::where('updated_at', '>=', $startOfDay)->orderBy('total_score', 'desc')->get();
        $today_rank1 = $today->shift();
        $today_rank2 = $today->shift();
        $today_rank3 = $today->shift();
        $today_rest = $this->paginateCollection($today, $perPage);

        return response()->json([
            'leaderboards' => [
                'all_time' => [
                    'rank1' => $this->transformEntry($allTime_rank1),
                    'rank2' => $this->transformEntry($allTime_rank2),
                    'rank3' => $this->transformEntry($allTime_rank3),
                    'rest'  => $allTime_rest,
                ],
                'monthly' => [
                    'rank1' => $monthly_rank1,
                    'rank2' => $monthly_rank2,
                    'rank3' => $monthly_rank3,
                    'rest'  => $monthly_rest,
                ],
                'today' => [
                    'rank1' => $today_rank1,
                    'rank2' => $today_rank2,
                    'rank3' => $today_rank3,
                    'rest'  => $today_rest,
                ],
            ]
        ]);
    }

    private function paginateCollection(Collection $collection, $perPage)
    {
        $page = request()->get('page', 1);
        $items = $collection->forPage($page, $perPage)->values()->map(function ($item) {
            return $this->transformEntry($item);
        });

        return [
            'data' => $items,
            'total' => $collection->count(),
            'per_page' => $perPage,
            'current_page' => (int) $page,
            'last_page' => ceil($collection->count() / $perPage),
        ];
    }

    private function transformEntry($entry)
    {
        if (!$entry) return null;

        return [
            'id' => $entry->id,
            'user_id' => $entry->user_id,
            'name' => $entry->user->name ?? null,
            'image' => $entry->user->image_url ?? null,
            'total_score' => $entry->total_score,
            'created_at' => $entry->created_at,
            'updated_at' => $entry->updated_at,
        ];
    }

public function getUserCoins(Request $request)
{
    $user = Auth::user();
    $transactions = Coins::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();
    $totalCoins = $transactions->sum('ammount');
    $creditedCoins = $transactions->where('status', 'credited')->sum('ammount');
    $debitedCoins = $transactions->where('status', 'debited')->sum('ammount');
    $balance = $creditedCoins - $debitedCoins;
    return response()->json([
        'user_id' => $user->id,
        'total_coins' => $totalCoins,
        'credited_coins' => $creditedCoins,
        'debited_coins' => $debitedCoins,
        'balance' => $balance,
        'transactions' => $transactions
    ]);
}

public function addCoins(Request $request)
{
    $user = Auth::user();

    $validated = $request->validate([
        'amount' => 'required|numeric|min:1',
        'status' => 'required|in:credited,debited',
        'method' => 'required|string|max:100',
    ]);

    $coin = new Coins();
    $coin->user_id = $user->id; // ✅ FIXED: assign only the ID
    $coin->ammount = $validated['amount'];
    $coin->status = $validated['status'];
    $coin->method = $validated['method'];
    $coin->save();

    return response()->json([
        'message' => 'Coins ' . ($validated['status'] === 'credited' ? 'credited' : 'debited') . ' successfully.',
        'data' => $coin,
    ], 200);
}

    public function requestDeleteAccount(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'reason' => 'required|exists:reasons,id',
        ]);

        if (AccountDeletionRequest::where('user_id', $user->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'You have already requested to delete your account.',
            ], 409);
        }

        AccountDeletionRequest::create([
            'user_id' => $user->id,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Account deletion request submitted successfully.',
        ]);
    }

    public function tryAgain($quiz_id)
    {
        $quiz = Quiz::find($quiz_id);
        $user = Auth::user();

        if (!$quiz) {
            return response()->json([
                'success' => false,
                'message' => 'Quiz not found.'
            ], 404);
        }

        if ($quiz->type == 0) {
            SubjectiveAnswer::where('user_id', $user->id)
                ->where('quiz_id', $quiz_id)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Previous subjective answers deleted.',
                'redirect_to' => route('play.quiz', ['id' => $quiz_id, 'slug' => $quiz->slug]),
            ]);
        } else {
            ObjectiveAnswer::where('user_id', $user->id)
                ->where('quiz_id', $quiz_id)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Previous objective answers deleted.',
                'redirect_to' => route('play.objective', ['id' => $quiz_id, 'slug' => $quiz->slug]),
            ]);
        }
    }

    public function manageNotifications(Request $request)
    {
        $user = auth()->user();

        // If it's a GET request, return notifications
        if ($request->isMethod('get')) {
            $notifications = $user ? $user->unreadNotifications : collect();

            // Transform notifications to include action data
            $transformedNotifications = $notifications->map(function ($notification) {
                $notificationData = [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'data' => $notification->data,
                    'created_at' => $notification->created_at,
                    'read_at' => $notification->read_at,
                ];

                // Add action buttons for friend request notifications
                if ($notification->type === 'App\Notifications\FriendRequestNotification') {
                    $friendshipId = $notification->data['friendship_id'] ?? null;
                    $status = $notification->data['status'] ?? 'pending';

                    // Only show actions if the request is still pending
                    if ($status === 'pending' && $friendshipId) {
                        $notificationData['actions'] = [
                            'accept' => [
                                'action' => 'accept',
                                'friendship_id' => $friendshipId,
                                'label' => 'Accept'
                            ],
                            'reject' => [
                                'action' => 'reject',
                                'friendship_id' => $friendshipId,
                                'label' => 'Reject'
                            ]
                        ];
                    }

                    $notificationData['status'] = $status;
                }

                return $notificationData;
            });

            return response()->json([
                'success' => true,
                'notifications' => $transformedNotifications,
                'total_unread' => $notifications->count()
            ]);
        }

        // If it's a POST request, handle actions
        if ($request->isMethod('post')) {
            $request->validate([
                'action' => 'required|in:accept,reject',
                'friendship_id' => 'required|exists:friendships,id'
            ]);

            $friendship = Friendship::findOrFail($request->friendship_id);

            try {
                // Verify the friendship request belongs to the authenticated user
                if ($friendship->friend_id !== auth()->id()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized to perform this action on the friend request.'
                    ], 403);
                }

                // Verify the friendship is still pending
                if ($friendship->status !== 'pending') {
                    return response()->json([
                        'success' => false,
                        'message' => 'This friend request is no longer pending.'
                    ], 400);
                }

                if ($request->action === 'accept') {
                    // Accept the friend request
                    $friendship->update(['status' => 'accepted']);

                    // Create a reciprocal friendship entry
                    Friendship::create([
                        'user_id' => auth()->id(),
                        'friend_id' => $friendship->user_id,
                        'status' => 'accepted'
                    ]);

                    $message = 'Friend request accepted successfully.';
                    $friendData = array_merge($friendship->user->toArray(), [
                        'image_url' => $friendship->user->image
                            ? asset('images/users/' . $friendship->user->image)
                            : null
                    ]);
                } else {
                    // Reject the friend request
                    $friendship->update(['status' => 'rejected']);
                    $message = 'Friend request rejected successfully.';
                    $friendData = null;
                }

                // Update the notification status
                $notification = auth()->user()->notifications()
                    ->where('type', 'App\Notifications\FriendRequestNotification')
                    ->where('data->friendship_id', $friendship->id)
                    ->first();

                if ($notification) {
                    $data = $notification->data;
                    $data['status'] = $request->action === 'accept' ? 'accepted' : 'rejected';
                    $notification->update(['data' => $data]);

                    // Mark notification as read
                    $notification->markAsRead();
                }

                $responseData = [
                    'friendship' => $friendship->fresh()
                ];

                if ($friendData) {
                    $responseData['friend'] = $friendData;
                }

                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'data' => $responseData
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while processing the friend request.',
                    'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
                ], 500);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid request method.'
        ], 405);
    }

public function getQuizStatus($quizId)
{
    try {
        // Find quiz
        $quiz = Quiz::find($quizId);

        if (!$quiz) {
            return response()->json([
                'success' => false,
                'message' => 'Quiz not found'
            ], 404);
        }

        // Get authenticated user ID (null if not authenticated)
        $userId = Auth::id();

        // Check if user has attempted the quiz
        $hasAttempted = $this->checkUserAttempt($userId, $quizId);

        // Default values
        $canReattempt = false;
        $userAttempts = 0;
        $maxReattempts = $quiz->reattempt_time ?? 1;

        if ($userId) {
            // Count attempts from quiz_attempts table
            $userAttempts = DB::table('quiz_attempts')
                ->where('user_id', $userId)
                ->where('quiz_id', $quizId)
                ->count();

            // Determine if reattempt is allowed
            $canReattempt = $userAttempts < $maxReattempts;
        }

        // Prepare response data
        $responseData = [
            'success' => true,
            'data' => [
                'quiz' => [
                    'id' => $quiz->id,
                    'title' => $quiz->title,
                    'description' => $quiz->description,
                    'duration' => $quiz->duration,
                    'total_questions' => $quiz->total_questions ?? 0,
                    'max_reattempts' => $maxReattempts
                ],
                'user_status' => [
                    'is_authenticated' => !is_null($userId),
                    'user_id' => $userId,
                    'has_attempted' => $hasAttempted,
                    'user_attempts' => $userAttempts,
                    'can_reattempt' => $canReattempt
                ],
                'available_actions' => $this->getAvailableActions($hasAttempted, $userId)
            ]
        ];

        // Add attempt summary if needed
        if ($hasAttempted && $userId) {
        $responseData['data']['attempt_summary'] = $this->getAttemptSummary($userId, $quizId, $quiz);
        }

        return response()->json($responseData);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong',
            'error' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
}
public function badge(Request $request)
    {
        $userId = $request->user_id;

        $badges = Badge::with(['users' => function ($q) use ($userId) {
            $q->where('users.id', $userId);
        }])->get()->map(function ($badge) use ($userId) {
            return [
                'id' => $badge->id,
                'name' => $badge->name,
                'description' => $badge->description,
                'score' => $badge->score,
                'status' => $badge->status,
                'image' => asset('images/badge/' . $badge->image),
                'is_assigned' => $badge->users->isNotEmpty()
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $badges
        ], 200);
    }
public function quizsubmit(Request $request, Quiz $quiz)
{
    // Check if the quiz has questions
    $objectiveQuestionCount = $quiz->objectiveQuestions()->count();
    $subjectiveQuestionCount = $quiz->questions()->count();
    if ($objectiveQuestionCount === 0 && $subjectiveQuestionCount === 0) {
        return response()->json([
            'message' => 'This quiz has no questions available.',
        ], 422);
    }

    // Validate input
    $validator = Validator::make($request->all(), [
        'answers' => 'required|array',
        'answers.*.question_id' => [
            'required',
            function ($attribute, $value, $fail) use ($quiz) {
                $existsInObjectives = \DB::table('objectives')
                    ->where('id', $value)
                    ->where('quiz_id', $quiz->id)
                    ->exists();
                $existsInSubjectives = \DB::table('subjectives')
                    ->where('id', $value)
                    ->where('quiz_id', $quiz->id)
                    ->whereNull('deleted_at')
                    ->exists();

                if (!$existsInObjectives && !$existsInSubjectives) {
                    $fail("The selected {$attribute} is invalid.");
                }
            },
        ],
        'answers.*.answer' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);
    }

    // Get user
    $user = Auth::user();

    // Count previous attempts
    $attemptCount = QuizAttempt::where('quiz_id', $quiz->id)
        ->where('user_id', $user->id)
        ->count();

    // Determine max attempts (default 1 if null)
    $maxAttempts = $quiz->reattempt_time;

    // If already attempted
    if ($attemptCount > 0) {
        // Check if reattempt is allowed
        if (!$quiz->reattempt || $maxAttempts <= 1) {
            return response()->json([
                'message' => 'You have already submitted this quiz, and reattempts are not allowed.',
            ], 403);
        }

        // Check if max attempts exceeded
        if ($attemptCount >= $maxAttempts) {
            return response()->json([
                'message' => "You have reached the maximum number of allowed quiz attempts ({$maxAttempts}).",
            ], 403);
        }

        // Cooldown check
        $lastAttempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('user_id', $user->id)
            ->latest('created_at')
            ->first();

        if ($lastAttempt && $quiz->reattempt_time) {
            $nextAttemptAt = $lastAttempt->created_at->addMinutes((int) $quiz->reattempt_time);
            if (now()->lt($nextAttemptAt)) {
                return response()->json([
                    'message' => 'You can\'t retake this quiz yet. Please wait until ' . $nextAttemptAt->format('Y-m-d H:i:s') . '.',
                ], 403);
            }
        }
    }

    // ✅ Deduct coins if quiz is paid and user is not admin
    if ($quiz->service == 1) {
        if ($user->role != 'A') {
            if ($quiz->fees == 0 || $quiz->fees > $user->coins) {
                return response()->json([
                    'message' => 'Insufficient coins. Please get more coins to attempt this quiz.',
                ], 403);
            } else {
                $this->coins_transaction(
                    $user->id,
                    'By playing quiz: ' . $quiz->name,
                    'debited',
                    $quiz->fees
                );
            }
        }
    }

    // Process answers
    try {
        $marksObtained = 0;
        $answers = $request->input('answers');

        foreach ($answers as $answerData) {
            $questionId = $answerData['question_id'];
            $answer = $answerData['answer'];

            // Determine if question_id is objective
            $isObjective = \DB::table('objectives')
                ->where('id', $questionId)
                ->where('quiz_id', $quiz->id)
                ->exists();

            if ($isObjective) {
                $this->saveObjectiveAnswer($quiz, $user->id, $questionId, $answer, $marksObtained);
            } else {
                $this->saveSubjectiveAnswer($quiz, $user->id, $questionId, $answer);
            }
        }

        // Record attempt
        QuizAttempt::create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'score' => $marksObtained,
            'started_at' => now(),
            'completed_at' => now()
        ]);

        return response()->json([
            'message' => 'Quiz submitted successfully.',
            'marks_obtained' => $marksObtained > 0 ? $marksObtained : null,
        ], 200);
    } catch (\Exception $e) {
        Log::error("Error submitting quiz {$quiz->id} for user {$user->id}: {$e->getMessage()}");
        return response()->json([
            'message' => 'An error occurred while submitting the quiz.',
        ], 500);
    }
}
public function coins_transaction($user_id, $method, $status, $ammount)
{
    $user = User::findOrFail($user_id);

    Coins::create([
        'user_id' => $user->id,
        'method' => $method,
        'status' => $status,
        'ammount' => $ammount
    ]);

    if ($status == 'credited') {
        $user->coins += $ammount;
        $user->save();
        $message = 'Coins have been credited successfully';
    } elseif ($status == 'debited') {
        if ($user->coins >= $ammount) {
            $user->coins -= $ammount;
            $user->save();
            $message = 'Coins have been debited successfully';
        } else {
            $message = 'Not enough coins to debit';
        }
    } else {
        $message = 'Invalid transaction status';
    }

    return [
        'success' => ($status == 'credited' || $status == 'debited'),
        'message' => $message
    ];
}

private function hasUserSubmitted(Quiz $quiz, $userId)
{
    if ($quiz->type == 1) {
        return $quiz->objectiveAnswers()->where('user_id', $userId)->exists();
    }
    return $quiz->subjectiveAnswers()->where('user_id', $userId)->exists();
}

private function saveObjectiveAnswer(Quiz $quiz, $userId, $questionId, $answer, &$marksObtained)
{
    $question = $quiz->objectiveQuestions()->findOrFail($questionId);
    $isCorrect = $question->correct_answer == $answer;

    ObjectiveAnswer::create([
        'quiz_id' => $quiz->id,
        'user_id' => $userId,
        'question_id' => $questionId,
        'user_answer' => $answer,
        'correct_answer' => $question->correct_answer,
        'question_type' => 'objective',
        'answer_approved' => false,
    ]);

    if ($isCorrect) {
        $marksObtained += $question->marks ?? 1;
    }
}

private function saveSubjectiveAnswer(Quiz $quiz, $userId, $questionId, $answer)
{
    SubjectiveAnswer::create([
        'quiz_id' => $quiz->id,
        'user_id' => $userId,
        'question_id' => $questionId,
        'answer' => $answer,
    ]);
}

   public function bookmark()
{
    $user = Auth::user();
    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }
    $bookmarks = Bookmark::with('quiz')->where('user_id', $user->id)->get();
    return response()->json([
        'user' => $user,
        'bookmarks' => $bookmarks,
    ]);
}
public function user_delete(Request $request)
{
    // Validate request inputs
    $validator = Validator::make($request->all(), [
        'reason' => 'required|string',
        'other_reason' => 'required_if:reason,other|max:255',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }
     // Determine reason
    $reason = $request->reason === 'other' ? $request->other_reason : $request->reason;

    // Store the deletion request
    AccountDeletionRequest::create([
        'user_id' => $request->user()->id,
        'reason' => $reason,
    ]);

    return response()->json([
        'message' => 'Your account deletion request has been submitted successfully.'
    ], 200);
}
public function discoverSearch(Request $request)
{
    try {
        $priceFilter = $request->input('price_filter', 'all');
        $typeFilter = $request->input('type_filter', 'all');
        $searchQuery = $request->input('search', '');
        $current_date = Carbon::now()->toDateString();

        $query = Quiz::where('status', '1')->where('approve_result', '0');

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

        $quizzes = $query->paginate(4);

        $bookmarkedQuizIds = auth()->check()
            ? auth()->user()->bookmarks()->pluck('quiz_id')->toArray()
            : [];

        $categories = Category::select('id', 'name')->get();

        return response()->json([
            'current_date' => $current_date,
            'categories' => $categories,
            'filters' => [
                'price_filter' => $priceFilter,
                'type_filter' => $typeFilter,
                'search' => $searchQuery
            ],
            'bookmarked_quiz_ids' => $bookmarkedQuizIds,
            'quizzes' => $quizzes,
        ]);

    } catch (\Exception $e) {
        return $e;
        \Log::error($e->getMessage());
        return response()->json(['error' => 'Failed to load discover page data'], 500);
    }
}
public function allQuizzes()
{
    // Fetch all active quizzes
    $quizzes = Quiz::with(['questions', 'objectiveQuestions'])
        ->where('status', 1)
        ->latest()
        ->get();

    // If no quizzes found
  

    // Format quiz data
    $data = $quizzes->map(function ($quiz) {
        return [
            'id' => $quiz->id,
            'name' => $quiz->name,
            'slug' => $quiz->slug,
            'description' => $quiz->description,
            'timer' => $quiz->timer,
            'image' => $quiz->image ? asset('images/quiz/' . $quiz->image) : null,
            'start_date' => $quiz->start_date,
            'end_date' => $quiz->end_date,
            'status' => $quiz->status,
            'reattempt' => $quiz->reattempt,
            'type' => $quiz->type,
            'category_name' => $quiz->category_name,
            'question_order' => $quiz->question_order,
            'subject' => $quiz->subject,
            'service' => $quiz->service,
            'fees' => $quiz->fees,
            'approve_result' => $quiz->approve_result,
            'created_at' => $quiz->created_at,
            'updated_at' => $quiz->updated_at,
            'deleted_at' => $quiz->deleted_at,

            'questions' => $quiz->questions->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question' => $question->question,
                ];
            }),

            'objective_questions' => $quiz->objectiveQuestions->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question' => $question->question,
                    'option_1' => $question->option_a,
                    'option_2' => $question->option_b,
                    'option_3' => $question->option_c,
                    'option_4' => $question->option_d,
                    'correct_answer' => $question->correct_answer,
                ];
            }),

            'subjective_questions' => $quiz->questions->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question' => $question->question,
                ];
            }),
        ];
    });

    return response()->json([
        'status' => true,
        'data' => $data
    ]);
}

    public function getCurrency()
{
    $currency = DB::table('currencies')->get();
    return response()->json([
        'status' => true,
        'data' => $currency
    ]);
  
}
    public function getpaymentkeys()
    {
        $paymentKeys = [
            'braintree_merchant_id' => env('BRAINTREE_MERCHANT_ID'),
            'braintree_public_key' => env('BRAINTREE_PUBLIC_KEY'),
            'braintree_private_key' => env('BRAINTREE_PRIVATE_KEY'),
            'razorpay_key_id' => env('RAZORPAY_KEY'),
            'razorpay_key_secret' => env('RAZORPAY_SECRET'),
            'stripe_key' => env('STRIPE_KEY'),
            'stripe_secret' => env('STRIPE_SECRET_KEY'),
            'paypal_client_id' => env('PAYPAL_CLIENT_ID'),
            'paypal_secret' => env('PAYPAL_SECRET_ID'),    
            'paypal_mode' => env('PAYPAL_MODE', 'sandbox'), // Default to sandbox if not set
            'paystack_public_key' => env('PAYSTACK_PUBLIC_KEY'),
            'paystack_secret_key' => env('PAYSTACK_SECRET_KEY'),
            'flutterwave_public_key' => env('FLUTTERWAVE_PUBLIC_KEY'),
            'flutterwave_secret_key' => env('FLUTTERWAVE_SECRET_KEY'),
            
        ];
        return response()->json([
            'status' => true,
            'data' => $paymentKeys
        ]);
    }
    public function blogComment(Request $request)
{
    $request->validate([
        'comment' => 'required|string|max:500',
    ]);
    $user = Auth::user();
    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }
    $comment = new BlogComment();
    $comment->blog_id = $request->blog_id;
    $comment->user_id = $user->id;
    $comment->comment = $request->comment;
    $comment->name = $user->name;
    $comment->email = $user->email;
    $comment->save();
    return response()->json([
        'message' => 'Comment added successfully',
        'comment' => [
            'id' => $comment->id,
            'blog_id' => $comment->blog_id,
            'user_id' => $comment->user_id,
            'comment' => $comment->comment,
            'created_at' => $comment->created_at,
            'name' => $user->name,
        ]
    ]);
}
public function blogComments($blogId)
{
    $comments = BlogComment::where('blog_id', $blogId)
        ->with('user')
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($comment) {
            return [
                'id' => $comment->id,
                'blog_id' => $comment->blog_id,
                'user_id' => $comment->user_id,
                'comment' => $comment->comment,
                'created_at' => $comment->created_at,
                'name' => $comment->user ? $comment->user->name : 'Unknown',
            ];
        });

    return response()->json([
        'status' => true,
        'data' => $comments
    ]);
}
public function coinsTransaction(){
    $user = Auth::user();
    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }
    $transactions = Coins::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'user_id' => $transaction->user_id,
                'method' => $transaction->method,
                'status' => $transaction->status,
                'ammount' => $transaction->ammount,
                'created_at' => $transaction->created_at,
            ];
        });
        return response()->json([
        'status' => true,
        'data' => $transactions
    ]);
}
public function getLanguages()
{
    $languages = LanguageSetting::all();
    return response()->json([
        'status' => true,
        'data' => $languages
    ]);
}
}
