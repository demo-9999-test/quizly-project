<!DOCTYPE html>
<html lang="en">
<!-- <![endif]-->

<!-- head -->
<head>
    <meta charset="utf-8" />
    <title>Admin</title>
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
    <link href="{{ url('admin_theme/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- fontawesome css -->
    <link type="text/css" href="{{ url('admin_theme/assets/fonts/font/flaticon_admin_collection.css') }}" rel="stylesheet">
    <!-- fonts css -->
    <link href="{{ url('admin_theme/assets/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('admin_theme/assets/css/style.css') }}" rel="stylesheet" type="text/css" /> <!-- custom css -->
    <!-- custom css -->
    <!-- end theme styles -->
    {!! NoCaptcha::renderJs() !!}
</head>

<body>
    <!-- Start Login -->
    @php
    $signuplogin = \App\Models\Setting::first();
    $setting = \App\Models\GeneralSetting::first();
    @endphp
    <div id="login-page" class="login-main-block">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="login-block">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="logo">
                                <a href="#" title="{{ __('logo') }}"><img src="{{ asset('images/logo/' . $setting->logo) }}"
                                    alt="{{ __('logo') }}" class="img-fluid" id="logo"></a>
                            </div>
                            <h4 class="container-heading">{{ __('Password Reset') }}</h4>
                            <h6 class="login-heading">{{ __('Create a New Password') }}</h6>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('reset.password.post') }}" method="POST">
                                @csrf
                                <input type="text" hidden value="{{ $token }}" name="token">
                                <div class="form-group mb-3">
                                    <label for="">{{ __('New Password') }}</label>
                                    <input id="password" class="form-control form-control-lg " type="password" placeholder="{{ __('New Password') }}"
                                        aria-label="" name="password" required>
                                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    <div class="form-control-icon"><i class="flaticon-password"></i></div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">{{ __('Confirm Password') }}</label>
                                    <input id="cpassword" class="form-control form-control-lg " type="password" placeholder="{{ __('Confrim Password') }}"
                                        aria-label="" name="password_confirmation"  id="password-confirm" required>
                                        <span toggle="#cpassword" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    <div class="form-control-icon"><i class="flaticon-security"></i></div>
                                </div>
                                <button type="submit" title="{{ __('Update Password') }}" class="btn btn-primary" title="Update Password">{{ __('Update Password') }}</button>
                            </form>
                        </div>
                        <div class="col-lg-7">
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
    <!-- End Login -->

    <!-- jquery -->
    <script src="{{ url('admin_theme/assets/js/jquery.min.js') }}"></script> <!-- jquery library js -->
    <script src="{{ url('admin_theme/assets/js/bootstrap.bundle.min.js') }}"></script> <!-- bootstrap js -->
    <script src="{{ url('admin_theme/assets/js/theme.js') }}"></script> <!-- custom js -->
    <script src="{{ url('admin_theme/assets/js/password-toggle.js') }}"></script> <!-- password toggle js -->
</body>
<!-- body end -->

</html>
