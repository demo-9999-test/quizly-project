<!DOCTYPE html>
<html lang="en">
<!-- <![endif]-->
<!-- head -->
<head>
    <meta charset="utf-8" />
    <title>Forget Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Media City" />
    <meta name="MobileOptimized" content="320" />
    <!-- <link rel="icon" type="image/icon" href="assets/images/general/favicon.png"> favicon-icon -->
    <!-- theme styles -->
    <link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- bootstrap css -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"><!-- google fonts -->
    <link type="text/css" href="{{ url('assets/fonts/flaticon_admin_collection_2.css') }}" rel="stylesheet">
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
    @php
    $signuplogin = \App\Models\Setting::first();
    $setting = \App\Models\GeneralSetting::first();
    @endphp
        <div id="login-page" class="login-main-block">
            <div class="container">
                <div class="contentbar  ">
                @include('admin.layouts.flash_msg')
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="login-block">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="login-img">
                                            <img src="{{ asset('/images/login_img/' . $signuplogin->login_img) }}"
                                            alt="{{ __('login Image') }}img" class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="logo">
                                            <a href="#" title="{{ __('logo') }}"> <img src="{{ asset('images/logo/' . $setting->logo) }}" alt="{{ __('logo') }}"
                                                class="img-fluid" id="logo"></a>
                                        </div>
                                        <h4 class="container-heading"> {{ __('Forget Password ?') }}</h4>
                                        <p class="login-heading">{{ __('No Worries , Well Send your reset instruction') }}</p>
                                        @include('admin.layouts.flash_msg')
                                        <form action="{{route('forget.password.post')}}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="" class="form-label">{{__('Enter Your Email')}}</label>
                                                <input class="form-control email" type="email"
                                                    placeholder="Enter Your Email" aria-label="" name="email" required
                                                    value="{{ old('email') }}">
                                                <div class="form-control-icon"><i class="flaticon-email"></i></div>
                                            </div>
                                            <div class="login-options">
                                                <ul>
                                                    <li><button type="submit" class="btn btn-primary" title="Forgot Password">{{__('Reset Password')}}</button></li>
                                                </ul>
                                            </div>
                                        </form>
                                        <div class="sign-up"> {{ __('Back to') }}
                                            <a href="{{ route('login') }}" title="{{ __('Log in') }}">{{ __('Log in') }}</a>
                                        </div>
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
    <script src="{{ url('assets/js/jquery.min.js') }}"></script> <!-- jquery library js -->
    <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script> <!-- bootstrap js -->
    <!-- end jquery -->

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>
    <script>
        $().ready(function() {
    
            $('.alert').delay(2000);
            $('.alert').hide(3000);
        })
    </script>
</body>
<!-- body end -->

</html>
