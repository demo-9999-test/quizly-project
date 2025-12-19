<?php

use App\Events\Notify;

use App\Http\Controllers\AccountDeletionRequestController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AamarPayController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\Admin\ApiSettingController;
use App\Http\Controllers\AffiliateHistoryController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\BattleController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BraintreeController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ChatgptController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\CoinsController;
use App\Http\Controllers\ComingSoonController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomSettingController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\FeaturedcategoryController;
use App\Http\Controllers\FlutterwaveController;
use App\Http\Controllers\FooterSettingController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomepagesettingController;
use App\Http\Controllers\InvoiceSettingsController;
use App\Http\Controllers\InstamojoController;
use App\Http\Controllers\IyzicoController;
use App\Http\Controllers\LanguageSettingController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\MailSettingController;
use App\Http\Controllers\ManulPaymentController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\MollieController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\OmiseController;
use App\Http\Controllers\OneSignalNotificationController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\PayWayController;
use App\Http\Controllers\PackagesFeaturesController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\PaystackController;
use App\Http\Controllers\PaytmController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PWASettingController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RazorPayController;
use App\Http\Controllers\ReasonController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SeoSettingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\SocialChatController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\SubjectiveController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\TeamMembersController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\TrustedsliderController;
use App\Http\Controllers\TwoFactorAuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\AdminSettingController;






use App\Http\Controllers\Api\Main\BattleApiController;
use App\Http\Controllers\Api\Main\BlogController as MainBlogController;
use App\Http\Controllers\Api\Main\FAQController as MainFAQController;
use App\Http\Controllers\Api\Main\FriendshipController as MainFriendshipController;
use App\Http\Controllers\Api\Main\MainController;
use App\Http\Controllers\Api\Main\OrderController;
use App\Http\Controllers\Api\Main\SliderController as MainSliderController;
use App\Http\Controllers\Api\Main\TestimonialController as MainTestimonialController;




use App\Http\Controllers\Api\Auth\forgetPasswordController;
use App\Http\Controllers\Api\Auth\IssueTokenTraitController;
use App\Http\Controllers\Api\Auth\JsonController;
//use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;







/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class,'index'])->name('home.page');

Route::middleware(['switch_languages',  'prevent-back-history'])->group(function() {
    Route::get('/', [HomeController::class,'index'])->name('home.page');
});
/*---Auth Controller start--*/

Route::get('/home', [HomeController::class],'index');
Route::get('/badges', [BadgeController::class],'badge')->name('badge.page');Route::get('/get-badge-details/{id}', [BadgeController::class, 'getBadgeDetails'])->name('get.badge.details');
Route::get('/zone', [HomeController::class, 'index'])->name('zone.page');
Route::get('/category/{slug}', [CategorieController::class, 'category_single'])->name('category.single');
Route::get('/contest', [ContestController::class, 'contest_page'])->name('contest.home');
Route::get('/contest/{slug}', [ContestController::class, 'contest_single'])->name('contest.single');
Route::get('/discover', [QuizController::class, 'discover_page'])->name('discover.page');
Route::get('/blog', [BlogController::class, 'blog_page'])->name('blog.page');
Route::get('/blog/{slug}', [BlogController::class, 'blog_details'])->name('blog.details');
Route::post('/blogs/{id}/comment', [BlogController::class, 'blog_comment'])->name('blog.comment');
Route::get('/leaderboard', [LeaderboardController::class, 'leaderboard_page'])->name('leaderboard.page');
Route::get('/details/{slug}', [HomeController::class, 'pagesdetails'])->name('pagesdetails');
Route::post('/subscribe', [NewsLetterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::post('/mailchimp-webhook', [NewsLetterController::class, 'mailchimpWebhook']);
Route::get('/api/search', [QuizController::class, 'search']);

Route::middleware(['auth'])->group(function (){
    Route::get('/my-friends', [FriendshipController::class, 'my_friends'])->name('my.friends');
    Route::get('/profile', [ProfileController::class, 'front_profile'])->name('profile.page');
    Route::post('/profile/setting/{id}', [ProfileController::class, 'user_settings_store'])->name('front.profile.update');
    Route::post('/update-social-media/{id}', [ProfileController::class, 'updateSocialMediaUrls'])->name('update.social.media');
    Route::post('/profile/setting/{id}/upload', [ProfileController::class, 'upload_image'])->name('profile.upload');
    Route::post('/profile/remove/{id}/delete', [ProfileController::class, 'remove_image'])->name('profile.remove');
    Route::post('/profile/password/{id}', [ProfileController::class, 'update_password'])->name('password.update');
    Route::post('/user/delete', [UsersController::class, 'user_delete'])->name('user.delete');
    Route::get('quiz/subjective/{slug}', [QuizController::class, 'play_quiz'])->name('play.quiz');
    Route::get('quiz/objective/{slug}', [QuizController::class, 'play_objective'])->name('play.objective');
    Route::post('quiz/submit/{id}/{question_id}', [QuizController::class, 'store_answers'])->name('submit.quiz');
    Route::post('quiz/submit/objective/{id}/{question_id}', [QuizController::class, 'store_objective_answer'])->name('submite.obj.quiz');
    Route::get('report/{quiz_slug}/{user_slug}', [QuizController::class, 'quiz_report'])->name('report.quiz');
    Route::get('/try-again/{quiz_id}', [QuizController::class, 'try_again'])->name('try.again');
    Route::post('/bookmark', [BookmarkController::class, 'store'])->name('bookmark.add');
    Route::delete('/bookmark/{quiz_id}', [BookmarkController::class, 'destroy'])->name('bookmark.remove');
    Route::get('/bookmark/check/{quiz_id}', [BookmarkController::class, 'check'])->name('bookmark.check');
    Route::get('/bookmark/user', [BookmarkController::class, 'getUserBookmarks'])->name('bookmark.user');
    Route::post('/bookmark/toggle/{quiz}', [BookmarkController::class, 'toggle'])->name('bookmark.toggle');
    Route::get('/checkout/{id}', [CheckoutController::class, 'index'])->name('checkout.page');
    Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.applyCoupon');
    Route::post('/checkout/remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('checkout.removeCoupon');
    Route::get('/result/subjective/{quiz_id}/{user_id}', [SubjectiveController::class, 'result_page'])->name('sub.front_result');
    Route::get('/result/objective/{quiz_id}/{user_id}', [ObjectiveController::class, 'result_page'])->name('obj.front_result');
    Route::get('/coins/{user_slug}', [CoinsController::class, 'user_coins'])->name('front.coins');
    Route::get('/download-quiz-report/{quiz_id}/{user_id}', [PDFController::class, 'downloadQuizReport'])->name('download.quiz.report');
    Route::get('/friend/{slug?}', [FriendshipController::class, 'friends_page'])->name('friend.page');
    Route::get('/find-friend', [FriendshipController::class, 'find_friends'])->name('find.friends');
    Route::get('/search-users', [FriendshipController::class, 'searchUsers'])->name('search.users');
    Route::post('/friend-request/{user}', [FriendshipController::class, 'sendRequest'])->name('friend.request');
    Route::post('/friend-request/{friendship}/cancel', [FriendshipController::class, 'cancelRequest'])->name('friend.cancel');
    Route::post('/friend-request/{friendship}/accept', [FriendshipController::class, 'acceptRequest'])->name('friend.accept');
    Route::post('/friend-request/{friendship}/reject', [FriendshipController::class, 'rejectRequest'])->name('friend.reject');
    Route::delete('/friend/{user}', [FriendshipController::class, 'removeFriend'])->name('friend.remove');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::delete('/notifications/{id}', [NotificationController::class, 'deleteNotification'])->name('notifications.delete');
    Route::get('/battle', [BattleController::class, 'set_battle_page'])->name('battle.setup');
    Route::get('/battle/room/{id}', [BattleController::class, 'showRoom'])->name('battle.room');
    Route::post('/battle/invite', [BattleController::class, 'invite'])->name('invite.user');
    Route::post('/battle/join', [BattleController::class, 'join'])->name('join.user');
    Route::get('/battle/{id}/check-opponent', [BattleController::class, 'checkOpponent'])->name('battle.check-opponent');
    Route::get('/start-battle/{battle_id}/{quiz_id}', [BattleController::class, 'startBattle'])->name('start.battle');
    Route::post('/battle/store/{id}/{question_id}/{battle_id}', [BattleController::class, 'store_battle'])->name('battle.submit');
    Route::get('/battle/result/{quiz_slug}/{user_slug}/{battle_id}', [BattleController::class, 'result'])->name('battle.result');
    Route::get('/check-battle-status/{battle_id}/{quiz_slug}/{user_slug}', [BattleController::class, 'checkBattleStatus'])->name('battle.check_status');

    Route::get('/report/{user_slug}', [QuizController::class, 'my_report'])->name('quiz.reports');

    Route::get('/invoice/{user_slug}/{transaction_id}', [InvoiceSettingsController::class, 'front_invoice'])->name('front.invoice');
    Route::get('/invoice/download/{user_slug}/{transaction_id}', [InvoiceSettingsController::class, 'downloadPdf'])->name('invoice.download');

    Route::get('/contact-us', [ContactController::class, 'contact_page'])->name('contact.us');
    Route::post('/contact-us', [ContactController::class, 'send_message'])->name('send.message');

    Route::get('/support', [SupportController::class, 'showSupportForm'])->name('support.form');
    Route::post('/support/submit', [SupportController::class, 'submitSupportRequest'])->name('support.submit');
});

/*--- Payment gateway controllers ---*/
Route::middleware(['auth'])->group(function (){
    Route::post('/reset-password', [AuthController::class, 'resetPasswordPost'])->name('reset.password.post');
    Route::post('/dopayment/{plan_id}/{plan_amount}', [RazorPayController::class, 'dopayment'])->name('payment');
    Route::post('payment/paytm', [PaytmController::class, 'pay'])->name('paytm.payment');
    Route::post('payment/paytm/status', [PaytmController::class, 'paymentCallback'])->name('paytm.callback');
    Route::post('paypal', [PaypalController::class, 'paywithpaypal'])->name('paypal');
    Route::get('paypal/success', [PaypalController::class, 'paypal_success'])->name('paypal_success');
    Route::get('paypal/cancel', [PaypalController::class, 'paypal_cancel'])->name('paypal_cancel');
    Route::post('/flutterwave', [FlutterwaveController::class, 'initializePayment'])->name('flutterwave.pay');
    Route::get('/flutterwave/callback', [FlutterwaveController::class, 'handlePaymentCallback'])->name('flutterwave.callback');
    Route::post('/stripe', [StripeController::class, 'Payment'])->name('stripe.post');
    Route::get('/paystack/callback', [PaystackController::class, 'handleGatewayCallback'])->name('paystack.callback');
    Route::post('/paystack', [PaystackController::class, 'redirectToGateway'])->name('paystack.payment');
    Route::post('/instamojo', [InstamojoController::class, 'initiatePayment'])->name('instamojo.payment');
    Route::get('/instamojo/callback', [InstamojoController::class, 'handlePaymentCallback'])->name('instamojo.callback');
    Route::post('/payment/omise', [OmiseController::class, 'pay'])->name('pay.omise');
    Route::post('/aamarpay', [AamarPayController::class, 'pay'])->name('aamarpay.payment');
    Route::post('/aamarpay/success', [AamarPayController::class, 'success'])->name('aamarpay.success');
    Route::post('/aamarpay/failed', [AamarPayController::class, 'fail'])->name('aamarpay.failed');
    Route::get('/aamarpay/cancel', [AamarPayController::class, 'cancel'])->name('aamarpay.cancel');
    Route::post('iyzico/izy/payment', [IyzicoController::class, 'pay'])->name('izy.pay');
    Route::post('return/izy/success', [IyzicoController::class, 'callback'])->name('izy.callback');
    Route::post('/mollie/payment', [MollieController::class, 'preparePayment'])->name('mollie.payment');
    Route::get('/mollie/success', [MollieController::class, 'paymentSuccess'])->name('mollie.success');
    Route::get('/mollie/failed', [MollieController::class, 'paymentFailed'])->name('mollie.failed');
    Route::post('/webhook/mollie', [MollieController::class, 'handleWebhook'])->name('webhook.mollie');
    Route::post('/braintree/initiate', [BraintreeController::class, 'initiatePayment'])->name('braintree.initiate');
    Route::post('/braintree/process', [BraintreeController::class, 'processPayment'])->name('braintree.process');
    Route::get('/braintree/token', [BraintreeController::class, 'getClientToken'])->name('braintree.token');
    Route::post('/midtrans/payment/process', [MidtransController::class, 'process'])->name('midtrans.payment.process');
    Route::post('/midtrans/payment/success', [MidtransController::class, 'success'])->name('midtrans.success');
    Route::post('/midtrans//payment/failed', [MidtransController::class, 'failed'])->name('midtrans.failed');
    Route::post('/payway/create', [PayWayController::class, 'createPayment'])->name('payway.create');
    Route::post('/payway/callback', [PayWayController::class, 'handleCallback'])->name('payway.callback');
});

Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'store'])->name('register.store');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login_check'])->name('login.check');

Route::get('/login/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/login/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::get('/login/facebook', [AuthController::class, 'redirectToFacebook'])->name('facebook.login');
Route::get('/login/facebook/callback', [AuthController::class, 'handleFacebookCallback']);

Route::get('/forget-password', [AuthController::class, 'forgetPassword'])->name('forget.password');
Route::post('/forget-password', [AuthController::class, 'forgetPasswordPost'])->name('forget.password.post');

Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('reset.password');
Route::post('/reset-password', [AuthController::class, 'resetPasswordPost'])->name('reset.password.post');

Route::post('/generate-2fa-secret-and-login', [AuthController::class, 'generate2faSecretAndLogin'])->name('generate.2fa.secret.login');

Route::get('/verify-otp', [RegisterController::class, 'showOtpForm'])->name('verify.otp');
Route::post('/verify-otp', [RegisterController::class, 'verifyOTP'])->name('verify.otp.submit');
Route::post('/resend-otp', [RegisterController::class, 'resendOtp'])->name('resend.otp');

Route::get('auth/{provider}', [AuthController::class, 'redirectToProvider'])->name('social.login');
Route::get('auth/{provider}/callback', [AuthController::class, 'handleProviderCallback']);

/*---Auth Controller start--*/

Route::get('/clear', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return redirect()->back()->with('success', 'All types of cache have been cleared successfully.');
});

Route::get('/offline', function () {
    return view('vendor.laravelpwa.offline');
});

Route::middleware(['admin_check', 'switch_languages', 'prevent-back-history'])->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/', [HomeController::class, 'index'])->name('home.page');
Route::get('admin/marketing-dashboard', [DashboardController::class, 'marketing'])->name('admin.marketing');
Route::get('/admin/get-yearly-revenue-data', [DashboardController::class, 'getYearlyRevenueData']);
Route::get('/admin/get-yearly-package-sales-data', [DashboardController::class, 'getYearlyPackageSalesData']);
        });

Route::middleware(['auth', 'switch_languages', 'prevent-back-history'])->group(function () {
        Route::get('/user/dashboard', function () {
            return view('admin.dashboard.user');
            })->name('user.dashboard');
        Route::get('/', [HomeController::class, 'index'])->name('home.page');
        });

        $adminPrefix = env('ADMIN_URL');

        Route::prefix('admin')
            ->middleware(['auth', 'switch_languages', 'prevent-back-history'])
            ->group(function () {
        Route::get('/offline', function () {
            return view('vendor.laravelpwa.offline');
        });
        
        /*---Profile Controller start--*/
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('profile/get/state/country', [ProfileController::class, 'get_state_country'])->name('profile.get.state.country');
        Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('update.password');

        Route::post('/request-account-deletion', [AccountDeletionRequestController::class, 'requestDeletion'])->name('request.account.deletion');

        Route::get('/user_delete', [AccountDeletionRequestController::class, 'index'])->name('user_delete.index');
        Route::post('/user_delete/{id}/approve', [AccountDeletionRequestController::class, 'approve'])->name('user_delete.approve');
        Route::post('/user_delete/{id}/reject', [AccountDeletionRequestController::class, 'reject'])->name('user_delete.reject');

        /*---Testimonial Controller start--*/
        Route::post('/testimonial', [TestimonialController::class, 'store'])->name('testimonial.store');
        Route::get('/testimonial', [TestimonialController::class, 'show'])->name('testimonial.show');
        Route::get('/testimonial/{id}/edit', [TestimonialController::class, 'edit'])->name('testimonial.edit');
        Route::put('/testimonial/{id}', [TestimonialController::class, 'update'])->name('testimonial.update');
        Route::delete('/testimonial/{id}/delete', [TestimonialController::class, 'destroy'])->name('testimonial.destroy');

        //bulk_delete routes
       Route::post('/testimonial/bulk_delete', [TestimonialController::class, 'bulk_delete'])->name('testimonial.bulk_delete');
        Route::post('/testimonial/trash/bulk_delete', [TestimonialController::class, 'trash_bulk_delete'])->name('testimonial.trash_bulk_delete');

        // status update route
        Route::get('testimonial/update-status', [TestimonialController::class, 'updateStatus']);

        // trash and restore routes
        Route::get('/testimonial/trash', [TestimonialController::class, 'trash'])->name('testimonial.trash');
        Route::get('/testimonial/{id}/restore', [TestimonialController::class, 'restore'])->name('testimonial.restore');
        Route::delete('/testimonial/{id}/trash-delete', [TestimonialController::class, 'trashDelete'])->name('testimonial.trashDelete');

        // darg and drop order routes
        Route::post('/testimonial/update-order', [TestimonialController::class, 'updateOrder']); 
        
        /*---Testimonial Controller start--*/
        /*---Blog Controller start--*/
        Route::post('/post', [BlogController::class, 'store'])->name('post.store');
        Route::get('/post', [BlogController::class, 'show'])->name('post.show');
        Route::get('/post/{id}/edit', [BlogController::class, 'edit'])->name('post.edit');
        Route::put('/post/{id}', [BlogController::class, 'update'])->name('post.update');
        Route::delete('/post/{id}/delete', [BlogController::class, 'destroy'])->name('post.destroy');

        Route::post('/post/copy', [BlogController::class, 'copy'])->name('post.copy');
        Route::get('/comments', [BlogController::class, 'blog_comments_table'])->name('blog.comments.table');
        Route::patch('/admin/comments/{id}/toggle', [BlogController::class, 'toggleApproval'])->name('admin.comments.toggle');

        Route::get('/check-env-variables', [BlogController::class, 'checkEnvVariables'])->name('check.env.variables');
        Route::post('/update-env-variables', [BlogController::class, 'updateEnvVariables'])->name('update.env.variables');

        Route::post('/admin/post/generate-images', [BlogController::class, 'generateImages'])->name('post.generate-images');
        Route::post('/admin/post/generate-description', [BlogController::class, 'generateDescription'])->name('post.generate-description');

        //bulk_delete routes
        Route::post('/post/bulk_delete', [BlogController::class, 'bulk_delete'])->name('post.bulk_delete');
        Route::post('/post/trash/bulk_delete', [BlogController::class, 'trash_bulk_delete'])->name('post.trash_bulk_delete');
        
        // status update route
        Route::get('post/update-status', [BlogController::class, 'updateStatus']);
        
        // trash and restore routes
        Route::get('/post/trash', [BlogController::class, 'trash'])->name('post.trash');
        Route::get('/post/{id}/restore', [BlogController::class, 'restore'])->name('post.restore');
        Route::delete('/post/{id}/trash-delete', [BlogController::class, 'trashDelete'])->name('post.trashDelete');
        // drag and drop order routes
        Route::post('/post/update-order', [BlogController::class, 'updateOrder'])->name('post.updateOrder');

        /*--- homepagesettingController Code Start --*/
        Route::get('/homepage-setting', [HomepagesettingController::class, 'index'])->name('admin.home.setting');
        Route::post('/homepage-setting/toggle', [HomepagesettingController::class, 'toggleSetting'])->name('admin.home.setting.toggle');
        /*--- QuizController Code Start --*/
        Route::any('/quiz', [QuizController::class, 'index'])->name('quiz.index');
        Route::get('/quiz/create', [QuizController::class, 'create'])->name('quiz.create');
        Route::post('/quiz/create', [QuizController::class, 'create_post'])->name('quiz.create_post');
        Route::get('/quiz/edit/{id}', [QuizController::class, 'edit'])->name('quiz.edit');
        Route::put('/quiz/edit/{id}', [QuizController::class, 'edit_post'])->name('quiz.edit_post');
        Route::delete('/quiz/delete/{id}', [QuizController::class, 'delete'])->name('quiz.delete');
        Route::post('/quiz/bulk-delete', [QuizController::class, 'bulk_delete'])->name('quiz.bulk_delete');
        Route::get('/quiz/import', [QuizController::class, 'import'])->name('quiz.import');
        Route::post('/quiz/import/save', [QuizController::class, 'importSave'])->name('quiz.importSave');
        Route::get('/quiz/trash', [QuizController::class, 'trash'])->name('quiz.trash');
        Route::get('/quiz/{id}/restore', [QuizController::class, 'restore'])->name('quiz.restore');
        Route::delete('/quiz/{id}/trash-delete', [QuizController::class, 'trashDelete'])->name('quiz.trashDelete');
        Route::post('/quiz/trash/bulk_delete', [QuizController::class, 'trash_bulk_delete'])->name('quiz.trash_bulk_delete');
        Route::patch('/quiz/result-approve/{id}', [QuizController::class, 'approveResult'])->name('quiz.approveResult');
        Route::get('/reports/quiz', [QuizController::class, 'quizReport'])->name('admin.quiz.reports');
        /*--- QuizController Code end --*/

        /*--- ObjectiveController Code Start --*/
        Route::any('/objective/{id}', [ObjectiveController::class, 'index'])->name('objective.index');
        Route::get('/objective/create/{id}', [ObjectiveController::class, 'create'])->name('objective.create');
        Route::post('/objective/create/{id}', [ObjectiveController::class, 'create_post'])->name('objective.create_post');
        Route::get('/objective/edit/{id}/{obj_id}', [ObjectiveController::class, 'edit'])->name('objective.edit');
        Route::post('/objective/edit/{id}/{obj_id}', [ObjectiveController::class, 'edit_post'])->name('objective.edit_post');
        Route::delete('/objective/{id}/{obj_id}', [ObjectiveController::class, 'delete'])->name('objective.delete');
        Route::post('/objective/bulk-delete/{id}', [ObjectiveController::class, 'bulk_delete'])->name('objective.bulk_delete');

        Route::get('/objective/import/{id}', [ObjectiveController::class, 'import'])->name('objective.import');
        Route::post('/objective/import-mcq/save/{id}', [ObjectiveController::class, 'importMcq'])->name('objective.importMcq');
        Route::post('/objective/import-trueFalse/save/{id}', [ObjectiveController::class, 'importTrueFalse'])->name('objective.importTrueFalse');
        Route::post('/objective/import-fiilblank/save/{id}', [ObjectiveController::class, 'importFillBlank'])->name('objective.importFillBlank');
        Route::post('/objective/import-matchfollowing/save/{id}', [ObjectiveController::class, 'importMatchFollowing'])->name('objective.importMatchFollowing');

        Route::get('/objective/trash/{id}', [ObjectiveController::class, 'trash'])->name('objective.trash');
        Route::get('/objective/{id}/{obj_id}/restore', [ObjectiveController::class, 'restore'])->name('objective.restore');
        Route::delete('/objective/{id}/{sub_id}/trash-delete', [ObjectiveController::class, 'trashDelete'])->name('objective.trashDelete');
        Route::post('/objective/trash/bulk_delete/{id}', [ObjectiveController::class, 'trash_bulk_delete'])->name('objective.trash_bulk_delete');

        Route::get('/answer/objective/{id}', [ObjectiveController::class, 'checkAnswers'])->name('objective.checkAnswers');
        Route::get('/answer/objective/{id}/{user_id}', [ObjectiveController::class, 'checkResult'])->name('objective.result');
                /*--- ObjectiveController Code End --*/

                /*--- SubjectiveController Code Start --*/
            Route::any('/subjective/{id}', [SubjectiveController::class, 'index'])->name('subjective.index');
        Route::get('/subjective/create/{id}', [SubjectiveController::class, 'create'])->name('subjective.create');
        Route::post('/subjective/create/{id}', [SubjectiveController::class, 'create_post'])->name('subjective.create_post');

        Route::get('/subjective/edit/{id}/{sub_id}', [SubjectiveController::class, 'edit'])->name('subjective.edit');
        Route::post('/subjective/edit/{id}/{sub_id}', [SubjectiveController::class, 'edit_post'])->name('subjective.edit_post');

        Route::delete('/subjective/{id}/{obj_id}', [SubjectiveController::class, 'delete'])->name('subjective.delete');
        Route::post('/subjective/bulk-delete/{id}', [SubjectiveController::class, 'bulk_delete'])->name('subjective.bulk_delete');

        Route::get('/subjective/import/{id}', [SubjectiveController::class, 'import'])->name('subjective.import');
        Route::post('/subjective/import/save/{id}', [SubjectiveController::class, 'importSave'])->name('subjective.importSave');

        Route::get('/subjective/trash/{id}', [SubjectiveController::class, 'trash'])->name('subjective.trash');
        Route::get('/subjective/{id}/{sub_id}/restore', [SubjectiveController::class, 'restore'])->name('subjective.restore');
        Route::delete('/subjective/{id}/{sub_id}/trash-delete', [SubjectiveController::class, 'trashDelete'])->name('subjective.trashDelete');
        Route::post('/subjective/trash/bulk_delete/{id}', [SubjectiveController::class, 'trash_bulk_delete'])->name('subjective.trash_bulk_delete');

        Route::get('/checkanswers/subjective/{id}', [SubjectiveController::class, 'checkAnswers'])->name('subjective.checkAnswers');
        Route::get('/answer/subjective/{id}/{user_id}', [SubjectiveController::class, 'checkResult'])->name('subjective.result');

        Route::patch('/subjective/toggle-approve/{id}', [SubjectiveController::class, 'toggleApprove'])->name('subjective.toggleApprove');
        /*--- SubjectiveController Code End --*/

        /*--- BadgeController Code Start ---*/
        Route::get('/badge', [BadgeController::class, 'index'])->name('badge.index');
        Route::get('/badge/create', [BadgeController::class, 'create'])->name('badge.create');
        Route::post('/badge', [BadgeController::class, 'store'])->name('badge.store');

        Route::get('/badge/edit/{id}', [BadgeController::class, 'edit'])->name('badge.edit');
        Route::post('/badge/edit/{id}', [BadgeController::class, 'update'])->name('badge.update');

        Route::delete('/badge/{id}', [BadgeController::class, 'destroy'])->name('badge.destroy');
        Route::post('/badge/bulk-delete', [BadgeController::class, 'bulk_delete'])->name('badge.bulk_delete');

        Route::get('/badge/trash', [BadgeController::class, 'trash'])->name('badge.trash');
        Route::get('/badge/{id}/restore', [BadgeController::class, 'restore'])->name('badge.restore');
        Route::delete('/badge/{id}/trash-delete', [BadgeController::class, 'trashDelete'])->name('badge.trashDelete');
        Route::post('/badge/trash/bulk_delete', [BadgeController::class, 'trash_bulk_delete'])->name('badge.trash_bulk_delete');

        Route::get('/reports/badge', [BadgeController::class, 'reports'])->name('admin.badge.reports');
        /*--- BadgeController Code End ---*/

        /*--- ZoneController Code Start ---*/
        Route::get('/zone', [ZoneController::class, 'index'])->name('zone.index');
        Route::get('/zone/create', [ZoneController::class, 'create'])->name('zone.create');
        Route::post('/zone', [ZoneController::class, 'store'])->name('zone.store');

        Route::get('/zone/edit/{id}', [ZoneController::class, 'edit'])->name('zone.edit');
        Route::post('/zone/edit/{id}', [ZoneController::class, 'update'])->name('zone.update');

        Route::delete('/zone/{id}', [ZoneController::class, 'destroy'])->name('zone.destroy');
        Route::post('/zone/bulk-delete', [ZoneController::class, 'bulk_delete'])->name('zone.bulk_delete');

        Route::get('/zone/trash', [ZoneController::class, 'trash'])->name('zone.trash');
        Route::get('/zone/{id}/restore', [ZoneController::class, 'restore'])->name('zone.restore');
        Route::delete('/zone/{id}/trash-delete', [ZoneController::class, 'trashDelete'])->name('zone.trashDelete');
        Route::post('/zone/trash/bulk_delete', [ZoneController::class, 'trash_bulk_delete'])->name('zone.trash_bulk_delete');
        /*--- ZoneController Code End ---*/

        /*--- BattleController Code Start ---*/
        Route::get('/battle', [BattleController::class, 'index'])->name('battle.index');
        Route::post('/battle', [BattleController::class, 'createOrUpdate'])->name('battle.createOrUpdate');
        /*--- BattleController Code End ---*/

        /*--- Newsltter Controller end--*/
        Route::get('/newsletter', [NewsLetterController::class, 'index'])->name('newsletter.index');
        Route::post('/newsletter', [NewsLetterController::class, 'store'])->name('newsletter.store');
        Route::get('/newsletter/{id}/edit', [NewsLetterController::class, 'edit'])->name('newsletter.edit');
        Route::put('/newsletter/{id}', [NewsLetterController::class, 'update'])->name('newsletter.update');
        Route::delete('/newsletter/{id}/delete', [NewsLetterController::class, 'destroy'])->name('newsletter.destroy');
        Route::post('/newsletter/bulk_delete', [NewsLetterController::class, 'bulk_delete'])->name('newsletter.bulk_delete');
        Route::get('/newsletter/trash', [NewsLetterController::class, 'trash'])->name('newsletter.trash');
        Route::get('/newsletter/{id}/restore', [NewsLetterController::class, 'restore'])->name('newsletter.restore');
        Route::delete('/newsletter/{id}/trash-delete', [NewsLetterController::class, 'trashDelete'])->name('newsletter.trashDelete');
        Route::post('/newsletter/trash/bulk_delete', [NewsLetterController::class, 'trash_bulk_delete'])->name('newsletter.trash_bulk_delete');
        Route::get('/reports/newsletter', [NewsLetterController::class, 'reports'])->name('newsletter.reports');
        /*--- Newsltter Controller end--*/


        Route::get('/post-category', [BlogController::class, 'post_category_index'])->name('post-category.index');

        // status update route
        Route::get('post-category/update-status', [BlogController::class, 'post_updateStatus']);

        //bulk_delete routes
        Route::post('/post-category/bulk_delete', [BlogController::class, 'post_categorybulk_delete'])->name('post-category.bulk_delete');


        /*---Blog Controller end--*/
        Route::get('/orders', [CheckoutController::class, 'orders_table'])->name('orders.admin');

        /*---Slider Controller start--*/
        Route::post('/slider', [SliderController::class, 'store'])->name('slider.store');
        Route::get('/slider', [SliderController::class, 'show'])->name('slider.show');
        Route::get('/slider/{id}/edit', [SliderController::class, 'edit'])->name('slider.edit');
        Route::put('/slider/{id}', [SliderController::class, 'update'])->name('slider.update');
        Route::delete('/slider/{id}/delete', [SliderController::class, 'destroy'])->name('slider.destroy');

        //bulk_delete routes
        Route::post('/slider/bulk_delete', [SliderController::class, 'bulk_delete'])->name('slider.bulk_delete');
        Route::post('/slider/trash/bulk_delete', [SliderController::class, 'trash_bulk_delete'])->name('slider.trash_bulk_delete');

        // status update route
        Route::get('slider/update-status', [SliderController::class, 'updateStatus']);

        // trash and restore routes
        Route::get('/slider/trash', [SliderController::class, 'trash'])->name('slider.trash');
        Route::get('/slider/{id}/restore', [SliderController::class, 'restore'])->name('slider.restore');
        Route::delete('/slider/{id}/trash-delete', [SliderController::class, 'trashDelete'])->name('slider.trashDelete');

        // drag and drop order routes
        Route::post('/slider/update-order', [SliderController::class, 'updateOrder']);

        /*---Slider Controller start--*/
        /*---Trusted Slider Controller start--*/
        Route::get('/trusted/slider', [TrustedsliderController::class, 'index'])->name('trusted.slider.index');
        Route::get('/trusted/slider/create', [TrustedsliderController::class, 'create'])->name('trusted.slider.create');
        Route::post('/trusted/slider', [TrustedsliderController::class, 'store'])->name('trusted.slider.store');
        Route::get('/trusted/slider/{id}/edit', [TrustedsliderController::class, 'edit'])->name('trusted.slider.edit');
        Route::put('/trusted/slider/{id}', [TrustedsliderController::class, 'update'])->name('trusted.slider.update');
        Route::delete('/trusted/slider/{id}/delete', [TrustedsliderController::class, 'destroy'])->name('trusted.slider.destroy');
        Route::post('/trusted/slider/update-order', [TrustedsliderController::class, 'updateOrder'])->name('trusted.update');

        /*--- Faq Controller Start ---*/
        Route::post('/faq', [FaqController::class, 'store'])->name('faq.store');
        Route::get('/faq', [FaqController::class, 'show'])->name('faq.show');
        Route::get('/faq/{id}/edit', [FaqController::class, 'edit'])->name('faq.edit');
        Route::put('/faq/{id}', [FaqController::class, 'update'])->name('faq.update');
        Route::delete('/faq/{id}/delete', [FaqController::class, 'destroy'])->name('faq.destroy');
        Route::get('/faq/{id}/copy', [FaqController::class, 'copy'])->name('faq.copy');

        // Bulk delete routes
        Route::post('/faq/bulk_delete', [FaqController::class, 'bulk_delete'])->name('faq.bulk_delete');
        Route::post('/faq/trash/bulk_delete', [FaqController::class, 'trash_bulk_delete'])->name('faq.trash_bulk_delete');

        // Status update route
        Route::get('/faq/update-status', [FaqController::class, 'updateStatus'])->name('faq.updateStatus');

        // Trash and restore routes
        Route::get('/faq/trash', [FaqController::class, 'trash'])->name('faq.trash');
        Route::get('/faq/{id}/restore', [FaqController::class, 'restore'])->name('faq.restore');
        Route::delete('/faq/{id}/trash-delete', [FaqController::class, 'trashDelete'])->name('faq.trashDelete');

        // Drag and drop order route
        Route::post('/faq/update-order', [FaqController::class, 'updateOrder'])->name('faq.update');
        /*--- Faq Controller End ---*/

        /*--- Pages Controller Start ---*/
        Route::post('/pages', [PagesController::class, 'store'])->name('pages.store');
        Route::get('/pages', [PagesController::class, 'show'])->name('pages.show');
        Route::get('/pages/{id}/edit', [PagesController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{id}', [PagesController::class, 'update'])->name('pages.update');
        Route::delete('/pages/{id}/delete', [PagesController::class, 'destroy'])->name('pages.destroy');
        Route::get('/pages/{id}/copy', [PagesController::class, 'copy'])->name('pages.copy');

        // Bulk delete routes
        Route::post('/pages/bulk_delete', [PagesController::class, 'bulk_delete'])->name('pages.bulk_delete');
        Route::post('/pages/trash/bulk_delete', [PagesController::class, 'trash_bulk_delete'])->name('pages.trash_bulk_delete');

        // Status update route
        Route::get('/pages/update-status', [PagesController::class, 'updateStatus'])->name('pages.updateStatus');

        // Trash and restore routes
        Route::get('/pages/trash', [PagesController::class, 'trash'])->name('pages.trash');
        Route::get('/pages/{id}/restore', [PagesController::class, 'restore'])->name('pages.restore');
        Route::delete('/pages/{id}/trash-delete', [PagesController::class, 'trashDelete'])->name('pages.trashDelete');

        // Drag and drop order route
        Route::post('/pages/update-order', [PagesController::class, 'updateOrder'])->name('pages.updateOrder');
        /*--- Pages Controller End ---*/


        /*--- Invoice Settings Controller Start ---*/
        Route::get('/invoice-settings', [InvoiceSettingsController::class, 'index'])->name('admin.invoice_settings');
        Route::put('/invoice-settings', [InvoiceSettingsController::class, 'update'])->name('admin.invoice_settings.update');
        /*--- Invoice Settings Controller End ---*/


        /*--- Coming Soon Controller Start ---*/
        Route::get('/coming-soon', [ComingSoonController::class, 'index'])->name('admin.coming_soon');
        Route::put('/coming-soon', [ComingSoonController::class, 'update'])->name('admin.coming_soon.update');
        /*--- Coming Soon Controller End ---*/


        /*---Users Controller end--*/

Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
Route::post('/users', [UsersController::class, 'store'])->name('users.store');
Route::get('/users', [UsersController::class, 'show'])->name('users.show');
Route::get('get/state/country', [UsersController::class, 'get_state_country'])->name('get.state.country');
Route::get('/users/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');
Route::get('users/data', [UsersController::class, 'getUsersData'])->name('users.data');
Route::put('/users/{id}', [UsersController::class, 'update'])->name('users.update');
Route::get('services', [ServiceController::class, 'index'])->name('services.index');
Route::post('services', [ServiceController::class, 'store'])->name('services.store');
Route::get('services/{id}/edit', [ServiceController::class, 'edit'])->name('services.edit');
Route::put('services/{id}', [ServiceController::class, 'update'])->name('services.update');
Route::delete('services/{id}/delete', [ServiceController::class, 'destroy'])->name('services.destroy');
Route::post('/services/bulk_delete', [ServiceController::class, 'bulk_delete'])->name('services.bulk_delete');
Route::get('services/update-status', [ServiceController::class, 'updateStatus']);

// status update route
Route::get('users/update-status', [UsersController::class, 'updateStatus']);
Route::delete('/users/{id}/delete', [UsersController::class, 'destroy'])->name('users.destroy');

// bulk_delete routes
Route::post('/users/bulk_delete', [UsersController::class, 'bulk_delete'])->name('users.bulk_delete');
Route::post('/users/trash/bulk_delete', [UsersController::class, 'trash_bulk_delete'])->name('users.trash_bulk_delete');

// import routes
Route::get('/users/import', [UsersController::class, 'import'])->name('users.import');
Route::post('/users/import/save', [UsersController::class, 'importSave'])->name('users.importSave');

// trash and restore routes
Route::get('/users/trash', [UsersController::class, 'trash'])->name('users.trash');
Route::get('/users/{id}/restore', [UsersController::class, 'restore'])->name('users.restore');
Route::delete('/users/{id}/trash-delete', [UsersController::class, 'trashDelete'])->name('users.trashDelete');

Route::get('userslogin/{id}', [UsersController::class, 'login'])->name('userslogin');
/*---Users Controller end--*/

/*---Role And Permission Controller start--*/

Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
Route::get('/roles', [RoleController::class, 'show'])->name('roles.show');
Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
Route::delete('/roles/{id}/delete', [RoleController::class, 'destroy'])->name('roles.destroy');
Route::post('/roles/bulk-delete', [RoleController::class, 'bulk_delete'])->name('roles.bulk_delete');

// PermissionController routes
Route::get('/permission/', [PermissionController::class, 'create'])->name('permission.create');
Route::post('/permission', [PermissionController::class, 'store'])->name('permission.store');

/*---Role And Permission Controller end--*/

/*---General Controller start--*/
Route::get('/general-setting', [GeneralSettingController::class, 'show'])->name('general-setting.show');
Route::post('/general-setting', [GeneralSettingController::class, 'store'])->name('general-setting.store');
/*---General Controller end--*/

/*---Reason Controller start--*/
Route::get('/reasons', [ReasonController::class, 'index'])->name('reason.show');
Route::post('/reasons', [ReasonController::class, 'store'])->name('reason.store');
Route::get('/reasons/{id}/edit', [ReasonController::class, 'edit'])->name('reason.edit');
Route::put('/reasons/{id}', [ReasonController::class, 'update'])->name('reason.update');
Route::post('/reasons/status/{id}', [ReasonController::class, 'updateStatus'])->name('update.status');
Route::delete('/reasons/{id}/delete', [ReasonController::class, 'destroy'])->name('reason.destroy');
Route::post('/reasons/bulk-delete', [ReasonController::class, 'bulk_delete'])->name('reason.bulk_delete');
Route::get('/reasons/trash', [ReasonController::class, 'trash'])->name('reason.trash');
Route::get('/reasons/{id}/restore', [ReasonController::class, 'restore'])->name('reason.restore');
Route::delete('/reasons/{id}/trash-delete', [ReasonController::class, 'trashDelete'])->name('reason.trashDelete');
Route::post('/reasons/trash/bulk_delete', [ReasonController::class, 'trash_bulk_delete'])->name('reason.trash_bulk_delete');
/*---Reason Controller end--*/

/*---mail Controller start--*/
Route::get('/mail-setting', [MailSettingController::class, 'show'])->name('mail-setting.show');
Route::post('/mail-setting', [MailSettingController::class, 'store'])->name('mail-setting.store');
Route::match(['get', 'post'], '/send-email', [MailSettingController::class, 'sendEmail'])->name('testsend.email');

Route::post('/social/login/setting/update', [SettingController::class, 'update'])->name('sociallogin.update');


       // FooterSettingController
Route::get('/footer-setting', [FooterSettingController::class, 'show'])->name('footer.show');
Route::post('/footer-setting', [FooterSettingController::class, 'store'])->name('footer.store');

// CustomSettingController
Route::get('/custom-setting', [CustomSettingController::class, 'index'])->name('custom-setting.index');
Route::post('/custom-setting/css', [CustomSettingController::class, 'updateCodeCss'])->name('custom-code-css.store');
Route::post('/custom-setting/js', [CustomSettingController::class, 'updateCodeJs'])->name('custom-code-js.store');

// SocialChatController
Route::get('/chat-setting', [SocialChatController::class, 'show'])->name('chat.show');
Route::post('/chat-setting', [SocialChatController::class, 'store'])->name('chat.store');

// PWASettingController
Route::get('/pwa-setting', [PWASettingController::class, 'show'])->name('pwa.show');
Route::post('/pwa-setting', [PWASettingController::class, 'store'])->name('pwa.store');

// LanguageSettingController
Route::get('/language', [LanguageSettingController::class, 'show'])->name('language.show');
Route::post('/language', [LanguageSettingController::class, 'store'])->name('language.store');
Route::get('/language/{id}/edit', [LanguageSettingController::class, 'edit'])->name('language.edit');
Route::put('/language/{id}', [LanguageSettingController::class, 'update'])->name('language.update');
Route::delete('/language/{id}/delete', [LanguageSettingController::class, 'destroy'])->name('language.destroy');
Route::get('language/update-status', [LanguageSettingController::class, 'updateStatus']);
Route::post('/language/bulk_delete', [LanguageSettingController::class, 'bulk_delete'])->name('language.bulk_delete');
Route::get('/language/{local}', [LanguageSettingController::class, 'languageSwitch'])->name('languageSwitch');
Route::get('/language/switch/{local}/{image?}', [LanguageSettingController::class, 'switchLanguage'])->name('languageSwitch');

// PaymentController
Route::get('/payment-gateway', [PaymentController::class, 'index'])->name('payment_gateway.index');
Route::post('stripe/payment-gateway', [PaymentController::class, 'stripe_store'])->name('payment_gateway.stripe_store');
Route::post('paypal/payment-gateway', [PaymentController::class, 'paypal_store'])->name('payment_gateway.paypal_store');
Route::post('instamojo/payment-gateway', [PaymentController::class, 'instamojo_store'])->name('payment_gateway.instamojo_store');
Route::post('razorpay/payment-gateway', [PaymentController::class, 'razorpay_store'])->name('payment_gateway.razorpay_store');
Route::post('paystack/payment-gateway', [PaymentController::class, 'paystack_store'])->name('payment_gateway.paystack_store');
Route::post('paytm/payment-gateway', [PaymentController::class, 'paytm_store'])->name('payment_gateway.paytm_store');
Route::post('omise/payment-gateway', [PaymentController::class, 'omise_store'])->name('payment_gateway.omise_store');
Route::post('payu/payment-gateway', [PaymentController::class, 'payu_store'])->name('payment_gateway.payu_store');
Route::post('mollie/payment-gateway', [PaymentController::class, 'mollie_store'])->name('payment_gateway.mollie_store');
Route::post('cashfree/payment-gateway', [PaymentController::class, 'cashfree_store'])->name('payment_gateway.cashfree_store');
Route::post('skrill/payment-gateway', [PaymentController::class, 'skrill_store'])->name('payment_gateway.skrill_store');
Route::post('rave/payment-gateway', [PaymentController::class, 'rave_store'])->name('payment_gateway.rave_store');
Route::post('payhere/payment-gateway', [PaymentController::class, 'payhere_store'])->name('payment_gateway.payhere_store');
Route::post('iyzico/payment-gateway', [PaymentController::class, 'iyzico_store'])->name('payment_gateway.iyzico_store');
Route::post('ssl/payment-gateway', [PaymentController::class, 'ssl_store'])->name('payment_gateway.ssl_store');
Route::post('aamarpay/payment-gateway', [PaymentController::class, 'aamarpay_store'])->name('payment_gateway.aamarpay_store');
Route::post('braintree/payment-gateway', [PaymentController::class, 'braintree_store'])->name('payment_gateway.braintree_store');
Route::post('payflexi/payment-gateway', [PaymentController::class, 'payflexi_store'])->name('payment_gateway.payflexi_store');
Route::post('esewa/payment-gateway', [PaymentController::class, 'esewa_store'])->name('payment_gateway.esewa_store');
Route::post('smanager/payment-gateway', [PaymentController::class, 'smanager_store'])->name('payment_gateway.smanager_store');
Route::post('paytabs/payment-gateway', [PaymentController::class, 'paytabs_store'])->name('payment_gateway.paytabs_store');
Route::post('dpo/payment-gateway', [PaymentController::class, 'dpo_store'])->name('payment_gateway.dpo_store');
Route::post('authorize/payment-gateway', [PaymentController::class, 'authorize_store'])->name('payment_gateway.authorize_store');
Route::post('bkash/payment-gateway', [PaymentController::class, 'bkash_store'])->name('payment_gateway.bkash_store');
Route::post('midtrans/payment-gateway', [PaymentController::class, 'midtrans_store'])->name('payment_gateway.midtrans_store');
Route::post('square/payment-gateway', [PaymentController::class, 'square_store'])->name('payment_gateway.square_store');
Route::post('worldpay/payment-gateway', [PaymentController::class, 'worldpay_store'])->name('payment_gateway.worldpay_store');
Route::post('onepay/payment-gateway', [PaymentController::class, 'onepay_store'])->name('payment_gateway.onepay_store');
// Route::post('/validate-password', [PaymentController::class, 'validatePassword'])->name('validate.password');
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/settings', [AdminSettingController::class, 'settingsPage'])->name('admin.settings');
    Route::post('/admin/show-stripe-keys', [AdminSettingController::class, 'showStripeKeys'])->name('admin.showStripeKeys');
    Route::post('/admin/settings/stripe', [AdminSettingController::class, 'stripeStore'])->name('admin.settings.stripe.store');    
    Route::post('/admin/paypal/show-keys', [AdminSettingController::class, 'showPaypalClientID'])->name('admin.showPaypalClientID');
    Route::post('/admin/settings/paypal', [AdminSettingController::class, 'paypalStore'])->name('admin.settings.paypal.store');    
    Route::post('/admin/razorpay/show-keys', [AdminSettingController::class, 'showRazorpayKeys'])->name('admin.showRazorpayKeys');
    Route::post('/admin/razorpay/store', [AdminSettingController::class, 'razorpayStore'])->name('payment_gateway.razorpay_store');
    Route::post('/admin/paystack/show-keys', [AdminSettingController::class, 'showPaystackKeys'])->name('admin.showPaystackKeys');
    Route::post('/admin/paystack/store', [AdminSettingController::class, 'paystackStore'])->name('payment_gateway.paystack_store');
    Route::post('/admin/paytm/show-keys', [AdminSettingController::class, 'showPaytmKeys'])->name('admin.showPaytmKeys');
    Route::post('/admin/paytm/store', [AdminSettingController::class, 'paytmStore'])->name('payment_gateway.paytm_store');
    Route::post('/admin/omise/show-keys', [AdminSettingController::class, 'showOmiseKeys'])->name('admin.showOmiseKeys');
    Route::post('/admin/omise/store', [AdminSettingController::class, 'omiseStore'])->name('payment_gateway.omise_store');
    Route::post('/admin/mollie/show-keys', [AdminSettingController::class, 'showMollieKeys'])->name('admin.showMollieKeys');
    Route::post('/admin/mollie/store', [AdminSettingController::class, 'mollieStore'])->name('payment_gateway.mollie_store');
    Route::post('/admin/rave/show-keys', [AdminSettingController::class, 'showRaveKeys'])->name('admin.showRaveKeys');
    Route::post('/admin/rave/store', [AdminSettingController::class, 'raveStore'])->name('payment_gateway.rave_store');
    Route::post('/admin/braintree/show-keys', [AdminSettingController::class, 'showBraintreeKeys'])->name('admin.showBraintreeKeys');
    Route::post('/admin/braintree/store', [AdminSettingController::class, 'braintreeStore'])->name('payment_gateway.braintree_store');
    Route::post('/admin/midtrans/show-keys', [AdminSettingController::class, 'showMidtransKeys'])->name('admin.showMidtransKeys');
    Route::post('/admin/midtrans/store', [AdminSettingController::class, 'midtransStore'])->name('payment_gateway.midtrans_store');
    Route::post('/admin/payment-settings/update', [AdminSettingController::class, 'updatePaymentSettings'])->name('admin.updatePaymentSettings');
});


        /*---Payment Controller end--*/

        /*---Setting Controller start--*/

    Route::controller(SettingController::class)->group(function () {
    Route::get('/login_signup', 'login_signup')->name('login_signup.index');
    Route::post('/login_signup', 'login_signupstore')->name('login_signup.store');

    Route::post('facebook/login_signup', 'slf')->name('facebook.store');
    Route::post('google/login_signup', 'slg')->name('google.store');
    Route::post('gitlab/login_signup', 'slgl')->name('gitlab.store');
    Route::post('amazon/login_signup', 'sla')->name('amazon.store');
    Route::post('linkedin/login_signup', 'slld')->name('linkedin.store');
    Route::post('twitter/login_signup', 'slt')->name('twitter.store');

    Route::get('/cockpit', 'cockpit')->name('cockpit.index');
    Route::post('/cockpit', 'cockpitstore')->name('cockpit.store');

    Route::get('/admin-color', 'admincolor')->name('admincolor.index');
    Route::post('/admin-color', 'admincolorstore')->name('admincolor.store');
    Route::get('/admin-color/reset', 'adminreset')->name('admincolor.reset');

    Route::get('/admin-setting', 'adminsetting')->name('adminsetting.index');
    Route::post('/admin-setting', 'adminsettingstore')->name('adminsetting.store');

    Route::get('/sitemap', 'sitemap')->name('sitemap.index');
    Route::match(['get', 'post'], '/generate-sitemap', 'generateSitemap')->name('generate-sitemap');
    Route::match(['get', 'post'], '/download-sitemap', 'downloadSitemap')->name('download-sitemap');
});

Route::controller(ChatgptController::class)->group(function () {
    Route::post('/openai/text', 'text');
    Route::post('/openai/image', 'image');
    Route::get('/openai', 'useropenai')->name('openai');
    Route::post('openai-bulk-delete', 'bulk_delete')->name('openai.bulk.delete');
    Route::delete('openai/delete/{id}', 'delete')->name('openai.delete');
});

Route::controller(ApiSettingController::class)->group(function () {
    Route::get('/api-setting', 'apisetting')->name('twilio.index');
    Route::post('adsense/api-setting', 'adsensestore')->name('adsense.store');
    Route::post('analytics/api-setting', 'analyticsstore')->name('analytics.store');
    Route::post('recaptcha/api-setting', 'recaptcha')->name('recaptcha.store');
    Route::post('aws/api-setting', 'aws')->name('aws.store');
    Route::post('youtube/api-setting', 'youtube')->name('youtube.store');
    Route::post('vimeo/api-setting', 'vimeo')->name('vimeo.store');
    Route::post('gtm/api-setting', 'gtm')->name('gtm.store');
    Route::post('mailchip/api-setting', 'mailchipstore')->name('mailchip.store');
    Route::post('facebook/api-setting', 'facebookstore')->name('facebook.store');
    Route::post('openapi/api-setting', 'openapikey')->name('openapikey.store');
});

Route::controller(SupportController::class)->group(function () {
    Route::get('/import-demo', 'importdemo')->name('import_demo.index');
    Route::get('/database-backup', 'databaseBackup')->name('databasebackup.index');
    Route::get('/remove-public', 'removepublic')->name('removepublic.index');
});

Route::controller(CouponController::class)->group(function () {
    Route::get('/coupon', 'show')->name('coupon.show');
    Route::post('/coupon', 'store')->name('coupon.store');
    Route::get('/coupon/{id}/edit', 'edit')->name('coupon.edit');
    Route::put('/coupon/{id}', 'update')->name('coupon.update');
    Route::delete('/coupon/{id}/delete', 'destroy')->name('coupon.destroy');
    Route::post('/coupon/bulk_delete', 'bulk_delete')->name('coupon.bulk_delete');
});


        /*---Coupon Controller end--*/

        /*---Advertisement Controller start--*/
       Route::prefix('admin')->group(function () {
    Route::get('/advertisement', [AdvertisementController::class, 'show'])->name('advertisement.show');
    Route::post('/advertisement', [AdvertisementController::class, 'store'])->name('advertisement.store');
    Route::get('/advertisement/{id}/edit', [AdvertisementController::class, 'edit'])->name('advertisement.edit');
    Route::put('/advertisement/{id}', [AdvertisementController::class, 'update'])->name('advertisement.update');
    Route::delete('/advertisement/{id}', [AdvertisementController::class, 'destroy'])->name('advertisement.destroy');
    Route::post('/advertisement/bulk_delete', [AdvertisementController::class, 'bulk_delete'])->name('advertisement.bulk_delete');
});

Route::get('/currency', [CurrencyController::class, 'show'])->name('currency.show');
Route::post('/currency', [CurrencyController::class, 'store'])->name('currency.store');
Route::post('/currency/exchange', [CurrencyController::class, 'exchangestore'])->name('exchange.store');
Route::delete('/currency/{id}/delete', [CurrencyController::class, 'destroy'])->name('currency.destroy');
Route::put('/currency/{id}', [CurrencyController::class, 'update'])->name('currency.update');
Route::get('currency/update-status', [CurrencyController::class, 'updateStatus']);
Route::get('/currency/{symbol}', [CurrencyController::class, 'currencySwitch'])->name('currencySwitch');
Route::post('currency/update-currency', [CurrencyController::class, 'update_currency'])->name('update_currency');

Route::get('/packages-features', [PackagesFeaturesController::class, 'show'])->name('packages_features.show');
Route::post('/packages-features', [PackagesFeaturesController::class, 'store'])->name('packages_features.store');
Route::get('/packages-features/{id}/edit', [PackagesFeaturesController::class, 'edit'])->name('packages_features.edit');
Route::put('/packages-features/{id}', [PackagesFeaturesController::class, 'update'])->name('packages_features.update');
Route::delete('/packages-features/{id}/delete', [PackagesFeaturesController::class, 'destroy'])->name('packages_features.destroy');
Route::post('/packages-features/bulk_delete', [PackagesFeaturesController::class, 'bulk_delete'])->name('packages_features.bulk_delete');

Route::get('/packages', [PackagesController::class, 'show'])->name('packages.show');
Route::post('/packages', [PackagesController::class, 'store'])->name('packages.store');
Route::get('/packages/{id}/edit', [PackagesController::class, 'edit'])->name('packages.edit');
Route::put('/packages/{id}', [PackagesController::class, 'update'])->name('packages.update');
Route::delete('/packages/{id}/delete', [PackagesController::class, 'destroy'])->name('packages.destroy');
Route::post('/packages/bulk_delete', [PackagesController::class, 'bulk_delete'])->name('packages.bulk_delete');
Route::get('packages/update-status', [PackagesController::class, 'updateStatus']);

Route::get('/country', [CountryController::class, 'show'])->name('country.show');
Route::post('/country', [CountryController::class, 'store'])->name('country.store');
Route::get('/country/{id}/edit', [CountryController::class, 'edit'])->name('country.edit');
Route::put('/country/{id}', [CountryController::class, 'update'])->name('country.update');
Route::delete('/country/{id}/delete', [CountryController::class, 'destroy'])->name('country.destroy');
Route::post('/country/bulk_delete', [CountryController::class, 'bulk_delete'])->name('country.bulk_delete');

Route::get('/state', [StateController::class, 'show'])->name('state.show');
Route::post('/state', [StateController::class, 'store'])->name('state.store');
Route::post('manual/state', [StateController::class, 'addstate'])->name('state.manual');
Route::get('/state/{id}/edit', [StateController::class, 'edit'])->name('state.edit');
Route::put('/state/{id}', [StateController::class, 'update'])->name('state.update');
Route::delete('/state/{id}/delete', [StateController::class, 'destroy'])->name('state.destroy');
Route::post('/state/bulk_delete', [StateController::class, 'bulk_delete'])->name('state.bulk_delete');

Route::get('/cities', [CitiesController::class, 'show'])->name('cities.show');
Route::post('/cities', [CitiesController::class, 'store'])->name('cities.store');
Route::post('manual/cities', [CitiesController::class, 'addcity'])->name('cities.manual');
Route::get('/cities/{id}/edit', [CitiesController::class, 'edit'])->name('cities.edit');
Route::put('/cities/{id}', [CitiesController::class, 'update'])->name('cities.update');
Route::delete('/cities/{id}/delete', [CitiesController::class, 'destroy'])->name('cities.destroy');
Route::post('/cities/bulk_delete', [CitiesController::class, 'bulk_delete'])->name('cities.bulk_delete');
Route::get('cities-data', [CitiesController::class, 'getCitiesData'])->name('getCitiesData');

Route::get('/affiliate', [AffiliateController::class, 'index'])->name('admin.affiliate');
Route::post('affiliates', [AffiliateController::class, 'update'])->name('affiliates.update');
Route::get('affiliate/link', [AffiliateController::class, 'getlink'])->name('admin.affiliate.link');
Route::post('generate/affilates/link', [AffiliateController::class, 'generatelink'])->name('generate.affiliate');
Route::get('/reports/affiliate', [AffiliateController::class, 'history'])->name('admin.affiliate.reports');
Route::get('/report/affiliate', [AffiliateController::class, 'history'])->name('admin.report.affiliate.reports');
Route::get('payment/request', [AffiliateController::class, 'payment_request'])->name('payment.request');
Route::get('payment/request/create', [AffiliateController::class, 'payment_request_create'])->name('payment.request.create');
Route::post('payment/request/store', [AffiliateController::class, 'payment_request_store'])->name('payment.request.store');
Route::get('payments/{id}', [AffiliateController::class, 'payment_edit'])->name('pay');
Route::post('payment/request/update', [AffiliateController::class, 'payment_request_update'])->name('payment.request.update');


        /*--- AffiliateController Code End --*/

        /*--- ContactController Code Start --*/
// SettingController
Route::get('/login_signup', [SettingController::class, 'login_signup'])->name('login_signup.index');
Route::post('/login_signup', [SettingController::class, 'login_signupstore'])->name('login_signup.store');

Route::post('facebook/login_signup', [SettingController::class, 'slf'])->name('facebook.store');
Route::post('google/login_signup', [SettingController::class, 'slg'])->name('google.store');
Route::post('gitlab/login_signup', [SettingController::class, 'slgl'])->name('gitlab.store');
Route::post('amazon/login_signup', [SettingController::class, 'sla'])->name('amazon.store');
Route::post('linkedin/login_signup', [SettingController::class, 'slld'])->name('linkedin.store');
Route::post('twitter/login_signup', [SettingController::class, 'slt'])->name('twitter.store');

Route::get('/cockpit', [SettingController::class, 'cockpit'])->name('cockpit.index');
Route::post('/cockpit', [SettingController::class, 'cockpitstore'])->name('cockpit.store');
Route::get('/admin-color', [SettingController::class, 'admincolor'])->name('admincolor.index');
Route::post('/admin-color', [SettingController::class, 'admincolorstore'])->name('admincolor.store');
Route::get('/admin-color/reset', [SettingController::class, 'adminreset'])->name('admincolor.reset');

// ChatgptController
Route::post('/openai/text', [ChatgptController::class, 'text']);
Route::post('/openai/image', [ChatgptController::class, 'image']);
Route::get('/openai', [ChatgptController::class, 'useropenai'])->name('openai');
Route::post('openai-bulk-delete', [ChatgptController::class, 'bulk_delete'])->name('openai.bulk.delete');
Route::delete('openai/delete/{id}', [ChatgptController::class, 'delete'])->name('openai.delete');

// SettingController (continued)
Route::get('/admin-setting', [SettingController::class, 'adminsetting'])->name('adminsetting.index');
Route::post('/admin-setting', [SettingController::class, 'adminsettingstore'])->name('adminsetting.store');
Route::get('/sitemap', [SettingController::class, 'sitemap'])->name('sitemap.index');
Route::match(['get', 'post'], '/generate-sitemap', [SettingController::class, 'generateSitemap'])->name('generate-sitemap');
Route::match(['get', 'post'], '/download-sitemap', [SettingController::class, 'downloadSitemap'])->name('download-sitemap');

// ApiSettingController
Route::get('/api-setting', [ApiSettingController::class, 'apisetting'])->name('twilio.index');
Route::post('adsense/api-setting', [ApiSettingController::class, 'adsensestore'])->name('adsense.store');
Route::post('analytics/api-setting', [ApiSettingController::class, 'analyticsstore'])->name('analytics.store');
Route::post('recaptcha/api-setting', [ApiSettingController::class, 'recaptcha'])->name('recaptcha.store');
Route::post('aws/api-setting', [ApiSettingController::class, 'aws'])->name('aws.store');
Route::post('youtube/api-setting', [ApiSettingController::class, 'youtube'])->name('youtube.store');
Route::post('vimeo/api-setting', [ApiSettingController::class, 'vimeo'])->name('vimeo.store');
Route::post('gtm/api-setting', [ApiSettingController::class, 'gtm'])->name('gtm.store');
Route::post('mailchip/api-setting', [ApiSettingController::class, 'mailchipstore'])->name('mailchip.store');
Route::post('facebook/api-setting', [ApiSettingController::class, 'facebookstore'])->name('facebook.store');
Route::post('openapi/api-setting', [ApiSettingController::class, 'openapikey'])->name('openapikey.store');

// SupportController
Route::get('/import-demo', [SupportController::class, 'importdemo'])->name('import_demo.index');
Route::get('/database-backup', [SupportController::class, 'databaseBackup'])->name('databasebackup.index');
Route::get('/remove-public', [SupportController::class, 'removepublic'])->name('removepublic.index');

// CouponController
Route::get('/coupon', [CouponController::class, 'show'])->name('coupon.show');
Route::post('/coupon', [CouponController::class, 'store'])->name('coupon.store');
Route::get('/coupon/{id}/edit', [CouponController::class, 'edit'])->name('coupon.edit');
Route::put('/coupon/{id}', [CouponController::class, 'update'])->name('coupon.update');
Route::delete('/coupon/{id}/delete', [CouponController::class, 'destroy'])->name('coupon.destroy');
Route::post('/coupon/bulk_delete', [CouponController::class, 'bulk_delete'])->name('coupon.bulk_delete');

// ContactController
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::delete('/contact/{id}/delete', [ContactController::class, 'destroy'])->name('contacts.destroy');
Route::post('/contact/bulk_delete', [ContactController::class, 'bulk_delete'])->name('contact.bulk_delete');

// SeoSettingController
Route::get('/seo_setting', [SeoSettingController::class, 'index'])->name('admin.seo_setting');
Route::post('/seo_setting', [SeoSettingController::class, 'update'])->name('seo_setting.update');

// SMSController
Route::middleware(['auth'])->group(function () {
Route::get('/sms-setting', [SMSController::class, 'index'])->name('sms.index');
Route::post('twilio/sms-setting', [SMSController::class, 'twiliostore'])->name('twilio.store');
Route::post('/verify-password', [App\Http\Controllers\SMSController::class, 'verifyPassword'])->name('verify.password');
Route::post('msg/sms-setting', [SMSController::class, 'msgstore'])->name('msg.store');
Route::post('clicktail/sms-setting', [SMSController::class, 'clicktailstore'])->name('clicktail.store');
Route::post('bulksms/sms-setting', [SMSController::class, 'bulksmsstore'])->name('bulksms.store');
Route::post('exabytes/sms-setting', [SMSController::class, 'exabytesstore'])->name('exabytes.store');
Route::post('mimsms/sms-setting', [SMSController::class, 'mimsmsstore'])->name('mimsms.store');
});

// ActivityLogController
Route::get('/activity_log', [ActivityLogController::class, 'index']);

// ContactController
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::delete('/contact/{id}/delete', [ContactController::class, 'destroy'])->name('contacts.destroy');
Route::post('/contact/bulk_delete', [ContactController::class, 'bulk_delete'])->name('contact.bulk_delete');

// SeoSettingController
Route::get('/seo_setting', [SeoSettingController::class, 'index'])->name('admin.seo_setting');
Route::post('/seo_setting', [SeoSettingController::class, 'update'])->name('seo_setting.update');

// ActivityLogController
Route::get('/activity_log', [ActivityLogController::class, 'index']);

Route::prefix('category')->name('category.')->group(function () {    
    Route::get('/', [CategorieController::class, 'index'])->name('index');
    Route::post('/', [CategorieController::class, 'store'])->name('store');
    Route::get('/import', [CategorieController::class, 'import'])->name('import');
    Route::post('/import/save', [CategorieController::class, 'importSave'])->name('importSave');
    Route::get('/export', [CategorieController::class, 'exportCategories'])->name('export');
    Route::get('/{id}/edit', [CategorieController::class, 'editCategory'])->name('edit');
    Route::put('/{id}', [CategorieController::class, 'updateCategory'])->name('update');
    Route::delete('/{id}/delete', [CategorieController::class, 'deleteCategory'])->name('destroy');
    Route::post('/bulk-delete', [CategorieController::class, 'bulk_delete'])->name('bulk_delete');
    Route::get('/category-update-status', [CategorieController::class, 'categoryStatus']);
    Route::get('/subcategory-update-status', [CategorieController::class, 'subcategoryStatus']);
    Route::get('/childcategory-update-status', [CategorieController::class, 'childcategoryStatus']);
});


Route::prefix('subcategory')->name('subcategory.')->group(function () {
    Route::any('/{id}/edit', [CategorieController::class, 'editSubCategory'])->name('edit');
    Route::delete('/{id}/delete', [CategorieController::class, 'deleteSubCategory'])->name('destroy');
    Route::post('/bulk_delete', [CategorieController::class, 'subcategory_bulk_delete'])->name('bulk_delete');
});

Route::prefix('childcategory')->name('childcategory.')->group(function () {
    Route::any('/{id}/edit', [CategorieController::class, 'editChildCategory'])->name('edit');
    Route::put('/{id}/delete', [CategorieController::class, 'deleteChildCategory'])->name('destroy');
    Route::post('/bulk_delete', [CategorieController::class, 'childcategory_bulk_delete'])->name('bulk_delete');
});

// SupportController
Route::get('/support_type', [SupportController::class, 'SupportType'])->name('support_type.index');
Route::post('/support_type', [SupportController::class, 'store'])->name('support_type.store');
Route::any('/support_type/{id}/edit', [SupportController::class, 'SupportTypeEdit'])->name('support_type.edit');
Route::put('/support_type/{id}', [SupportController::class, 'SupportTypeUpdate'])->name('support_type.update');
Route::delete('/support_type/{id}/delete', [SupportController::class, 'SupportTypedestroy'])->name('support_type.destroy');
Route::post('/support_type/bulk_delete', [SupportController::class, 'SupportTypebulk_delete'])->name('support_type.bulk_delete');

Route::get('/support_admin', [SupportController::class, 'index'])->name('support_admin.index');
Route::put('/support_reply/{id}', [SupportController::class, 'SupportReply'])->name('support_reply.update');
Route::delete('/support_admin/{id}/delete', [SupportController::class, 'destroy'])->name('support_admin.destroy');
Route::post('/support_admin/bulk_delete', [SupportController::class, 'bulk_delete'])->name('support_admin.bulk_delete');

// Support Issue Users
Route::get('/support', [SupportController::class, 'Support'])->name('support_users.index');
Route::post('/support_users/create', [SupportController::class, 'create'])->name('support_users.store');
Route::any('/support_users/{id}/edit', [SupportController::class, 'SupportIssueEdit'])->name('support_users.edit');
Route::put('/support_users/{id}', [SupportController::class, 'SupportIssueUpdate'])->name('support_users.update');
Route::delete('/support_users/{id}/delete', [SupportController::class, 'destroy'])->name('support_users.destroy');
Route::post('/support_users/bulk_delete', [SupportController::class, 'bulk_delete'])->name('support_users.bulk_delete');

// DatabaseController
Route::get('/import-demo', [DatabaseController::class, 'importdemo'])->name('import_demo.index');
Route::match(['get', 'post'], '/import-demo/store', [DatabaseController::class, 'importdatabase'])->name('import.database');
Route::match(['get', 'post'], '/import/reset', [DatabaseController::class, 'resetdatabase'])->name('reset.database');

Route::get('/database-backup', [DatabaseController::class, 'databaseBackup'])->name('databasebackup.index');
Route::post('/database-backup', [DatabaseController::class, 'databaseupdate'])->name('databaseupdate');
Route::get('database/genrate', [DatabaseController::class, 'genrate'])->name('database.genrate');
Route::get('database/download/{filename}', [DatabaseController::class, 'download'])->name('database.download');

Route::get('/remove-public', [DatabaseController::class, 'removepublic'])->name('removepublic.index');
Route::post('/remove-public', [DatabaseController::class, 'addcontent'])->name('removepublic.add');
Route::post('/remove-public/create', [DatabaseController::class, 'createfile'])->name('removepublic.create');

// ManulPaymentController
Route::get('/manual_payment', [ManulPaymentController::class, 'index'])->name('manual.show');
Route::get('/manual_payment/create', [ManulPaymentController::class, 'create'])->name('manual.create');
Route::post('/manual_payment/store', [ManulPaymentController::class, 'store'])->name('manual.store');
Route::get('/manual_payment/{id}/edit', [ManulPaymentController::class, 'edit'])->name('manual.edit');
Route::put('/manual_payment/{id}/update', [ManulPaymentController::class, 'update'])->name('manual.update');
Route::get('/manual-payment/update-status', [ManulPaymentController::class, 'updatestatus']);
Route::delete('/manual-payment/{id}/delete', [ManulPaymentController::class, 'destroy'])->name('manual.delete');
Route::post('/manual-payment/delete', [ManulPaymentController::class, 'bulk_delete'])->name('manual.bulk_delete');

// TeamMembersController
Route::get('/team-members', [TeamMembersController::class, 'show'])->name('members.show');
Route::get('/team-members/create', [TeamMembersController::class, 'create'])->name('members.create');
Route::post('/team-members', [TeamMembersController::class, 'store'])->name('members.store');
Route::get('/team-members/{id}/edit', [TeamMembersController::class, 'edit'])->name('members.edit');
Route::put('/team-members/{id}', [TeamMembersController::class, 'update'])->name('members.update');
Route::delete('/team-members/{id}/delete', [TeamMembersController::class, 'destroy'])->name('members.destroy');
Route::post('/team-members/bulk_delete', [TeamMembersController::class, 'bulk_delete'])->name('members.bulk_delete');

// TwoFactorAuthController
Route::get('two-factor/auth', [TwoFactorAuthController::class, 'show2faForm'])->name('2fa.index');
Route::post('two-factor/auth', [TwoFactorAuthController::class, 'generate2faSecret'])->name('generate.2fa.secret');
Route::post('two-factor/auth/enable', [TwoFactorAuthController::class, 'enable2fa'])->name('2fa.enable');
Route::post('two-factor/auth/disable', [TwoFactorAuthController::class, 'disable2fa'])->name('2fa.disable');

// SettingController - Social Login
Route::post('/update-google-login', [SettingController::class, 'updateGoogleLogin'])->name('update.google.login');
Route::post('/update-facebook-login', [SettingController::class, 'updateFacebookLogin'])->name('update.facebook.login');
Route::post('/update-gitlab-login', [SettingController::class, 'updateGitlabLogin'])->name('update.gitlab.login');
Route::post('/update-linkedin-login', [SettingController::class, 'updateLinkedinLogin'])->name('update.linkedin.login');
Route::post('/update-github-login', [SettingController::class, 'updateGithubLogin'])->name('update.github.login');
Route::post('/update-amazon-login', [SettingController::class, 'updateAmazonLogin'])->name('update.amazon.login');

// AuthController
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/admin/post-category', [BlogCategoryController::class, 'index'])->name('post-category.index');
Route::get('/test-captcha', function () {
    return \Anhskohbo\NoCaptcha\Facades\NoCaptcha::renderJs();
});