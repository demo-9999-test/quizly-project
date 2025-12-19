@extends('admin.layouts.master')
@section('title', 'Social Login Setting')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Social Login Settings') }}
    @endslot
    @slot('menu1')
    {{ __('Project Settings') }}
    @endslot
    @slot('menu2')
    {{ __('Social Login Settings') }}
    @endslot
    @endcomponent

    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('sociallogin.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block mb-4">
                        <div class="row">
                            <h5 class="block-heading">{{ __('Social Login Settings') }}</h5>
                            <!-- Tabs -->
                            <ul class="nav nav-pills flex-nowrap mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-Google-Login-tab" data-bs-toggle="pill" data-bs-target="#pills-Google-Login" type="button" role="tab" aria-controls="pills-Google-Login" aria-selected="true">Google Login Setting</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-Facebook-Login-tab" data-bs-toggle="pill" data-bs-target="#pills-Facebook-Login" type="button" role="tab" aria-controls="pills-Facebook-Login" aria-selected="false">Facebook Login Settings</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-Gitlab-Login-tab" data-bs-toggle="pill" data-bs-target="#pills-Gitlab-Login" type="button" role="tab" aria-controls="pills-Gitlab-Login" aria-selected="false">Gitlab Login Settings</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-LinkedIn-Login-tab" data-bs-toggle="pill" data-bs-target="#pills-LinkedIn-Login" type="button" role="tab" aria-controls="pills-LinkedIn-Login" aria-selected="false">LinkedIn Login Settings</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-Github-Login-tab" data-bs-toggle="pill" data-bs-target="#pills-Github-Login" type="button" role="tab" aria-controls="pills-Github-Login" aria-selected="false">GitHub Login Settings</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-Amazon-Login-tab" data-bs-toggle="pill" data-bs-target="#pills-Amazon-Login" type="button" role="tab" aria-controls="pills-Amazon-Login" aria-selected="false">Amazon Login Settings</button>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content" id="pills-tabContent">

                                <!-- Google Login Settings -->
                                <div class="tab-pane fade show active" id="pills-Google-Login" role="tabpanel" aria-labelledby="pills-Google-Login-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="GOOGLE_CLIENT_ID" class="form-label">{{ __('CLIENT ID') }} <span class="required">*</span></label>
                                                <input class="form-control" type="text" name="GOOGLE_CLIENT_ID" value="{{ env('GOOGLE_CLIENT_ID') }}" placeholder="{{ __('Please enter CLIENT ID') }}">
                                                <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="GOOGLE_CLIENT_SECRET" class="form-label">{{ __('CLIENT SECRET KEY') }} <span class="required">*</span></label>
                                                <input class="form-control" type="password" name="GOOGLE_CLIENT_SECRET" value="{{ env('GOOGLE_CLIENT_SECRET') }}" id="gsecret" placeholder="{{ __('Please enter CLIENT SECRET KEY') }}">
                                                <div class="form-control-icon"><i class="flaticon-password"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="GOOGLE_REDIRECT_URI" class="form-label">{{ __('CALLBACK URL') }} <span class="required">*</span></label>
                                                <input class="form-control" type="text" name="GOOGLE_REDIRECT_URI" value="{{ env('GOOGLE_REDIRECT_URI') }}" placeholder="{{ __('Please enter CALLBACK URL') }}">
                                                <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Facebook Login Settings -->
                                <div class="tab-pane fade" id="pills-Facebook-Login" role="tabpanel" aria-labelledby="pills-Facebook-Login-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="FACEBOOK_CLIENT_ID" class="form-label">{{ __('FACEBOOK CLIENT ID') }} <span class="required">*</span></label>
                                                <input class="form-control" type="text" name="FACEBOOK_CLIENT_ID" value="{{ env('FACEBOOK_CLIENT_ID') }}" placeholder="{{ __('Please enter FACEBOOK CLIENT ID') }}">
                                                <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="FACEBOOK_CLIENT_SECRET" class="form-label">{{ __('FACEBOOK SECRET KEY') }} <span class="required">*</span></label>
                                                <input class="form-control" type="password" name="FACEBOOK_CLIENT_SECRET" value="{{ env('FACEBOOK_CLIENT_SECRET') }}" id="fbsecret" placeholder="{{ __('Please enter FACEBOOK SECRET KEY') }}">
                                                <div class="form-control-icon"><i class="flaticon-password"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="FB_CALLBACK_URL" class="form-label">{{ __('CALLBACK URL') }} <span class="required">*</span></label>
                                                <input class="form-control" type="text" name="FB_CALLBACK_URL" value="{{ env('FACEBOOK_REDIRECT') }}" placeholder="{{ __('Please enter CALLBACK URL') }}">
                                                <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Gitlab Login Settings -->
                                <div class="tab-pane fade" id="pills-Gitlab-Login" role="tabpanel" aria-labelledby="pills-Gitlab-Login-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="GITLAB_CLIENT_ID" class="form-label">{{ __('GITLAB CLIENT ID') }} <span class="required">*</span></label>
                                                <input class="form-control" type="text" name="GITLAB_CLIENT_ID" value="{{ env('GITLAB_CLIENT_ID') }}" placeholder="{{ __('Please enter CLIENT ID') }}">
                                                <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="GITLAB_CLIENT_SECRET" class="form-label">{{ __('GITLAB SECRET KEY') }} <span class="required">*</span></label>
                                                <input class="form-control" type="password" name="GITLAB_CLIENT_SECRET" value="{{ env('GITLAB_CLIENT_SECRET') }}" id="gitsecret" placeholder="{{ __('Please enter CLIENT SECRET KEY') }}">
                                                <div class="form-control-icon"><i class="flaticon-password"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="GITLAB_CALLBACK_URL" class="form-label">{{ __('GITLAB CALLBACK URL') }} <span class="required">*</span></label>
                                                <input class="form-control" type="text" name="GITLAB_CALLBACK_URL" value="{{ env('GITLAB_REDIRECT_URI') }}" placeholder="{{ __('Please enter CALLBACK URL') }}">
                                                <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- LinkedIn Login Settings -->
                                <div class="tab-pane fade" id="pills-LinkedIn-Login" role="tabpanel" aria-labelledby="pills-LinkedIn-Login-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="LINKEDIN_CLIENT_ID" class="form-label">{{ __('LINKEDIN CLIENT ID') }} <span class="required">*</span></label>
                                                <input class="form-control" type="text" name="LINKEDIN_CLIENT_ID" value="{{ env('LINKEDIN_CLIENT_ID') }}" placeholder="{{ __('Please enter LINKEDIN CLIENT ID') }}">
                                                <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="LINKEDIN_CLIENT_SECRET" class="form-label">{{ __('LINKEDIN SECRET KEY') }} <span class="required">*</span></label>
                                                <input class="form-control" type="password" name="LINKEDIN_CLIENT_SECRET" value="{{ env('LINKEDIN_CLIENT_SECRET') }}" id="linkedinSecret" placeholder="{{ __('Please enter LINKEDIN SECRET KEY') }}">
                                                <div class="form-control-icon"><i class="flaticon-password"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="LINKEDIN_CALLBACK_URL" class="form-label">{{ __('LINKEDIN CALLBACK URL') }} <span class="required">*</span></label>
                                                <input class="form-control" type="text" name="LINKEDIN_CALLBACK_URL" value="{{ env('LINKEDIN_REDIRECT_URI') }}" placeholder="{{ __('Please enter CALLBACK URL') }}">
                                                <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- GitHub Login Settings -->
                                <div class="tab-pane fade" id="pills-Github-Login" role="tabpanel" aria-labelledby="pills-Github-Login-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="GITHUB_CLIENT_ID" class="form-label">{{ __('GITHUB CLIENT ID') }} <span class="required">*</span></label>
                                                <input class="form-control" type="text" name="GITHUB_CLIENT_ID" value="{{ env('GITHUB_CLIENT_ID') }}" placeholder="{{ __('Please enter GITHUB CLIENT ID') }}">
                                                <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="GITHUB_CLIENT_SECRET" class="form-label">{{ __('GITHUB SECRET KEY') }} <span class="required">*</span></label>
                                                <input class="form-control" type="password" name="GITHUB_CLIENT_SECRET" value="{{ env('GITHUB_CLIENT_SECRET') }}" id="githubSecret" placeholder="{{ __('Please enter GITHUB SECRET KEY') }}">
                                                <div class="form-control-icon"><i class="flaticon-password"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="GITHUB_CALLBACK_URL" class="form-label">{{ __('GITHUB CALLBACK URL') }} <span class="required">*</span></label>
                                                <input class="form-control" type="text" name="GITHUB_CALLBACK_URL" value="{{ env('GITHUB_REDIRECT_URI') }}" placeholder="{{ __('Please enter CALLBACK URL') }}">
                                                <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Amazon Login Settings -->
                                <div class="tab-pane fade" id="pills-Amazon-Login" role="tabpanel" aria-labelledby="pills-Amazon-Login-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="AMAZON_CLIENT_ID" class="form-label">{{ __('AMAZON CLIENT ID') }} <span class="required">*</span></label>
                                                <input class="form-control" type="text" name="AMAZON_CLIENT_ID" value="{{ env('AMAZON_CLIENT_ID') }}" placeholder="{{ __('Please enter AMAZON CLIENT ID') }}">
                                                <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="AMAZON_CLIENT_SECRET" class="form-label">{{ __('AMAZON SECRET KEY') }} <span class="required">*</span></label>
                                                <input class="form-control" type="password" name="AMAZON_CLIENT_SECRET" value="{{ env('AMAZON_CLIENT_SECRET') }}" id="amazonSecret" placeholder="{{ __('Please enter AMAZON SECRET KEY') }}">
                                                <div class="form-control-icon"><i class="flaticon-password"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="form-group">
                                                <label for="AMAZON_CALLBACK_URL" class="form-label">{{ __('AMAZON CALLBACK URL') }} <span class="required">*</span></label>
                                                <input class="form-control" type="text" name="AMAZON_CALLBACK_URL" value="{{ env('AMAZON_CALLBACK_URL') }}" placeholder="{{ __('Please enter CALLBACK URL') }}">
                                                <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="flaticon-upload-1"></i> {{ __('Update') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
