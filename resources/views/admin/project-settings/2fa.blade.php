@extends('admin.layouts.master')
@section('title', 'Two Factor Auth')
@section('main-container')

    <div class="dashboard-card">
        @component('admin.components.breadcumb', ['thirdactive' => 'active'])
            @slot('heading')
                {{ __('Two Factor Auth') }}
            @endslot
            @slot('menu2')
                {{ __('Two Factor Auth') }}
            @endslot
        @endcomponent

        <div class="contentbar">
            @include('admin.layouts.flash_msg')
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header bg-white text-black">
                            <h5 class="card-title mb-0">{{ __('Two Factor Authentication (2FA)') }}</h5>
                        </div>
                        <div class="card-body bg-white">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <p>
                                        {{ __('Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.') }}
                                    </p>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                {{ __('1. Scan this QR code with your Google Authenticator App') }}
                                            </h6>
                                            <div class="text-center mt-4">
                                                {!! $QR_Image !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            @if(Auth::user()->google2fa_secret != '' && Auth::user()->is_2fa_enabled == 0)
                                                <form action="{{ route('2fa.enable') }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="2fa_code" class="form-label">
                                                            {{ __('Enter pin from app or above code (Set up Two-Factor Authentication)') }}<sup
                                                                class="text-danger">*</sup>
                                                        </label>
                                                        <input id="2fa_code" min="1" max="6" type="text"
                                                            class="form-control @error('one_time_password') is-invalid @enderror"
                                                            name="one_time_password" required>
                                                        @error('one_time_password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group table-btn mt-4">
                                                        <button type="reset" class="btn btn-secondary" title="{{ __('Reset') }}">
                                                            <i class="flaticon-ban-circle-symbol"></i>{{ __("Reset") }}
                                                        </button>
                                                        <button type="submit" class="btn btn-primary" title="{{ __('Authenticate') }}">
                                                            <i class="flaticon-check-mark"></i>{{ __("Authenticate") }}
                                                        </button>
                                                    </div>
                                                </form>
                                            @else
                                                <form action="{{ route('2fa.disable') }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="2fa_code" class="form-label">
                                                            {{ __('2FA is currently enabled on your account') }}
                                                        </label>
                                                        <p>{{ __('If you are looking to disable Two Factor Authentication. Please confirm your password and Click Disable 2FA Button.') }}</p>

                                                        <input id="2fa_code" type="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            name="password" required>
                                                        @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group table-btn mt-4">
                                                        <button type="reset" class="btn btn-secondary" title="{{ __('Reset') }}">
                                                            <i class="flaticon-ban-circle-symbol"></i>{{ __("Reset") }}
                                                        </button>

                                                        <button type="submit" class="btn btn-danger" title="{{ __('Disable') }}">
                                                            <i class="flaticon-check-mark"></i>{{ __("Disable") }}
                                                        </button>
                                                    </div>
                                                </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
