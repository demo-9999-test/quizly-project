@extends('admin.layouts.master')
@section('title', 'API Setting')
@section('main-container')
<div class="dashboard-card">

    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('API Settings') }}
    @endslot
    @slot('menu1')
    {{ __('Projects Settings') }}
    @endslot
    @slot('menu2')
    {{ __('API Settings') }}
    @endslot
    @endcomponent

    <div class="contentbar ">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-2 col-md-3">
                <div class="client-detail-block mb-4 d-flex align-items-start">
                    <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="v-pills-web-adsense-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-web-adsense" type="button" role="tab"
                            title="{{ __('Adsense ') }}" aria-controls="v-pills-adsense" aria-selected="false"><img
                            src="{{ url('images/payment_img/google-adsense.png') }}" alt="{{ __('Adsense') }}"
                            class="tabs-img"></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="v-pills-web-analytics-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-web-analytics" type="button" role="tab"
                            title="{{ __('Analytics') }}" aria-controls="v-pills-analytics"
                            aria-selected="false"><img src="{{ url('images/payment_img/google-analytics.png') }}"
                            alt="{{ __('Analytics') }}" class="tabs-img"></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="v-pills-openapi-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-openapi" type="button" role="tab" title="{{ __('Open API') }}"
                            aria-controls="v-pills-openapi" aria-selected="false"><img
                            src="{{ url('images/payment_img/ai.png') }}" alt="{{ __('Open API') }}"
                            class="tabs-img open-ai"></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="v-pills-web-facebook-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-web-facebook" type="button" role="tab"
                            title="{{ __('Facebook ') }}" aria-controls="v-pills-facebook"
                            aria-selected="false"><img src="{{ url('images/payment_img/facebook.png') }}"
                            alt="{{ __('Facebook') }}" class="tabs-img"></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="v-pills-web-recaptcha-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-web-recaptcha" type="button" role="tab"
                            title="{{ __('Recaptcha ') }}" aria-controls="v-pills-recaptcha"
                            aria-selected="false"><img src="{{ url('images/payment_img/recaptcha.png') }}"
                            alt="{{ __('recaptcha') }}" class="tabs-img"></button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-10 col-md-9">
                <div class="client-detail-block">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-web-adsense" role="tabpanel"
                        aria-labelledby="v-pills-web-adsense-tab" tabindex="0">
                            <h5 class="block-heading">{{ __('Google Adsense') }}</h5>
                            <form action="{{ route('adsense.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div>
                                    <div class="form-group">
                                        <label for="Title" class="form-label">{{ __('Adsense Script') }}<span
                                        class="required">*</span></label>
                                        <textarea name="adsense_script" class="form-control form-control-padding_15"
                                        required placeholder="{{ __('Please Enter Your Adsense Script') }}" id="msg"
                                        cols="30" rows="3">{{ $settings->adsense_script }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="status" class="form-label">{{ __('Status') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="status"
                                            name="ad_status" value="1" {{ $settings->ad_status == 1 ? 'checked' : ''}} checked>
                                        </div>
                                    </div>
                                    <button type="submit" title="{{ __('Submit') }}" class="btn btn-primary mt-3"><i
                                    class="flaticon-upload-1"></i>{{ __('Submit') }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-web-analytics" role="tabpanel"
                        aria-labelledby="v-pills-web-analytics-tab" tabindex="0">
                            <h5 class="block-heading">{{ __('Google Analytics') }}</h5>
                            <form action="{{ route('analytics.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div>
                                    <div class="form-group">
                                        <label for="Title" class="form-label">{{ __('Analytics Script') }} <span
                                        class="required">*</span></label>
                                        <textarea name="analytics_script" class="form-control form-control-padding_15"
                                        placeholder="{{ __('Please Enter Your Analytics Script') }}" id="msg" cols="30"
                                        required rows="3">{{ $settings->analytics_script }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="status" class="form-label">{{ __('Status') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="status"
                                            name="an_status" value="1" {{ $settings->an_status == 1 ? 'checked' : ''}} checked>
                                        </div>
                                    </div>
                                    <button type="submit" title="{{ __('Submit') }}" class="btn btn-primary mt-3"><i
                                    class="flaticon-upload-1"></i>{{ __('Submit') }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-web-mailchip" role="tabpanel"
                        aria-labelledby="v-pills-web-mailchip-tab" tabindex="0">
                        <h5 class="block-heading">{{ __('Mailchip Settings') }}</h5>
                        <form action="{{ route('mailchip.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label for="client_name" class="form-label">{{ __('Mailchimp Api Key')}}<span class="required">*</span></label>
                                            <input class="form-control form-control-lg" type="password"
                                            name="mailchip_api_key" id="mailchip_api_key"
                                            placeholder="{{ __('Please Enter Mailchimp Api Key') }}"
                                            aria-label="title" value="{{ $mailchipapikey }}" required>
                                            <div class="form-control-icon"><i class="flaticon-id-card"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label for="client_name" class="form-label">{{ __('Mailchimp List ID ')}}<span class="required">*</span></label>
                                            <input class="form-control form-control-lg" type="text" name="mailchip_id"
                                            placeholder=" {{ __('Please Enter Mailchimp List ID ') }}" required
                                            aria-label="title" value="{{ $settings->mailchip_id }}">
                                            <div class="form-control-icon"><i class="flaticon-coin"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary mt-3 me-2" data-bs-toggle="modal" tie
                                data-bs-target="#exampleModal" title="{{ __('Show Key') }}">
                                <i class="flaticon-view"></i> {{ __('Show Key') }}</button>
                                <button type="submit" title="{{ __('Submit') }}" class="btn btn-primary mt-3"><i
                                class="flaticon-upload-1"></i>{{ __('Submit') }}</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-web-facebook" role="tabpanel"
                        aria-labelledby="v-pills-web-facebook-tab" tabindex="0">
                        <h5 class="block-heading">{{ __('Facebook Pixel ') }}</h5>
                        <form action="{{ route('facebook.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label for="client_name" class="form-label">{{ __('Facebook Pixel Code')}}<span class="required">*</span></label>
                                        <input class="form-control form-control-lg" type="password" name="fb_pixel"
                                        id="fb_pixel" placeholder="{{ __('Enter Facebook Pixel Code') }}"
                                        aria-label="title" value="{{ $fb_pixel }}" required>
                                        <div class="form-control-icon"><i class="flaticon-id-card"></i></div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary mt-3 me-2" data-bs-toggle="modal"
                            data-bs-target="#exampleModal" title="{{ __('Show Key') }}">
                            <i class="flaticon-view"></i> {{ __('Show Key') }}
                        </button>
                        <button type="submit" title="{{ __('Submit') }}" class="btn btn-primary mt-3"><i
                        class="flaticon-upload-1"></i>{{ __('Submit') }}</button>
                    </form>
                </div>
                <div class="tab-pane fade" id="v-pills-web-recaptcha" role="tabpanel"
                aria-labelledby="v-pills-web-recaptcha-tab" tabindex="0">
                <h5 class="block-heading">{{ __('Re Captcha') }}</h5>
                <form action="{{ route('recaptcha.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-5 col-md-6">
                            <div class="form-group">
                                <label for="RECAPTCHA_SITE_KEY" class="form-label">{{ __('Captcha SiteKey')}}</label>
                                <span class="required">*</span>
                                <input class="form-control" type="password" name="RECAPTCHA_SITE_KEY"
                                id="recaptcha_site_key"
                                placeholder="{{ __('Enter Your Captcha SiteKey') }}"
                                aria-label="recaptcha_site_key"
                                value="{{ $env_files['RECAPTCHA_SITE_KEY'] }}" required>
                                <div class="form-control-icon"><i class="flaticon-key"></i></div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="form-group">
                                <label for="RECAPTCHA_SECRET_KEY" class="form-label">{{ __('Captcha Secret Key') }}</label>
                                <span class="required">*</span>
                                <input class="form-control" type="password" name="RECAPTCHA_SECRET_KEY"
                                id="recaptcha_secret_key"
                                placeholder="{{ __('Enter Your Captcha Secret Key') }}"
                                 aria-label="recaptcha_secret_key"
                                 value="{{ $env_files['RECAPTCHA_SECRET_KEY'] }}" required>
                                 <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="recaptcha_status" class="form-label">{{ __('Status') }}</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                        id="recaptcha_status" name="recaptcha_status" value="1" {{
                                            $settings->recaptcha_status == 1 ? 'checked' : '' }}>
                                        </div checked>
                                    </div>
                                </div>
                            </div>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-secondary mt-3 me-2" data-bs-toggle="modal" tie
                            data-bs-target="#exampleModal" title="{{ __('Show Key') }}">
                            <i class="flaticon-view"></i> {{ __('Show Key') }}</button>
                                <button type="submit" class="btn btn-primary mt-3" title="{{ __('Update') }}">
                                    <i class="flaticon-refresh"></i> {{ __('Update') }}
                                </button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-openapi" role="tabpanel"
                            aria-labelledby="v-pills-openapi-tab" tabindex="0">
                            <h5 class="block-heading">{{ __('Open API Key (ChatGPT)') }}</h5>
                            <form action="{{ route('openapikey.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="faq-block">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="openapikey" class="form-label">{{ __('Open API Key(ChatGPT)') }}
                                                    <span class="required"> *</span></label>
                                                <input class="form-control" type="password" name="openapikey"
                                                    placeholder="{{ __('Enter Your Open API Key (ChatGPT)') }}"
                                                    aria-label="openapikey" id="openapikey" value="{{ $openapikey }}"
                                                    required>
                                                <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="status" class="form-label">{{ __('Status') }}</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="status" name="gpt_toggle" value="1" {{ $settings->gpt_toggle == 1 ? 'checked' : ''}} checked>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Button trigger modal -->
                                    <button type="submit" class="btn btn-primary mt-3"
                                        title="{{ __('Click to Update') }}">
                                        <i class="flaticon-upload-1"></i>{{ __('submit') }}
                                    </button>
                                </div>
                            </form>
                        </div>
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
                            placeholder="Please Enter Your Password" aria-label="" name="password" required>
                        <div class="form-control-icon"><i class="flaticon-key"></i></div>
                        <span class="fa fa-fw fa-eye field-icon toggle-password"
                            onclick="togglePasswordVisibility('password')"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" title="{{ __('Close') }}" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary submitPassword" title="{{ __('Submit') }}" id="apisubmitPassword">{{ __('Submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal end-->

@endsection

