<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\ForgetPasswordController;
use App\Http\Controllers\Api\Main\BattleApiController;
use App\Http\Controllers\Api\Main\FriendshipController;
use App\Http\Controllers\Api\Main\{
    BlogController,
    FAQController,
    MainController,
    PagesController,
    SliderController,
    TestimonialController,
    OrderController
};
use App\Http\Controllers\Api\QuizApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/forget-password', [ForgetPasswordController::class, 'forgetPasswordPost']);
    Route::get('/reset-password/{token}', [ForgetPasswordController::class, 'resetPassword']);
    Route::apiResource('blog', BlogController::class);
    Route::post('/blog/update-blog/{id}', [BlogController::class, 'update']);
    Route::apiResource('faq', FAQController::class);
    Route::post('/faq/update-faq/{id}', [FAQController::class, 'update']);
    Route::apiResource('pages', PagesController::class);
    Route::post('/pages/update-pages/{id}', [PagesController::class, 'update']);
    Route::apiResource('slider', SliderController::class);
    Route::post('/slider/update-slider/{id}', [SliderController::class, 'update']);
    Route::apiResource('testimonial', TestimonialController::class);
    Route::post('/testimonial/update-testimonial/{id}', [TestimonialController::class, 'update']);
    Route::middleware('auth:api')->group(function () {
    Route::post('/bookmark/add', [MainController::class, 'bookmarkadd']);
    Route::post('/bookmark/remove', [MainController::class, 'bookmarkremove']);
    Route::get('/bookmark', [MainController::class, 'bookmark']);
    Route::get('/user', [MainController::class, 'user']);
    Route::get('/profile', [MainController::class, 'profileData']);
    Route::post('/profile/update', [MainController::class, 'updateProfile']);
    Route::post('battle/invite', [BattleApiController::class, 'invite']);
    Route::post('battle/join', [BattleApiController::class, 'join']);
    Route::get('generate-code', [BattleApiController::class, 'generateCode']);
     Route::get('/start/{battle_id}/{quiz_id}', [BattleApiController::class, 'startBattle']);
    Route::post('/store-battle', [BattleApiController::class, 'storeBattle']);
    Route::get('/result/{quiz_id}/{battle_id}', [BattleApiController::class, 'result']);
    // Route::post('battle/submit/{quiz_id}/{question_id}/{battle_id}', [BattleApiController::class, 'storeBattle']);
    // Route::get('battle/result/{quiz_slug}/{user_slug}/{battle_id}', [BattleApiController::class, 'result']);
    Route::get('friend/find', [FriendshipController::class, 'findFriends']);
    Route::get('friend/my', [FriendshipController::class, 'myFriends']);
    Route::get('friend/search', [FriendshipController::class, 'searchUsers']);
    Route::get('friend/my/search', [FriendshipController::class, 'myFriends1']);
    Route::post('/friend/{friendship}/accept', [FriendshipController::class, 'acceptRequest']);
    Route::post('/friend/{friendship}/reject', [FriendshipController::class, 'rejectRequest']);
    Route::delete('/friend/remove/{user}', [FriendshipController::class, 'removeFriend']);
    Route::post('/friend/send/{user}', [FriendshipController::class, 'sendFriendRequest']);
    Route::match(['get', 'post'], '/notifications', [MainController::class, 'manageNotifications']);
    Route::get('/battle/room/{id}', [BattleApiController::class, 'showRoom'])->name('api.battle.room');        
    Route::post('/create-order', [OrderController::class, 'createOrderApi']);
    Route::delete('/notifications/{id}', [MainController::class, 'deleteNotification']);
    Route::get('/my-report/{quiz_slug}', [MainController::class, 'myReport']);
    Route::get('/quiz-report/{quiz_slug}', [MainController::class, 'quizReport']);
    Route::get('quiz/{quiz_id}/result/{user_id}', [MainController::class, 'result']);
    Route::get('/user/plans', [MainController::class, 'plans']);
    Route::get('/coupons', [MainController::class, 'coupon']);
    Route::post('/apply-coupon', [MainController::class, 'applyCoupon']);
    Route::get('/leaderboard', [MainController::class, 'getLeaderboard']);
    Route::get('/user-coins', [MainController::class, 'getUserCoins']);
    Route::post('/account/request-delete', [MainController::class, 'requestDeleteAccount']);
    Route::post('/quiz/{id}/try-again', [MainController::class, 'tryAgain']);
    Route::get('/howtoplay', [MainController::class, 'howtoplay']);
    Route::get('/friend-requests/pending', [FriendshipController::class, 'pendingRequestsApi']);
    Route::delete('/friend-requests/{friendship}/cancel', [FriendshipController::class, 'cancelRequestApi']);
    Route::post('/quizzes/{quiz}/submit', [MainController::class, 'quizsubmit']);
    Route::get('quiz/{quizId}/status', [MainController::class, 'getQuizStatus']);
    Route::post('user_delete', [MainController::class, 'user_delete']);
    Route::get('/quizzes/search', [MainController::class, 'search']);
    Route::get('/discover_search', [MainController::class, 'discoverSearch']);
    Route::get('/quiz-report/{quiz_slug}/{user_id}', [FriendshipController::class, 'quizReportApi']);
    Route::post('/coins/add', [MainController::class, 'addCoins']);
    Route::get('all/quizes', [MainController::class, 'allQuizzes']);
    Route::get('/currencies', [MainController::class, 'getCurrency']);
    Route::get('payment-keys', [MainController::class, 'getPaymentKeys']);
    Route::get('/user-orders', [OrderController::class, 'userOrders']);
    Route::get('/invoice/{transaction_id}', [OrderController::class,'invoice']);
    Route::post('blog/comment', [MainController::class, 'blogComment']);
    Route::get('blog-comments/{blog_id}', [MainController::class, 'blogComments']);
    Route::get('coins-transaction', [MainController::class, 'coinsTransaction']);
    Route::get('languages', [MainController::class, 'getLanguages']);
    });
    Route::get('/badge', [MainController::class, 'badge']);
    Route::get('/homepage', [MainController::class, 'homepage']);
    Route::get('/blog', [MainController::class, 'blog']);
    Route::get('/blog-details/{slug}', [MainController::class, 'blogDetails']);
    Route::get('/faq', [MainController::class, 'faq']);
    Route::get('/pages', [MainController::class, 'pages']);
    Route::get('/quiz', [MainController::class, 'quiz']);
    Route::get('/quiz-details/{slug}', [MainController::class, 'quizDetails']);
    Route::get('/footer-settings', [MainController::class, 'footerSettings']);
    Route::post('/contact-us', [MainController::class, 'contactus']);
    Route::get('/quizzes', [MainController::class, 'quizcategory']);
    Route::prefix('battle')->group(function () {
    Route::get('/', [BattleApiController::class, 'getBattle']);
    Route::post('/store', [BattleApiController::class, 'createOrUpdate']);
    Route::get('/check-opponent/{id}', [BattleApiController::class, 'checkOpponent']);
    Route::get('/status/{battle_id}/{quiz_slug}/{user_slug}', [BattleApiController::class, 'checkBattleStatus']);
    Route::post('/send-otp', [SMSController::class, 'sendOtp']);
});
