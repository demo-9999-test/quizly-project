@extends('admin.layouts.master')
@section('title', 'PWA Setting')
@section('main-container')

    <div class="dashboard-card">
        @component('admin.components.breadcumb',['thirdactive' => 'active'])
        @slot('heading')
        {{ __('PWA Settings ') }}
        @endslot
        @slot('menu1')
        {{ __('Front Settings') }}
        @endslot
        @slot('menu2')
        {{ __('PWA Settings ') }}
        @endslot
        @endcomponent

        <div class="contentbar ">
            @include('admin.layouts.flash_msg')
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <!-- form code start -->
                    <form action="{{ route('pwa.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="client-detail-block">
                            <div class="card-importnat-note">
                                <div class="col-lg-12 col-md-12">
                                    <small class="text-success process-fonts"><i class="flaticon-info me-2"></i>
                                        {{ __('Progessive Web App Requirements') }}
                                        <ul class="pwa-text-widget">
                                            <li><strong>{{ __('HTTPS') }}</strong>
                                                {{ __('must required in your domain (for enable contact your host provider for SSL configuration).') }}
                                            </li>
                                            <li><strong> {{ __('Icons and splash screens') }}</strong>
                                                {{ __('required and to be updated in Icon Settings') }}
                                            </li>
                                            <li>
                                                {{ __('PWA is lite app, When you open it in Mobile Browser its ask for add app in mobile. Its Not APK. You can not submit to Play Store.') }}
                                            </li>
                                            <li>
                                                {{ __('Splash Screen works only on Apple Device.') }}
                                            </li>
                                        </ul>
                                    </small>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label for="hedaing" class="form-label">{{ __('APP Name') }}</label>
                                        <span class="required">*</span>
                                        <input class="form-control" type="text" name="APP_NAME"
                                            placeholder="{{ __('Please Enter APP Name') }}" aria-label="Heading"
                                            value="{{ $appname }}" >
                                        <div class="form-control-icon"><i class="flaticon-id-card-2"></i></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label for="hedaing" class="form-label">{{ __('APP URL') }}</label>
                                        <span class="required">*</span>
                                        <input class="form-control form-control-lg" type="url" name="APP_URL"
                                            placeholder="{{ __('Please Enter APP URL') }}" aria-label="Heading"
                                            value="{{ $appurl }}" >
                                        <div class="form-control-icon"><i class="flaticon-app-development"></i></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-6">
                                                <label for="image" class="form-label">{{ __('PWA Icon ') }}</label>
                                                <span class="required">*</span>
                                            </div>
                                            <div class="col-lg-4 col-md-4">
                                                <div class="suggestion-icon float-end">
                                                    <div class="tooltip-icon">
                                                        <div class="tooltip">
                                                            <div class="credit-block">
                                                                <small class="recommended-font-size">{{ __(' (Recommended Size :512x512PX) ') }}</small>
                                                            </div>
                                                        </div>
                                                        <span class="float-end"><i class="flaticon-info"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-9 col-md-9">
                                                <input class="form-control" type="file" name="icon_512" accept=".png" onchange="readURL(this);">
                                                <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                                <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                            </div>
                                            <div class="col-lg-3 col-md-3">
                                                <div class="edit-img-show">
                                                    <img src="{{ url('/images/icons/icon-512x512.png') }}" id="icon_512" alt="{{ __('Pwa Icon') }}"
                                                    class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8">
                                                <label for="image" class="form-label">{{ __('PWA Splash Screen') }}</label>
                                                <span class="required">*</span>
                                            </div>
                                            <div class="col-lg-4 col-md-4">
                                                <div class="suggestion-icon float-end">
                                                    <div class="tooltip-icon">
                                                        <div class="tooltip">
                                                            <div class="credit-block">
                                                                <small class="recommended-font-size">{{ __(' (Recommended Size : 2048x2732PX) ') }}</small>
                                                            </div>
                                                        </div>
                                                        <span class="float-end"><i class="flaticon-info"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-9 col-md-9">
                                                <input class="form-control" type="file" name="splash_2048"
                                                accept=".png" onchange="readURL(this);">
                                                <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                            </div>
                                            <div class="col-lg-3 col-md-3">
                                                <div class="edit-img-show">
                                                    <img src="{{ url('/images/icons/splash-2048x2732.png') }}" id="splash_2048" alt="{{ __('PWA Splash Screen') }}" class="widget-img">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label for="hedaing" class="form-label">{{ __('Theme Color for Header') }}</label>
                                        <div class="form-control">
                                            <input type="color" name="PWA_THEME_COLOR" value="{{ $pwabgcolor }}">
                                            <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label for="hedaing" class="form-label">{{ __('Background Color') }}</label>
                                        <div class="form-control">
                                            <input type="color" name="PWA_BG_COLOR"
                                                value="{{ $pwathemecolor }}">
                                            <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="status">
                                        <div class="form-group">
                                            <label for="verify_status" class="form-label">{{ __('PWA Enable') }}</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    name="PWA_ENABLE" {{ $pwaenable ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3" title="{{ __('Submit') }}"><i class="flaticon-upload-1"></i> {{ __('Submit') }}</button>
                    </form>
                    <!--form code end -->
                </div>
            </div>
        </div>
    </div>
@endsection
