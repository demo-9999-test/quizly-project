@extends('admin.layouts.master')
@section('title', 'Cockpit')
@section('main-container')
<!-------- Dashboard-card start ----------------->
    <div class="dashboard-card">
        @component('admin.components.breadcumb', ['thirdactive' => 'active'])
            @slot('heading')
                {{ __('Cockpit') }}
            @endslot
            @slot('menu1')
                {{ __('Projects Settings') }}
            @endslot
            @slot('menu2')
                {{ __('Cockpit') }}
            @endslot
        @endcomponent
        <div class="contentbar ">
            @include('admin.layouts.flash_msg')
            <div class="client-detail-block">
                <h5 class="block-heading"> {{ __('Cockpit Settings') }}</h5>
                <!-- Form  Code start --->
                <form action="{{ route('cockpit.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row ">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="app_status" class="form-label">{{ __('Right Click ') }}</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="app_status"
                                        name="right_click_status" value="1"
                                        {{ $settings->right_click_status == 1 ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="inspect_status" class="form-label">{{ __('Inspect Element') }}</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="inspect_status"
                                        name="inspect_status" value="1"{{ $settings->inspect_status == 1 ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="APP_DEBUG" class="form-label">{{ __('APP Debug') }}</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="APP_DEBUG"
                                            name="APP_DEBUG" value="1" 
                                            {{ config('app.debug') ? 'checked' : '' }}>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <label for="activity_status" class="form-label">{{ __('Activity Log') }}</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="suggestion-icon float-end">
                                            <div class="tooltip-icon">
                                                <div class="tooltip">
                                                    <div class="credit-block">
                                                        <small
                                                            class="recommended-font-size">{{ __('(Enable Users Activity
                                                                                                                    Logs for Login/Register)') }}</small>
                                                    </div>
                                                </div>
                                                <span class="float-end"><i class="flaticon-info"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="activity_status"
                                        name="activity_status" value="1"
                                        {{ $settings->activity_status == 1 ? 'checked' : '' }}>
                                </div>


                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <label for="cookie_status" class="form-label">{{ __('Cookie Notice ') }}</label>
                                    </div>

                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="cookie_status"
                                        name="cookie_status" value="1"
                                        {{ $settings->cookie_status == 1 ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group hidden" id="CookieMsg">
                                <label for="" class="form-label">{{ __('Message') }}</label>
                                <input class="form-control form-control-lg" type="text" name="message"
                                    placeholder="Message" aria-label="" value="{{ $settings->message }}"
                                    min="0">
                                <div class="form-control-icon"><i class="flaticon-gross"></i></div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" title=" {{ __('Update') }}"><i
                            class="flaticon-refresh"></i>
                        {{ __('Update') }}</button>
                </form>
                <!-- Form Code end -->
            </div>
        </div>
    </div>
    <!-------- Dashboard-card end ----------------->
    @endsection
