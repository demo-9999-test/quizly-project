<!DOCTYPE html>
<html lang="en">
<!-- <![endif]-->
<!-- head -->

<head>
    <meta charset="utf-8" />
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Media City" />
    <meta name="MobileOptimized" content="320" />
    <!-- theme styles -->
    <link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- bootstrap css -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"><!-- google fonts -->
    <!-- <link href="{{ url('admin_theme/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css" /> -->
    @php
    $signuplogin = \App\Models\Setting::first();
    $setting = \App\Models\GeneralSetting::first();
    $sett = \App\Models\ApiSetting::first();
    $socialSettings = \App\Models\SocialSetting::first();
    @endphp
    @if(isset($setting->favicon_logo) && !empty($setting->favicon_logo))<link rel="icon" type="image/icon" href="{{ asset('images/favicon/' .$setting->favicon_logo) }}">@endif <!-- favicon -->
    <!-- fontawesome css -->
    <link type="text/css" href="{{ url('assets/fonts/flaticon_quizzly_admin.css') }}" rel="stylesheet">
    <!-- fonts css -->
    <link href="{{ url('admin_theme/assets/css/style.css') }}" rel="stylesheet" type="text/css" /> <!-- custom css -->
    <!-- custom css -->
    <!-- end theme styles -->
    @if(env('PWA_ENABLE') == 1)
 @laravelPWA
@endif

    {!! NoCaptcha::renderJs() !!}
</head>

<body>
    <!-- Start Login -->

    <div id="login-page" class="login-main-block">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="login-block">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="logo">
                                    <img src="{{ asset('images/logo/' . $setting->logo) }}" alt="{{ __('logo') }}" class="img-fluid" id="logo">
                                </div>
                                <h4 class="container-heading"> {{ __('Welcome Back') }}</h4>
                                <h6 class="login-heading">{{ __('Sign in to continue') }}</h6>
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                @if (session('success'))
                                <h6 class="alert alert-success">{{ session('success') }}</h6>
                                @elseif (session('error'))
                                <h6 class="alert alert-danger">{{ session('error') }}</h6>
                                @endif
                                <form action="{{ route('login.check') }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="" class="form-label mb-1">{{ __('Email') }}<span
                                                class="required">*</span></label>
                                        <input class="form-control email" type="email" placeholder="{{ __('Email') }}" aria-label=""
                                            name="email" required id="email">
                                        <div class="form-control-icon"><i class="flaticon-email"></i></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="password" class="form-label mb-1">{{ __('Password') }}<span class="required">*</span></label>
                                        <input id="password" class="form-control" type="password" placeholder="{{ __('Password') }}" aria-label="password" name="password" required>
                                        <i class="eye flaticon-hide"></i>
                                        <div class="form-control-icon"><i class="flaticon-password"></i></div>
                                    </div>
                                   @if($sett->recaptcha_status == 1)
                                        <div class="g-recaptcha mb-3"
                                            data-sitekey="{{ config('captcha.sitekey') }}"
                                            data-callback='onSubmit'
                                            data-action='Sign In'>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group form-group-checkbox">
                                                <input type="checkbox" class="form-check-input" id="remember" name="remember_me">
                                                <label for="remember"> {{ __('Remember Me') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="forgot-pass">
                                                <a href="{{ url('forget-password') }}" title=" Forgot Password"> {{__('Forgot
                                                    Password ?') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="login-options">
                                        <button type="submit" class="btn btn-primary w-100 mb-3" title="Sign In">{{ __('Sign In') }}</button>
                                    </div>

                                    <div class="social-login-options">
                                        <p class="text-center">{{ __('Or sign in with') }}</p>
                                        <div class="d-flex justify-content-center mt-2">
                                            @if($socialSettings->google_status)
                                                <a href="{{ route('social.login', 'google') }}" class="btn btn-outline-primary mx-1 social-login-btn" title="Google">
                                                    <img src="{{ url('admin_theme/assets/images/login/google.png') }}" alt="Google" class="img-fluid social-login-icon">
                                                </a>
                                            @endif

                                            @if($socialSettings->facebook_status)
                                                <a href="{{ route('social.login', 'facebook') }}" class="btn btn-outline-primary mx-1 social-login-btn" title="Facebook">
                                                    <img src="{{ url('admin_theme/assets/images/login/facebook.png') }}" alt="Facebook" class="img-fluid social-login-icon">
                                                </a>
                                            @endif

                                            @if($socialSettings->linkedin_status)
                                                <a href="{{ route('social.login', 'linkedin') }}" class="btn btn-outline-primary mx-1 social-login-btn" title="LinkedIn">
                                                    <img src="{{ url('admin_theme/assets/images/login/linkedin.png') }}" alt="LinkedIn" class="img-fluid social-login-icon">
                                                </a>
                                            @endif

                                            @if($socialSettings->github_status)
                                                <a href="{{ route('social.login', 'github') }}" class="btn btn-outline-primary mx-1 social-login-btn" title="GitHub">
                                                    <img src="{{ url('admin_theme/assets/images/login/github.png') }}" alt="GitHub" class="img-fluid social-login-icon">
                                                </a>
                                            @endif

                                            @if($socialSettings->gitlab_status)
                                                <a href="{{ route('social.login', 'gitlab') }}" class="btn btn-outline-primary mx-1 social-login-btn" title="GitLab">
                                                    <img src="{{ url('admin_theme/assets/images/login/gitlab.png') }}" alt="GitLab" class="img-fluid social-login-icon">
                                                </a>
                                            @endif

                                            @if($socialSettings->amazon_status)
                                                <a href="{{ route('social.login', 'amazon') }}" class="btn btn-outline-primary mx-1 social-login-btn" title="Amazon">
                                                    <img src="{{ url('admin_theme/assets/images/login/amazon.png') }}" alt="Amazon" class="img-fluid social-login-icon">
                                                </a>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="or-line">
                                        <span>Or</span>
                                    </div>
                                    <div class="login-options">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-6">
                                                <div class="social-link">
                                                    <a href="javascript:void(0)" title="{{ __('Admin') }}" class="btn btn-primary" onclick="switchUserType('admin')">{{
                                                        __('Admin') }}</a>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-6">
                                                <div class="social-link">
                                                    <a href="javascript:void(0)" title="{{ __('User') }}" class="btn btn-primary" onclick="switchUserType('user')">{{
                                                        __('User') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>

                                <div class="sign-up"> {{ __('Dont have an account ?') }} <a href="{{ url('register') }}"
                                        title="Sign Up"> {{ __('Sign up') }}
                                    </a></div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="login-img">
                                    <img src="{{ asset('/images/login_img/' . $signuplogin->login_img) }}"
                                        alt="{{ __('login Image') }}img" class="img-fluid">
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Login -->


    <!-- jquery -->
    <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script> <!-- bootstrap js -->
    <script src="{{ asset('admin_theme/assets/js/login.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    {!! NoCaptcha::renderJs() !!}
</body>
<!-- body end -->

</html>
