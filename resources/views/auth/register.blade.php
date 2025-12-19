<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Register Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Media City" />
    <meta name="MobileOptimized" content="320" />
    <link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
     @php
    $signuplogin = \App\Models\GeneralSetting::first();
    $setting = \App\Models\GeneralSetting::first();
    $sett = \App\Models\ApiSetting::first();
    $socialSettings = \App\Models\SocialSetting::first();
    $af_system = App\Models\Affiliate::first();
    @endphp
    @if(isset($setting->favicon_logo) && !empty($setting->favicon_logo))<link rel="icon" type="image/icon" href="{{ asset('images/favicon/' .$setting->favicon_logo) }}">@endif <!-- favicon -->
    <link type="text/css" href="{{ url('assets/fonts/flaticon_quizzly_admin.css') }}" rel="stylesheet">
    <link href="{{ url('admin_theme/assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('admin_theme/vendor/intl-tel-input-23.8.0/build/css/intlTelInput.css') }}">
    {!! NoCaptcha::renderJs() !!}
</head>
<body>
    <!-- Start Register -->
    <div id="register" class="login-main-block register-main-block">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="login-block">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="register-image">
                                    <img src="{{ asset('images/signup_img/' . $signuplogin->signup_img) }}" alt="{{ __('Signup Image') }}" class="img-fluid">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="register-logo">
                                    <img src="{{ asset('images/logo/' . $setting->logo) }}" alt="{{ __('logo') }}" class="img-fluid" id="logo">
                                </div>
                                <div class="register-dtls">
                                    <div>
                                        <h4 class="register-heading">{{ __('Create an account') }} </h4>
                                    </div>
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
                                    @endif
                                    <form class="contact-form-block" method="post" action="{{ route('register.store') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group mb-2">
                                                    <label for="name" class="form-label mb-1">{{ __('Name') }}<span class="required">*</span></label>
                                                    <input class="form-control form-control-lg custom-input" type="text" name="name" required placeholder="Please Enter Your Name" aria-label="" value="{{ old('name') }}" id="name">
                                                    <div class="form-control-icon"><i class="flaticon-user"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group mb-2">
                                                    <label for="slug" class="form-label mb-1">{{ __('Username') }}<span class="required">*</span></label>
                                                    <input class="form-control form-control-lg custom-input" type="text" name="slug" required placeholder="Please Enter Your Username" aria-label="" value="{{ old('name') }}" id="slug">
                                                    <div class="form-control-icon"><i class="flaticon-user"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group mb-2">
                                                    <label for="email" class="form-label mb-1">{{ __('Email') }}<span class="required">*</span></label>
                                                    <input class="form-control form-control-lg" type="email" name="email" required placeholder="Please Enter Your Email" aria-label="" value="{{ old('email') }}" id="email">
                                                    <div class="form-control-icon"><i class="flaticon-email"></i></div>
                                                </div>
                                            </div>
                                            @if($sett->mobile_status == 1)
                                            <div class="col-lg-12">
                                                <div class="form-group mb-2 mobile-input">
                                                    <label for="phone" class="form-label mb-1">{{ __('Mobile No') }}<span class="required">*</span></label>
                                                    <input id="phone" type="tel" class="form-control form-control-lg" name="mobile" required placeholder="Please Enter Your Mobile No">
                                                    <input type="hidden" id="full_phone" name="full_mobile">
                                                </div>
                                            </div>
                                            @endif
                                            <div class="col-lg-12">
                                                <div class="form-group mb-2">
                                                    <label for="password" class="form-label mb-1">{{ __('Password') }}<span
                                                            class="required">*</span></label>
                                                            <input type="password" class="form-control form-control-lg"
                                                        type="Password" placeholder="Please Enter Your Password"
                                                        name="password" aria-label="" required
                                                        value="{{ old('password') }}" id="password">
                                                        <i class="eye flaticon-hide"></i>
                                                    <div class="form-control-icon"><i class="flaticon-password"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group mb-2">
                                                    <label for="password" class="form-label mb-1">{{ __('Confirm Password') }}<span
                                                            class="required">*</span></label>
                                                            <input type="password" class="form-control form-control-lg"
                                                        type="Password" placeholder="Please Enter Your Confirm Password"
                                                        name="password_confirmation" aria-label="" required
                                                        value="{{ old('password_confirmation') }}">
                                                        <i class="eye flaticon-hide"></i>
                                                    <div class="form-control-icon"><i class="flaticon-security"></i></div>
                                                </div>
                                            </div>
                                            @if ($af_system && $af_system->status == 1)
                                                <div class="col-lg-12">
                                                    <div class="form-group mb-2">
                                                        <div class="row">
                                                            <div class="col-lg-8 col-md-8 col-8">
                                                                <label for="refer_code" class="form-label mb-1">{{ __('Refreal Code') }}<span
                                                                    class="required"></span></label>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-4">
                                                                <div class="suggestion-icon float-end">
                                                                    <div class="tooltip-icon">
                                                                        <div class="tooltip">
                                                                            <div class="credit-block">
                                                                                <small
                                                                                    class="recommended-font-size">{{ __('If Availabale') }}</small>
                                                                            </div>
                                                                        </div>
                                                                        <span class="float-end"><i class="flaticon-info"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                                <input value="{{ app('request')->input('ref') ?? old('refercode') }}" type="text" name="refer_code" class="{{ $errors->has('refercode') ? ' is-invalid' : '' }} form-control" placeholder="Enter Refer Code" id="refer_code">
                                                        <div class="form-control-icon"><i class="flaticon-code"></i></div>
                                                    </div>
                                                </div>
                                                @if ($errors->has('refercode'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('refercode') }}</strong>
                                                </span>
                                                @endif
                                            @endif
                                            @if($sett->recaptcha_status == 1)
                                            <div class="g-recaptcha mb-3" data-sitekey="{{ decrypt(config('services.recaptcha.site_key')) }}" data-callback='onSubmit' data-action='Create Account'>
                                            </div>
                                            @endif
                                            <div class="login-options">
                                                <button type="submit" class="btn btn-primary w-100 mb-3" title="Sign In">{{ __('Sign In') }}</button>
                                            </div>
                                            <div class="social-login-options">
                                                <p class="text-center">{{ __('Or sign in with') }}</p>
                                                <div class="d-flex justify-content-center mt-2">
                                                    <a href="{{ route('social.login', 'google') }}" class="btn btn-outline-primary mx-1 social-login-btn" title="Google">
                                                        <img src="{{ url('admin_theme/assets/images/login/google.png') }}" alt="Google" class="img-fluid social-login-icon">
                                                    </a>
                                                    <a href="{{ route('social.login', 'facebook') }}" class="btn btn-outline-primary mx-1 social-login-btn" title="Facebook">
                                                        <img src="{{ url('admin_theme/assets/images/login/facebook.png') }}" alt="Facebook" class="img-fluid social-login-icon">
                                                    </a>
                                                    <a href="{{ route('social.login', 'linkedin') }}" class="btn btn-outline-primary mx-1 social-login-btn" title="LinkedIn">
                                                        <img src="{{ url('admin_theme/assets/images/login/linkedin.png') }}" alt="LinkedIn" class="img-fluid social-login-icon">
                                                    </a>
                                                    <a href="{{ route('social.login', 'github') }}" class="btn btn-outline-primary mx-1 social-login-btn" title="GitHub">
                                                        <img src="{{ url('admin_theme/assets/images/login/github.png') }}" alt="GitHub" class="img-fluid social-login-icon">
                                                    </a>
                                                    <a href="{{ route('social.login', 'gitlab') }}" class="btn btn-outline-primary mx-1 social-login-btn" title="GitLab">
                                                        <img src="{{ url('admin_theme/assets/images/login/gitlab.png') }}" alt="GitLab" class="img-fluid social-login-icon">
                                                    </a>
                                                    <a href="{{ route('social.login', 'amazon') }}" class="btn btn-outline-primary mx-1 social-login-btn" title="Amazon">
                                                        <img src="{{ url('admin_theme/assets/images/login/amazon.png') }}" alt="Amazon" class="img-fluid social-login-icon">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="already-account">{{ __('Already have an account ?') }}<a href="{{ route('login') }}" title="Log in"> {{ __('Log in') }}</a></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Register -->
    <script src="{{ url('assets/js/jquery.min.js') }}"></script>
<script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin_theme/vendor/intl-tel-input-23.8.0/build/js/intlTelInput.min.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    var input = document.querySelector("#phone");
    var fullPhoneInput = document.querySelector("#full_phone");
    var iti = window.intlTelInput(input, {
        initialCountry: "in",
        separateDialCode: true,
        utilsScript: "{{ asset('admin_theme/vendor/intl-tel-input-23.8.0/build/js/utils.js') }}",
    });

    document.querySelector("form").addEventListener("submit", function() {
        fullPhoneInput.value = iti.getNumber();
    });

    document.querySelectorAll('.eye').forEach(eye => {
        eye.addEventListener('click', () => {
            const passwordInput = eye.previousElementSibling;
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eye.classList.remove('flaticon-hide');
                eye.classList.add('flaticon-show');
            } else {
                passwordInput.type = 'password';
                eye.classList.remove('flaticon-show');
            }
        });
    });
});

</script>
</html>
