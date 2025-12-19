@extends('admin.layouts.master')
@section('title', 'Mail Settings')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
        @slot('heading')
            {{ __('Mail Settings ') }}
        @endslot
        @slot('menu1')
            {{ __('Project Settings') }}
        @endslot
        @slot('menu2')
            {{ __('Mail Settings ') }}
        @endslot
    @endcomponent

    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('mail-setting.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block">
                        <div class="row">
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label for="sender_name" class="form-label">
                                        {{ __('Sender Name') }} <span class="required">*</span>
                                    </label>
                                    <input class="form-control form-control-lg" type="text" name="MAIL_FROM_NAME"
                                           placeholder="{{ __('Please Enter Sender Name') }}" aria-label="Sender Name"
                                           value="{{ old('MAIL_FROM_NAME', $mailFromName) }}">
                                    <div class="form-control-icon"><i class="flaticon-id-card"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-8">
                                            <label for="MAIL_MAILER" class="form-label">
                                                {{ __('Mail Mailer ') }}
                                            </label>
                                            <span class="required">*</span>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-4">
                                            <div class="suggestion-icon float-end">
                                                <div class="tooltip-icon">
                                                    <div class="tooltip">
                                                        <div class="credit-block">
                                                            <small class="recommended-font-size">
                                                                {{ __('(ex. smtp, sendmail, mail)') }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <span class="float-end">
                                                        <i class="flaticon-info"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input class="form-control form-control-lg custom-input" type="text"
                                           name="MAIL_MAILER" placeholder="{{ __('Enter Your Mail Driver') }}"
                                           value="{{ old('MAIL_MAILER', $mailMailer) }}">
                                    <div class="form-control-icon"><i class="flaticon-email"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-8">
                                            <label for="MAIL_HOST" class="form-label">
                                                {{ __('Mail Host') }}
                                            </label>
                                            <span class="required">*</span>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-4">
                                            <div class="suggestion-icon float-end">
                                                <div class="tooltip-icon">
                                                    <div class="tooltip">
                                                        <div class="credit-block">
                                                            <small class="recommended-font-size">
                                                                {{ __('(ex. smtp.yourdomain.com)') }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <span class="float-end"><i class="flaticon-info"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input class="form-control form-control-lg" type="text" name="MAIL_HOST"
                                           placeholder="{{ __('Enter Mail Host') }}" required
                                           value="{{ old('MAIL_HOST', $mailHost) }}">
                                    <div class="form-control-icon"><i class="flaticon-email-4"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-8">
                                            <label for="MAIL_PORT" class="form-label">
                                                {{ __('Mail Port') }}
                                            </label>
                                            <span class="required">*</span>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-4">
                                            <div class="suggestion-icon float-end">
                                                <div class="tooltip-icon">
                                                    <div class="tooltip">
                                                        <div class="credit-block">
                                                            <small class="recommended-font-size">
                                                                {{ __('(ex. 2525,467)') }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <span class="float-end"><i class="flaticon-info"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input class="form-control form-control-lg" type="number" name="MAIL_PORT"
                                           placeholder="{{ __('Enter Your Mail Port') }}" required
                                           value="{{ old('MAIL_PORT', $mailPort) }}">
                                    <div class="form-control-icon"><i class="flaticon-email-2"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label for="MAIL_FROM_ADDRESS" class="form-label">
                                        {{ __('Mail Address') }}<span class="required">*</span>
                                    </label>
                                    <input class="form-control form-control-lg" type="email" name="MAIL_FROM_ADDRESS"
                                           id="MAIL_FROM_ADDRESS" placeholder="{{ __('Enter Your Mail Address') }}"
                                           value="{{ old('MAIL_FROM_ADDRESS', $mailFromAddress) }}" required>
                                    <div class="form-control-icon"><i class="flaticon-email-3"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label for="MAIL_USERNAME" class="form-label">
                                        {{ __('Mail User Name') }}<span class="required">*</span>
                                    </label>
                                    <input class="form-control form-control-lg" type="text" name="MAIL_USERNAME"
                                           placeholder="{{ __('Enter Your Mail User Name') }}" required
                                           value="{{ old('MAIL_USERNAME', $mailUsername) }}">
                                    <div class="form-control-icon"><i class="flaticon-id-card-1"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group mb-3">
                                    <label for="mail-password" class="form-label">
                                        {{ __('Mail Password') }}<span class="required">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input id="mail-password" class="form-control form-control-lg" type="password" placeholder="{{ __('Enter Mail Password') }}" name="MAIL_PASSWORD" value="{{ old('MAIL_PASSWORD', $mailPassword) }}">
                                        <span class="input-group-text" id="toggle-password" style="cursor:pointer;" onclick="togglePasswordVisibility('mail-password')">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                    <div class="form-control-icon"><i class="flaticon-mail"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-10 col-8">
                                            <label for="MAIL_ENCRYPTION" class="form-label">
                                                {{ __('Mail Encryption') }}
                                            </label>
                                            <span class="required">*</span>
                                        </div>
                                        <div class="col-lg-4 col-md-2 col-4">
                                            <div class="suggestion-icon float-end">
                                                <div class="tooltip-icon">
                                                    <div class="tooltip">
                                                        <div class="credit-block">
                                                            <small class="recommended-font-size">
                                                                {{ __('(ex. TLS/SSL)') }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <span class="float-end"><i class="flaticon-info"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input class="form-control form-control-lg custom-input" type="text"
                                           name="MAIL_ENCRYPTION"
                                           value="{{ old('MAIL_ENCRYPTION', $mailEncryption) }}"
                                           placeholder="{{ __('Enter Your Mail Encryption') }}">
                                    <div class="form-control-icon"><i class="flaticon-encrypted"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-8">
                                            <label for="welcome_status" class="form-label">
                                                {{ __('Welcome Email') }}
                                            </label>
                                            <span class="required">*</span>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-4">
                                            <div class="suggestion-icon float-end">
                                                <div class="tooltip-icon">
                                                    <div class="tooltip">
                                                        <div class="credit-block">
                                                            <small class="recommended-font-size">
                                                                {{ __('(If you enable it, a welcome email will be sent
                                                                to users register email id, make sure you updated your
                                                                mail setting in Site Setting >> Mail Settings before
                                                                enable it.)') }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <span class="float-end"><i class="flaticon-info"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                               id="welcome_status" name="welcome_status" value="1"
                                               {{ old('welcome_status', $settings->welcome_status) ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="status">
                                    <div class="form-group">
                                        <label for="verify_status" class="form-label">{{ __('Verify Email') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="verify_status" name="verify_status" value="1"
                                                   {{ old('verify_status', $settings->verify_status) ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 me-2" title="{{ __('Submit') }}">
                        <i class="flaticon-upload-1"></i> {{ __('Submit') }}
                    </button>
                    <a type="button" class="btn btn-secondary mt-3" title="{{ __('Test') }}" data-bs-toggle="modal"
                       data-bs-target="#exampleModal">
                        <i class="flaticon-email-5"></i> {{ __('Test') }}
                    </a>
                </form>
                <!-- Modal for testing mail -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('Email Test') }}</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <form action="{{ route('testsend.email') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input class="form-control form-control-lg" type="email"
                                               name="sender_email" placeholder="{{ __('Enter Your Mail Address') }}"
                                               required>
                                        <div class="form-control-icon form-control-icon-one">
                                            <i class="flaticon-email-3"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        {{ __('Close') }}
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Test Email Send') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePasswordVisibility(fieldId) {
        console.log('Toggling visibility for field ID:', fieldId);
        const field = document.getElementById(fieldId);
        const icon = document.getElementById('toggle-password');
        console.log('Field found:', field, 'Icon found:', icon);
        if (field && icon) {
            const eyeIcon = icon.querySelector('i');
            if (field.type === 'password') {
                field.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
                console.log('Changed to text, updated icon to fa-eye-slash');
            } else {
                field.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
                console.log('Changed to password, updated icon to fa-eye');
            }
        } else {
            console.error('Field or icon not found for ID:', fieldId, 'Field:', field, 'Icon:', icon);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Optional: Add any initialization if needed
    });
</script>
@endpush