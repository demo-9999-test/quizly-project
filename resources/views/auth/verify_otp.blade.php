<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Verify OTP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ url('admin_theme/assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    @php
        $signuplogin = \App\Models\Setting::first();
    @endphp

    <div id="register" class="login-main-block register-main-block">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg">
                        <div class="card-body p-5">
                            <div class="row">
                                <div class="col-lg-6 d-flex align-items-center">
                                    <div class="register-image">
                                        <img src="{{ asset('/images/signup_img/' . $signuplogin->signup_img) }}"
                                            alt="Signup Image" class="img-fluid">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="register-logo mb-4">
                                        <a href="#">
                                            <img src="{{ asset('images/logo/' . $signuplogin->logo) }}"
                                                alt="Logo" class="img-fluid" id="logo">
                                        </a>
                                    </div>
                                    <div class="register-dtls">
                                        <h4 class="register-heading mb-4">Verify OTP</h4>
                                        @if (session('success'))
                                            <div class="alert alert-success success-message">
                                                {{ session('success') }}
                                            </div>
                                        @endif
                                        @if (session('error'))
                                            <div class="alert alert-danger">
                                                {{ session('error') }}
                                            </div>
                                        @endif

                                        <form method="POST" action="{{ route('verify.otp.submit') }}" id="otpForm">
                                            @csrf
                                            <input type="hidden" id="userContact" value="{{ session('mobile') ?? session('email') }}">
                                            <div class="mb-3">
                                                <label for="otp" class="form-label">Enter OTP <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" placeholder="OTP" name="otp" required id="otp">
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
                                            </div>
                                            <input type="hidden" id="userContact" value="{{ session('mobile') ?? session('email') }}">
                                        </form>

                                        <div id="timerSection" class="text-center mb-3">
                                            Resend OTP in <span id="timer" class="fw-bold text-primary">30</span> seconds
                                        </div>
                                        <div id="resendSection" class="text-center" style="display: none;">
                                            <a id="resendLink" class="text-primary text-decoration-none cursor-pointer">Resend OTP</a>
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
    <script src="{{ url('assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        var baseUrl = "{{ url('/') }}";
    </script>
    <script src="{{ asset('admin_theme/assets/js/otp-verification.js') }}"></script>
</body>
</html>
