@extends('admin.layouts.master')
@section('title', 'SMS Settings')
@section('main-container')
<div class="dashboard-card">

    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('SMS Settings ') }}
    @endslot
    @slot('menu1')
    {{ __('Project Settings') }}
    @endslot
    @slot('menu2')
    {{ __('SMS Settings ') }}
    @endslot
    @endcomponent

    <div class="contentbar ">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-2 col-md-3">
                <div class="client-detail-block mb-4 d-flex align-items-start">
                    <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                                title="{{ __('Twilio ') }}" data-bs-target="#v-pills-home" type="button" role="tab"
                                aria-controls="v-pills-home" aria-selected="true"><img
                                    src="{{ url('images/sms/twillo.png') }}" alt="{{ __('twillo') }}"
                                    class="tabs-img"></button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-10 col-md-9">
                <div class="client-detail-block">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                            aria-labelledby="v-pills-home-tab" tabindex="0">
                            <!-- Form code start -->
                            <form action="{{ route('twilio.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <h5 class="block-heading"> {{ __('Twilio') }}</h5>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label for="client_name" class="form-label">{{ __('Twilio SID') }}<span
                                                    class="required">*</span></label>
                                            <input type="password" name="twilio_sid" id="twilio_sid"
                                                    class="form-control" value="{{ $twilio_sid }}"
                                                    placeholder="Please Enter Twilio SID">

                                            <div class="form-control-icon"><i class="flaticon-id-card"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label for="client_name" class="form-label">{{ __('Twilio Auth Token')
                                                }}<span class="required">*</span></label>
                                            <input type="password" name="twilio_auth_token" id="twilio_auth"
                                                    class="form-control" value="{{ $twilio_auth_token }}"
                                                    placeholder="Please Enter Twilio Auth Token">
                                            <div class="form-control-icon"><i class="flaticon-coin"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label for="client_name" class="form-label">{{ __('Twilio Number') }}<span
                                                    class="required">*</span></label>
                                           <input type="password" name="twilio_number" id="twilio_number"
                                                    class="form-control" value="{{ $twilio_number }}"
                                                    placeholder="Please Enter Twilio Number">
                                            <div class="form-control-icon"><i class="flaticon-telephone"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4">
                                                    <label for="status" class="form-label">{{ __('Status') }}</label>
                                                </div>
                                                <div class="col-lg-2 col-md-2">
                                                    <div class="suggestion-icon float-end">
                                                        <div class="tooltip-icon">
                                                            <div class="tooltip">
                                                                <div class="credit-block">
                                                                    <small class="recommended-font-size">{{ __('(Enable for OTP Verification While Registering New User)') }}</small>
                                                                </div>
                                                            </div>
                                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                           <div class="form-check form-switch">
                                                <!-- Always send "0" when unchecked -->
                                                <input type="hidden" name="twillio_enable" value="0">

                                                <!-- Send "1" if checked -->
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="twillio" name="twillio_enable" value="1"
                                                    {{ old('twillio_enable') == '1' || (!old('twillio_enable') && $settings->twillio_enable == 1) ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-secondary mt-3 me-2" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" title="{{ __('Show Key') }}">
                                    <i class="flaticon-view"></i> {{ __('Show Key') }}
                                </button>

                                <button type="submit" class="btn btn-primary mt-3" title="{{ __('Update') }}"><i
                                        class="flaticon-refresh"></i>
                                    {{ __('Update') }}</button>
                            </form>
                            <!-- Form code end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal start -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('Show Keys') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="image" class="form-label">{{ __('User Login Password') }}<span
                            class="required">*</span></label>
                    <input id="confirm_password" class="form-control" type="password"
                        placeholder="{{ __('Please Enter Your Password') }}" aria-label="" name="password" required>
                    <div class="form-control-icon"><i class="flaticon-key"></i></div>
                    <span class="fa fa-fw fa-eye field-icon toggle-password"
                        onclick="togglePasswordVisibility('confirm_password')"></span>
                </div>
                <div id="message" class="text-danger"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" title="{{ __('Close') }}" data-bs-dismiss="modal">
                    {{ __('Close') }}</button>
                <button type="button" class="btn btn-primary smssubmitPassword" title="{{ __('Submit') }}"
                    id="smssubmitPassword">{{ __('Submit') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal end -->

<!-- JavaScript -->
 <script>
document.getElementById('twillio').addEventListener('change', function () {
    console.log('Switch is now:', this.checked ? 'ON' : 'OFF');
});
</script>

<script>
document.getElementById('smssubmitPassword').addEventListener('click', function () {
    const password = document.getElementById('confirm_password').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('{{ route('verify.password') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ password: password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            $('#exampleModal').modal('hide');

            // Show keys as text and unlock editing
            const inputs = ['twilio_sid', 'twilio_auth', 'twilio_number'];
            inputs.forEach(id => {
                const input = document.getElementById(id);
                input.type = 'text';
                input.removeAttribute('readonly');
            });

        } else {
            document.getElementById('message').textContent = data.message || 'Incorrect password';
        }
    })
    .catch(error => {
        document.getElementById('message').textContent = 'Server error. Try again.';
        console.error(error);
    });
});
</script>


@endsection