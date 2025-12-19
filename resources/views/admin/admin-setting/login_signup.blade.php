@extends('admin.layouts.master')
@section('title', 'Login & Signup')
@section('main-container')
<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Login & Signup') }}
    @endslot
    @slot('menu1')
    {{ __('Front Settings') }}
    @endslot
    @slot('menu2')
    {{ __('Login & Signup') }}
    @endslot
    @endcomponent
    <div class="contentbar ">
        @include('admin.layouts.flash_msg')
        <div class="client-detail-block mb-4">
            <!--------form code start -->
            <form action="{{ route('login_signup.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-8 col-md-8">
                                    <label for="image" class="form-label">{{ __('Login Image') }}</label>
                                    <span class="required">*</span>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="suggestion-icon float-end">
                                        <div class="tooltip-icon">
                                            <div class="tooltip">
                                                <div class="credit-block">
                                                    <small class="recommended-font-size">{{ __(' (Recommended Size :
                                                        526x533 Px) ') }}</small>
                                                </div>
                                            </div>
                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-9 col-md-9">
                                    <input class="form-control" type="file" name="login_img" id="image" accept="image/*"
                                        onchange="readURL(this)" ;>
                                    <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="edit-img-show">
                                        <img src="{{ asset('/images/login_img/' . $signuplogin->login_img) }}"
                                            alt="{{ __('login Image') }}" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-8 col-md-8">
                                    <label for="image" class="form-label">{{ __('Signup Image') }}</label>
                                    <span class="required">*</span>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="suggestion-icon float-end">
                                        <div class="tooltip-icon">
                                            <div class="tooltip">
                                                <div class="credit-block">
                                                    <small class="recommended-font-size">{{ __(' (Recommended Size :
                                                        526x533 Px) ') }}</small>
                                                </div>
                                            </div>
                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-9 col-md-9">
                                    <input class="form-control" type="file" name="signup_img" id="image"
                                        accept="image/*" onchange="readURL(this)" ;>
                                    <div class="form-control-icon"><i class="flaticon-login-1"></i></div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="edit-img-show">
                                        <img src="{{ asset('/images/signup_img/' . $signuplogin->signup_img) }}"
                                            alt="{{ __('Signup Image') }}" class="img-fluid">
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-8 col-md-8">
                                    <label for="image" class="form-label">{{ __('Forget Password Image') }}</label>
                                    <span class="required">*</span>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="suggestion-icon float-end">
                                        <div class="tooltip-icon">
                                            <div class="tooltip">
                                                <div class="credit-block">
                                                    <small class="recommended-font-size">{{ __(' (Recommended Size :
                                                        526x533 Px) ') }}</small>
                                                </div>
                                            </div>
                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-9 col-md-9">
                                    <input class="form-control" type="file" name="forget_img" id="forget_img"
                                        accept="image/*" onchange="readURL(this)" ;>
                                    <div class="form-control-icon"><i class="flaticon-padlock"></i></div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="edit-img-show">
                                        <img src="{{ asset('/images/login_img/' . $signuplogin->forget_img) }}"
                                            alt="{{ __('Forget Image') }}" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    <label for="app_status" class="form-label">{{ __('Mobile No. Show on
                                        SignUp') }}</label>
                                </div>
                                <div class="col-lg-2 col-md-2">
                                    <div class="suggestion-icon float-end">
                                        <div class="tooltip-icon">
                                            <div class="tooltip">
                                                <div class="credit-block">
                                                    <small class="recommended-font-size">{{ __('(Enable ask
                                                        mobile no. on SignUp page)') }}</small>
                                                </div>
                                            </div>
                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="app_status"
                                    name="mobile_status" value="1" {{ $signuplogin->mobile_status == 1 ? 'checked' :
                                '' }}>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" title=" {{ __('Update') }}" class="btn btn-primary mt-3"><i
                        class="flaticon-upload-1"></i>
                    {{ __('Update') }}</button>
            </form>
            <!-------form code end ------>
        </div>
        <div class="row">
            <h5 class="block-heading">{{ __('Single Sign On') }}</h5>

            <div class="col-lg-2 col-md-3">
                <div class="client-detail-block mb-4 d-flex align-items-start">
                    <div class="nav-template">
                        <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                                    title=" {{ __('Facebook') }}" data-bs-target="#v-pills-home" type="button" role="tab"
                                    aria-controls="v-pills-home" aria-selected="true"> {{ __('Facebook') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                                    title=" {{ __('Google') }}" data-bs-target="#v-pills-profile" type="button" role="tab"
                                    aria-controls="v-pills-profile" aria-selected="false"> {{ __('Google') }}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="v-pills-contact-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-contact" type="button" role="tab" title=" {{ __('Gitlab') }}"
                                    aria-controls="v-pills-contact" aria-selected="false"> {{ __('GitLab') }}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="v-pills-tab4" data-bs-toggle="pill" title=" {{ __('Amazon') }}"
                                    data-bs-target="#v-pills-tab4-content" type="button" role="tab"
                                    aria-controls="v-pills-tab4-content" aria-selected="false"> {{ __('Amazon') }}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="v-pills-tab5" data-bs-toggle="pill"
                                    title=" {{ __('Linkedin') }}" data-bs-target="#v-pills-tab5-content" type="button"
                                    role="tab" aria-controls="v-pills-tab5-content" aria-selected="false"> {{ __('LinkedIn')
                                    }}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="v-pills-tab6" data-bs-toggle="pill"
                                    title=" {{ __('GitHub') }}" data-bs-target="#v-pills-tab6-content" type="button"
                                    role="tab" aria-controls="v-pills-tab6-content" aria-selected="false"> {{ __('GitHub')
                                    }}
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-10 col-md-9">
                <!-- form code start -->
                <div class="client-detail-block">
                    <div class="tab-content" id="v-pills-tabContent">
                        {{-- facebook tab start code --}}
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                            aria-labelledby="v-pills-home-tab" tabindex="0">
                            <form action="{{ route('update.facebook.login') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label for="Client ID" class="form-label">{{ __('Client ID') }}
                                                <span class="required">*</span>
                                            </label>
                                            <input class="form-control" type="text" name="FACEBOOK_CLIENT_ID" value="{{ env('FACEBOOK_CLIENT_ID') }}" placeholder="{{ __('Please enter FACEBOOK CLIENT ID') }}">

                                            <div class="form-control-icon"><i class="flaticon-id-card"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{ __('Client Secret Key') }}<span
                                                    class="required"> *</span></label>
                                                    <input class="form-control" type="password" name="FACEBOOK_CLIENT_SECRET" value="{{ env('FACEBOOK_CLIENT_SECRET') }}" id="fbsecret" placeholder="{{ __('Please enter FACEBOOK SECRET KEY') }}">

                                            <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8">
                                                    <label for="Client ID" class="form-label">{{ __('Callback URL') }}
                                                        <span class="required">*</span> </label>
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <div class="suggestion-icon float-end">
                                                        <div class="tooltip-icon">
                                                            <div class="tooltip">
                                                                <div class="credit-block">
                                                                    <small class="recommended-font-size">
                                                                        {{__('Use callback URL
                                                                        https://yoursite.com/public/auth/facebook/callback')}}</small>
                                                                </div>
                                                            </div>
                                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="form-control" type="text" name="FB_CALLBACK_URL" value="{{ env('FACEBOOK_REDIRECT') }}" placeholder="{{ __('Please enter CALLBACK URL') }}">


                                            <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                        </div>
                                    </div>
                                    @php
                                    $showFacebookToggle = env('FACEBOOK_CLIENT_ID') && env('FACEBOOK_CLIENT_SECRET') && env('FACEBOOK_REDIRECT');
                                    @endphp

                                    @if($showFacebookToggle)
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="status" class="form-label">{{ __('Enable Facebook Login') }}</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="facebookStatusToggle" name="facebook_status" value="1"
                                                    {{ $socialMediaLogin->facebook_status == 1 ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-lg-12">
                                        <small class="text-muted">{{__('Fill Facebook credential and update data to see status')}}</small>
                                    </div>
                                    @endif
                                </div>
                                <button type="submit" title="{{ __('Update') }}" class="btn btn-primary mt-3"><i
                                        class="flaticon-upload-1"></i>{{
                                    __('Update') }}</button>
                            </form>
                        </div>
                        {{-- facebook tab start end --}}

                        {{-- Google tab end code --}}
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                            aria-labelledby="v-pills-profile-tab" tabindex="0">
                            <form action="{{ route('update.google.login') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label for="Client ID" class="form-label">{{ __('Client ID') }}
                                                <span class="required">*</span> </label>
                                                <input class="form-control" type="text" name="GOOGLE_CLIENT_ID" value="{{ env('GOOGLE_CLIENT_ID') }}" placeholder="{{ __('Please enter CLIENT ID') }}">

                                            <div class="form-control-icon"><i class="flaticon-id-card"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{ __('Client Secret Key') }} <span
                                                    class="required">*</span></label>
                                                    <input class="form-control" type="password" name="GOOGLE_CLIENT_SECRET" value="{{ env('GOOGLE_CLIENT_SECRET') }}" id="gsecret" placeholder="{{ __('Please enter CLIENT SECRET KEY') }}">


                                            <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8">
                                                    <label for="Client ID" class="form-label">{{ __('Callback URL') }}
                                                        <span class="required">*</span></label>
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <div class="suggestion-icon float-end">
                                                        <div class="tooltip-icon">
                                                            <div class="tooltip">
                                                                <div class="credit-block">
                                                                    <small class="recommended-font-size">
                                                                       {{__(' Use callback URL
                                                                        https://yoursite.com/public/auth/google/callback')}}</small>
                                                                </div>
                                                            </div>
                                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="form-control" type="text" name="GOOGLE_REDIRECT_URI" value="{{ env('GOOGLE_REDIRECT_URI') }}" placeholder="{{ __('Please enter CALLBACK URL') }}">

                                            <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                        </div>
                                    </div>
                                    @php
                                    $showGoogleToggle = env('GOOGLE_CLIENT_ID') && env('GOOGLE_CLIENT_SECRET') && env('GOOGLE_REDIRECT_URI');
                                    @endphp

                                    @if($showGoogleToggle)
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label for="status" class="form-label">{{ __('Enable Google Login ') }}</label>
                                                <div class="form-check form-switch ">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="googleStatusToggle" name="google_status" value="1"
                                                        {{ $socialMediaLogin->google_status == 1 ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-lg-12 col-md-12">
                                            <small class="text-muted">{{__('Fill all Google credentials and update data to see status')}}</small>
                                        </div>
                                    @endif
                                </div>
                                <button type="submit" title="{{ __('Update') }}" class="btn btn-primary mt-3"><i
                                        class="flaticon-upload-1"></i>{{
                                    __('Update') }}</button>
                            </form>
                        </div>
                        {{-- Google tab end code --}}

                        {{-- gitlab tab start code --}}
                        <div class="tab-pane fade" id="v-pills-contact" role="tabpanel"
                            aria-labelledby="v-pills-contact-tab" tabindex="0">
                            <form action="{{ route('update.gitlab.login') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label for="Client ID" class="form-label">{{ __('Client ID') }}
                                                <span class="required">*</span></label>
                                            <input class="form-control" type="text" name="GITLAB_CLIENT_ID" value="{{ env('GITLAB_CLIENT_ID') }}" placeholder="{{ __('Please enter CLIENT ID') }}">
                                            <div class="form-control-icon"><i class="flaticon-id-card"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{ __('Client Secret Key') }} <span class="required">*</span></label>
                                            <input class="form-control" type="password" name="GITLAB_CLIENT_SECRET" value="{{ env('GITLAB_CLIENT_SECRET') }}" id="gitsecret" placeholder="{{ __('Please enter CLIENT SECRET KEY') }}">
                                            <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8">
                                                    <label for="Client ID" class="form-label">{{ __('Callback URL') }}
                                                        <span class="required">*</span></label>
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <div class="suggestion-icon float-end">
                                                        <div class="tooltip-icon">
                                                            <div class="tooltip">
                                                                <div class="credit-block">
                                                                    <small class="recommended-font-size">
                                                                        {{__('Use callback URL https://yoursite.com/public/auth/gitlab/callback')}}
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="form-control" type="text" name="GITLAB_CALLBACK_URL" value="{{ env('GITLAB_REDIRECT_URI') }}" placeholder="{{ __('Please enter CALLBACK URL') }}">
                                        </div>
                                    </div>
                                    @php
                                    $showGitlabToggle = env('GITLAB_CLIENT_ID') && env('GITLAB_CLIENT_SECRET') && env('GITLAB_REDIRECT_URI');
                                    @endphp

                                    @if($showGitlabToggle)
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label for="status" class="form-label">{{ __('Enable Gitlab Login ') }}</label>
                                                <div class="form-check form-switch ">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="gitlabStatusToggle" name="gitlab_status" value="1"
                                                        {{ $socialMediaLogin->gitlab_status == 1 ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-lg-12 col-md-12">
                                            <small class="text-muted">{{__('Fill all GitLab credentials and update data to see status')}}</small>
                                        </div>
                                    @endif
                                </div>
                                <button type="submit" title="{{ __('Update') }}" class="btn btn-primary mt-3"><i
                                        class="flaticon-upload-1"></i>{{
                                    __('Update') }}</button>
                            </form>
                        </div>
                        {{-- gitlab tab end code --}}

                        {{-- amazone tab start code --}}
                        <div class="tab-pane fade" id="v-pills-tab4-content" role="tabpanel"
                            aria-labelledby="v-pills-tab4" tabindex="0">
                            <form action="{{ route('update.amazon.login') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label for="Client ID" class="form-label">{{ __('Client ID') }}
                                                <span class="required">*</span></label>
                                            <input class="form-control" type="text" name="AMAZON_CLIENT_ID" value="{{ env('AMAZON_CLIENT_ID') }}" placeholder="{{ __('Please enter AMAZON CLIENT ID') }}">
                                            <div class="form-control-icon"><i class="flaticon-id-card"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{ __('Client Secret Key') }} <span class="required">*</span></label>
                                            <input class="form-control" type="password" name="AMAZON_CLIENT_SECRET" value="{{ env('AMAZON_CLIENT_SECRET') }}" id="amazonSecret" placeholder="{{ __('Please enter AMAZON SECRET KEY') }}">
                                            <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8">
                                                    <label for="Client ID" class="form-label">{{ __('Callback URL') }}
                                                        <span class="required">*</span> </label>
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <div class="suggestion-icon float-end">
                                                        <div class="tooltip-icon">
                                                            <div class="tooltip">
                                                                <div class="credit-block">
                                                                    <small class="recommended-font-size">
                                                                        Use callback URL https://yoursite.com/public/auth/amazon/callback
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="form-control" type="text" name="AMAZON_CALLBACK_URL" value="{{ env('AMAZON_CALLBACK_URL') }}" placeholder="{{ __('Please enter CALLBACK URL') }}">
                                            <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                        </div>
                                    </div>

                                    @php
                                    $showAmazonToggle = env('AMAZON_CLIENT_ID') && env('AMAZON_CLIENT_SECRET') && env('AMAZON_CALLBACK_URL');
                                    @endphp

                                    @if($showAmazonToggle)
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label for="status" class="form-label">{{ __('Enable Amazon Login ') }}</label>
                                                <div class="form-check form-switch ">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="amazonStatusToggle" name="amazon_status" value="1"
                                                        {{ $socialMediaLogin->amazon_status == 1 ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-lg-12 col-md-12">
                                            <small class="text-muted">{{__('Fill all Amazon credentials and update data to see status')}}</small>
                                        </div>
                                    @endif
                                </div>
                                <button type="submit" title="{{ __('Update') }}" class="btn btn-primary mt-3"><i
                                        class="flaticon-upload-1"></i>{{
                                    __('Update') }}</button>
                            </form>
                        </div>
                        {{-- amazone tab start code --}}

                        {{-- linkedin tab start code --}}
                        <div class="tab-pane fade" id="v-pills-tab5-content" role="tabpanel"
                            aria-labelledby="v-pills-tab5" tabindex="0">
                            <form action="{{ route('update.linkedin.login') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label for="Client ID" class="form-label">{{ __('Client ID') }}
                                                <span class="required">*</span> </label>
                                            <input class="form-control" type="text" name="LINKEDIN_CLIENT_ID" value="{{ env('LINKEDIN_CLIENT_ID') }}" placeholder="{{ __('Please enter LINKEDIN CLIENT ID') }}">
                                            <div class="form-control-icon"><i class="flaticon-id-card"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{ __('Client Secret Key') }} <span class="required">*</span></label>
                                            <input class="form-control" type="password" name="LINKEDIN_CLIENT_SECRET" value="{{ env('LINKEDIN_CLIENT_SECRET') }}" id="linkedinSecret" placeholder="{{ __('Please enter LINKEDIN SECRET KEY') }}">
                                            <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8">
                                                    <label for="Client ID" class="form-label">{{ __('Callback URL') }}
                                                        <span class="required">*</span></label>
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <div class="suggestion-icon float-end">
                                                        <div class="tooltip-icon">
                                                            <div class="tooltip">
                                                                <div class="credit-block">
                                                                    <small class="recommended-font-size">
                                                                        Use callback URL https://yoursite.com/public/auth/linkedin/callback
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="form-control" type="text" name="LINKEDIN_CALLBACK_URL" value="{{ env('LINKEDIN_REDIRECT_URI') }}" placeholder="{{ __('Please enter CALLBACK URL') }}">
                                            <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                        </div>
                                    </div>

                                    @php
                                    $showLinkedInToggle = env('LINKEDIN_CLIENT_ID') && env('LINKEDIN_CLIENT_SECRET') && env('LINKEDIN_REDIRECT_URI');
                                    @endphp

                                    @if($showLinkedInToggle)
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label for="status" class="form-label">{{ __('Enable LinkedIn Login ') }}</label>
                                                <div class="form-check form-switch ">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="linkedinStatusToggle" name="linkedin_status" value="1"
                                                        {{ $socialMediaLogin->linkedin_status == 1 ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-lg-12 col-md-12">
                                            <small class="text-muted">{{__('Fill all LinkedIn credentials and update data to see status')}}</small>
                                        </div>
                                    @endif
                                </div>

                                <button type="submit" title="{{ __('Update') }}" class="btn btn-primary mt-3"><i
                                        class="flaticon-upload-1"></i>{{
                                    __('Update') }}</button>
                            </form>
                        </div>
                        {{-- linkedin tab end code --}}

                        {{-- twitter tab start code --}}
                        <div class="tab-pane fade" id="v-pills-tab6-content" role="tabpanel"
                            aria-labelledby="v-pills-tab6" tabindex="0">
                            <form action="{{ route('update.github.login') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label for="Client ID" class="form-label">{{ __('Client ID') }}
                                                <span class="required">*</span> </label>
                                            <input class="form-control" type="text" name="GITHUB_CLIENT_ID" value="{{ env('GITHUB_CLIENT_ID') }}" placeholder="{{ __('Please enter GITHUB CLIENT ID') }}">
                                            <div class="form-control-icon"><i class="flaticon-id-card"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{ __('Client Secret Key') }} <span class="required">*</span></label>
                                            <input class="form-control" type="password" name="GITHUB_CLIENT_SECRET" value="{{ env('GITHUB_CLIENT_SECRET') }}" id="githubSecret" placeholder="{{ __('Please enter GITHUB SECRET KEY') }}">
                                            <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8">
                                                    <label for="Client ID" class="form-label">{{ __('Callback URL') }}
                                                        <span class="required">*</span> </label>
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <div class="suggestion-icon float-end">
                                                        <div class="tooltip-icon">
                                                            <div class="tooltip">
                                                                <div class="credit-block">
                                                                    <small class="recommended-font-size">
                                                                        Use callback URL https://yoursite.com/public/auth/github/callback
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="form-control" type="text" name="GITHUB_CALLBACK_URL" value="{{ env('GITHUB_REDIRECT_URI') }}" placeholder="{{ __('Please enter CALLBACK URL') }}">
                                            <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                        </div>
                                    </div>

                                    @php
                                    $showGitHubToggle = env('GITHUB_CLIENT_ID') && env('GITHUB_CLIENT_SECRET') && env('GITHUB_REDIRECT_URI');
                                    @endphp

                                    @if($showGitHubToggle)
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label for="status" class="form-label">{{ __('Enable GitHub Login ') }}</label>
                                                <div class="form-check form-switch ">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="githubStatusToggle" name="github_status" value="1"
                                                        {{ $socialMediaLogin->github_status == 1 ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-lg-12 col-md-12">
                                            <small class="text-muted">{{__('Fill all GitHub credentials and update data to see status')}}</small>
                                        </div>
                                    @endif
                                </div>
                                <button type="submit" title="{{ __('Update') }}" class="btn btn-primary mt-3"><i
                                        class="flaticon-upload-1"></i>{{
                                    __('Update') }}</button>
                            </form>
                        </div>
                        {{-- twitter tab start code --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal  start-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"> {{ __('Show Keys') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="keypassword" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="image" class="form-label">{{ __('User Login Password') }}<span
                                class="required">*</span></label>
                        <input id="confirm_password" class="form-control" type="password"
                            placeholder="{{ __('Please Enter Your Password') }}" aria-label="" name="password" required>
                        <div class="form-control-icon"><i class="flaticon-key"></i></div>
                        <span class="fa fa-fw fa-eye field-icon toggle-password"
                            onclick="togglePasswordVisibility('password')"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title=" {{ __('Close') }}">
                        {{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary socialsubmitPassword" title="{{ __('Submit')
                }}" id="socialsubmitPassword">{{ __('Submit')
                        }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal end-->

@endsection
