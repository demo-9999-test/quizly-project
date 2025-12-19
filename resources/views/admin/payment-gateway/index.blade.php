@extends('admin.layouts.master')
@section('title', 'Payment Gateways')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['secondaryactive' => 'active'])
    @slot('heading')
    {{ __('Payment Gateways ') }}
    @endslot
    @slot('menu1')
    {{ __('Payment Gateways') }}
    @endslot
    @endcomponent

    <div class="contentbar  ">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-2 col-md-3">
                <div class="client-detail-block payment-gateway-page">
                    <div class="d-flex align-items-start scroll-down">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-stripe-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-stripe" type="button" role="tab" aria-controls="v-pills-stripe"
                                aria-selected="true">
                                <img src="{{ url('images/payment_img/stripe.png') }}" alt="{{__('stripe')}}" class="tabs-img">
                            </button>
                            <button class="nav-link" id="v-pills-paypal-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-paypal" type="button" role="tab" aria-controls="v-pills-paypal"
                                aria-selected="false"> <img src="{{ url('images/payment_img/paypal.png') }}"
                                    alt="{{__('paypal')}}" class="tabs-img">
                            </button>
                            <button class="nav-link" id="v-pills-razorpay-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-razorpay" type="button" role="tab"
                                aria-controls="v-pills-razorpay" aria-selected="false"> <img
                                    src="{{ url('images/payment_img/razorpay.png') }}" alt="{{__('razorpay')}}"
                                    class="tabs-img">
                            </button>
                            <button class="nav-link" id="v-pills-paystack-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-paystack" type="button" role="tab"
                                aria-controls="v-pills-paystack" aria-selected="false"><img
                                    src="{{ url('images/payment_img/paystack.png') }}" alt="{{__('paystack')}}"
                                    class="tabs-img">
                            </button>
                            <button class="nav-link" id="v-pills-paytm-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-paytm" type="button" role="tab" aria-controls="v-pills-paytm"
                                aria-selected="false"><img src="{{ url('images/payment_img/paytm.png') }}" alt="{{__('paytm')}}"
                                    class="tabs-img">
                            </button>
                            <button class="nav-link" id="v-pills-omise-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-omise" type="button" role="tab" aria-controls="v-pills-omise"
                                aria-selected="false"><img src="{{ url('images/payment_img/omise.png') }}" alt="{{__('omise')}}"
                                    class="tabs-img">
                            </button>
                            <button class="nav-link" id="v-pills-moli-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-moli" type="button" role="tab" aria-controls="v-pills-moli"
                                aria-selected="false"><img src="{{ url('images/payment_img/moli.png') }}" alt="{{__('molie')}}"
                                    class="tabs-img">
                            </button>

                            <button class="nav-link" id="v-pills-rave-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-rave" type="button" role="tab" aria-controls="v-pills-rave"
                                aria-selected="false"><img src="{{ url('images/payment_img/rave.png') }}" alt="{{__('rave')}}"
                                    class="tabs-img"></button>
                            <button class="nav-link" id="v-pills-braintree-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-braintree" type="button" role="tab"
                                aria-controls="v-pills-braintree" aria-selected="false"><img
                                    src="{{ url('images/payment_img/braintree.png') }}" alt="{{__('braintree')}}"
                                    class="tabs-img"></button>
                            <button class="nav-link" id="v-pills-midtrans-logo-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-midtrans-logo" type="button" role="tab"
                            aria-controls="v-pills-midtrans-logo" aria-selected="false"><img
                                src="{{ url('images/payment_img/midtrans-logo.png') }}" alt="{{__('midtrans-logo')}}"
                                class="tabs-img"></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-10 col-md-9">
                <div class="client-detail-block">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-stripe" role="tabpanel"
                            aria-labelledby="v-pills-stripe-tab" tabindex="0">
                            <h5 class="block-heading">{{ __('STRIPE ') }}</h5>
                            <form id="paymentForm" action="{{ route('admin.settings.stripe.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-5">
                                        <div class="form-group">
                                            <label for="STRIPE_KEY" class="form-label">{{ __('Stripe Key') }}</label>
                                            <span class="required"> *</span>
                                            <input type="password" id="stripe_key" name="stripe_key" class="form-control" placeholder="Please Enter Your Key"
                                                aria-label="STRIPE_KEY" value="{{ $settings->stripe_key }}" required>
                                            <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-5">
                                        <div class="form-group">
                                            <label for="Stripe Secret Key" class="form-label">{{ __('Stripe Secret Key')
                                                }}</label><span class="required"> *</span>
                                            <input type="password" id="stripe_secret_key" name="stripe_secret_key" class="form-control" placeholder="Please Enter Your Stripe Secret Key"
                                                aria-label="Stripe Secret Key"
                                                value="{{ $settings->stripe_secret_key }}" required>
                                            <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-2">
                                        <div class="form-group">
                                            <label for="stripe_status" class="form-label">{{ __('Status') }}</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="stripe_status" name="stripe_enable" value="1" {{
                                                    $settings->stripe_enable == '1' ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-secondary mt-3 me-2" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" id="showKeyBtn" title="{{ __('Show Key') }}">
                                    <i class="flaticon-view"></i> {{ __('Show Key') }}
                                </button>
                                <button type="submit" class="btn btn-primary mt-3" title="{{ __('Update') }}">
                                    <i class="flaticon-refresh"></i>{{ __('Update') }}
                                </button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-paypal" role="tabpanel"
                            aria-labelledby="v-pills-paypal-tab" tabindex="0">
                            <h5 class="block-heading">{{ __('PAYPAL') }}</h5>
                            <form action="{{ route('admin.settings.paypal.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label for="paypal-client-id" class="form-label">{{ __('PayPal Client ID')
                                                }}<span class="required"> *</span></label>
                                            <input class="form-control" type="password"
                                                value="{{ $settings->paypal_client_id }}" name="paypal_client_id"
                                                id="paypal_client_id"
                                                placeholder="{{ __('Please Enter Your PayPal Client ID') }}"
                                                aria-label="paypal_client_id" required>
                                            <div class="form-control-icon"><i class="flaticon-id"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label for="paypal-secret-id" class="form-label">{{ __('PayPal Secret ID')
                                                }}<span class="required">*</span></label>
                                            <input class="form-control" type="password"
                                                value="{{ $settings->paypal_secret_id }}" name="paypal_secret_id"
                                                id="paypal_secret_id"
                                                placeholder="{{ __('Please Enter Your PayPal Secret ID') }}"
                                                aria-label="paypal_secret_id" required>
                                            <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8">
                                                    <label for="paypal-mode" class="form-label">{{ __('PayPal Mode')
                                                        }}</label>
                                                    <span class="required">*</span>
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <div class="suggestion-icon float-end">
                                                        <div class="tooltip-icon">
                                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                                            <div class="tooltip">
                                                                <div class="credit-block">
                                                                    <small class="recommended-font-size">{{ __('For Test
                                                                        use "sandbox" and for Live use "live"')
                                                                        }}</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="form-control" type="text" name="PAYPAL_MODE" id="paypal-mode"
                                                placeholder="Please Enter Your PayPal Mode" aria-label="paypal-mode"
                                                value="{{ $env_files['PAYPAL_MODE'] }}" required>
                                            <div class="form-control-icon"><i class="flaticon-clerk"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6">
                                        <div class="form-group">
                                            <label for="paypal_enable" class="form-label">{{ __('Status') }}</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="paypal_enable" name="paypal_enable" value="1" {{
                                                    $settings->paypal_enable == '1' ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-secondary mt-3 me-2" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <i class="flaticon-view"></i> {{ __('Show Key') }}
                                </button>
                                <button type="submit" class="btn btn-primary mt-3" title="{{ __('Update') }}">
                                    <i class="flaticon-refresh"></i>{{ __('Update') }}
                                </button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-razorpay" role="tabpanel"
                            aria-labelledby="v-pills-razorpay-tab" tabindex="0">
                            <h5 class="block-heading">{{ __('RAZORPAY') }}</h5>
                            <form action="{{ route('payment_gateway.razorpay_store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-5">
                                        <div class="form-group">
                                            <label for="razorpay_key" class="form-label">{{ __('Razorpay Key') }}<span
                                                    class="required">*</span></label>
                                            <input class="form-control" type="password" name="razorpay_key"
                                                id="razorpay_key" value="{{ $settings->razorpay_key }}"
                                                placeholder="{{ __('Please Enter Your Razorpay Key') }}"
                                                aria-label="razorpay_key" required>
                                            <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-5">
                                        <div class="form-group">
                                            <label for="razorpay_secret_key" class="form-label">{{ __('Razorpay Secret
                                                Key') }}<span class="required">*</span></label>
                                            <input class="form-control" type="password"
                                                value="{{ $settings->razorpay_secret_key }}" name="razorpay_secret_key"
                                                id="razorpay_secret_key"
                                                placeholder="{{ __('Please Enter Your Razorpay Secret Key') }}"
                                                aria-label="razorpay_secret_key" required>
                                            <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-2">
                                        <div class="status">
                                            <div class="form-group">
                                                <label for="razorpay-enable" class="form-label">{{ __('Status')
                                                    }}</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="razorpay_enable" name="razorpay_enable" value="1" {{
                                                        $settings->razorpay_enable == '1' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-secondary mt-3 me-2" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" title="{{ __('Click to Show Key') }}">
                                    <i class="flaticon-view"></i> {{ __('Show Key') }}
                                </button>
                                <button type="submit" class="btn btn-primary mt-3" title="{{ __('Update') }}">
                                    <i class="flaticon-refresh"></i>{{ __('Update') }}
                                </button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-paystack" role="tabpanel"
                            aria-labelledby="v-pills-paystack-tab" tabindex="0">
                            <h5 class="block-heading">{{ __('PAYSTACK') }}</h5>
                            <form action="{{ route('payment_gateway.paystack_store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label for="paystack-public-key" class="form-label">{{ __('PayStack Public
                                                Key') }}<span class="required">*</span></label>
                                            <input class="form-control" type="password" name="paystack_public_key"
                                                id="paystack_public_key" value="{{ $settings->paystack_public_key }}"
                                                placeholder="{{ __('Please Enter Your PayStack Public Key') }}"
                                                aria-label="paystack_public_key" required>
                                            <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label for="paystack-secret-key" class="form-label">{{ __('PayStack Secret
                                                Key') }}<span class="required">*</span></label>
                                            <input class="form-control" type="password" name="paystack_secret_key"
                                                id="paystack_secret_key" value="{{ $settings->paystack_secret_key }}"
                                                placeholder="{{ __('Please Enter Your PayStack Secret Key') }}"
                                                aria-label="paystack_secret_key" required>
                                            <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label for="paystack-payment-url" class="form-label">{{ __('PayStack Payment
                                                Url') }}<span class="required">*</span></label>
                                            <input class="form-control" type="url" name="PAYSTACK_PAYMENT_URL"
                                                id="paystack-payment-url"
                                                value="{{ $env_files['PAYSTACK_PAYMENT_URL'] }}"
                                                placeholder="{{ __('Please Enter Your PayStack Payment Url') }}"
                                                aria-label="paystack-payment-url" required>
                                            <div class="form-control-icon"><i class="flaticon-link-1"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label for="paystack-callback-url" class="form-label">{{ __('PayStack
                                                Callback URL') }}<span class="required">*</span></label>
                                            <input class="form-control" type="url" name="PAYSTACK_CALLBACK_URL"
                                                id="paystack-callback-url"
                                                value="{{ $env_files['PAYSTACK_CALLBACK_URL'] }}"
                                                placeholder="{{ __('Please Enter Your PayStack Callback URL') }}"
                                                aria-label="paystack-callback-url" required>
                                            <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label for="paystack-merchant-email" class="form-label">{{ __('PayStack
                                                Merchant Email') }}<span class="required">*</span></label>
                                            <input class="form-control" type="email" name="PAYSTACK_MERCHANT_EMAIL"
                                                id="paystack-merchant-email"
                                                placeholder="{{ __('Please Enter Your PayStack Merchant Email') }}"
                                                aria-label="paystack-merchant-email"
                                                value="{{ $env_files['PAYSTACK_MERCHANT_EMAIL'] }}" required>
                                            <div class="form-control-icon"><i class="flaticon-email"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="paystack-enable" class="form-label">{{ __('Status') }}</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="paystack_enable" name="paystack_enable" value="1" {{
                                                    $settings->paystack_enable == '1' ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-secondary mt-3 me-2" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" title="{{ __('Show Key') }}">
                                    <i class="flaticon-view"></i> {{ __('Show Key') }}
                                </button>
                                <button type="submit" class="btn btn-primary mt-3" title="{{ __('Update') }}">
                                    <i class="flaticon-refresh"></i>{{ __('Update') }}
                                </button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-paytm" role="tabpanel"
                            aria-labelledby="v-pills-paytm-tab" tabindex="0">
                            <h5 class="block-heading">{{ __('PAYTM ') }}</h5>
                            <form action="{{ route('payment_gateway.paytm_store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8">
                                                    <label for="paytm-env" class="form-label">{{ __('PAYTM Enviroment')}}<span class="required">*</span></label>
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <div class="suggestion-icon float-end">
                                                        <div class="tooltip-icon">
                                                            <div class="tooltip">
                                                                <div class="credit-block">
                                                                    <small class="recommended-font-size">
                                                                        {{ __('For Test use "local" and for Live use
                                                                        "production"') }}
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="form-control" type="text" name="PAYTM_ENVIRONMENT"
                                                id="paytm_env"
                                                placeholder="{{ __('Please Enter Your PAYTM Enviroment') }}"
                                                aria-label="paytm_env" value="{{ $env_files['PAYTM_ENVIRONMENT'] }}"
                                                required>
                                            <div class="form-control-icon"><i class="flaticon-people"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label for="PAYTM_MERCHANT_ID" class="form-label">{{ __('PAYTM Merchant ID')
                                                }}<span class="required">*</span></label>
                                            <input class="form-control" type="password" name="paytm_merchant_id"
                                                id="paytm_merchant_id"
                                                placeholder="{{ __('Please Enter Your PAYTM Merchant ID') }}"
                                                aria-label="paytm_merchant_id"
                                                value="{{ $settings->paytm_merchant_id }}" required>
                                            <div class="form-control-icon"><i class="flaticon-id"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label for="PAYTM_MERCHANT_KEY" class="form-label">{{ __('PAYTM Merchant
                                                Key') }}<span class="required">*</span></label>
                                            <input class="form-control" type="password" name="paytm_merchant_key"
                                                id="paytm_merchant_key"
                                                placeholder="{{ __('Please Enter Your PAYTM Merchant Key') }}"
                                                aria-label="paytm_merchant_key"
                                                value="{{ $settings->paytm_merchant_key }}" required>
                                            <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label for="PAYTM_MERCHANT_WEBSITE" class="form-label">{{ __('PAYTM Merchant
                                                Website') }}<span class="required">*</span></label>
                                            <input class="form-control" type="url" name="PAYTM_MERCHANT_WEBSITE"
                                                id="paytm_merchant_website"
                                                placeholder="{{ __('Please Enter Your PAYTM Merchant Website') }}"
                                                aria-label="PAYTM Merchant Website"
                                                value="{{ $env_files['PAYTM_MERCHANT_WEBSITE'] }}" required>
                                            <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label for="PAYTM_CHANNEL" class="form-label">{{ __('PAYTM Channel') }}<span
                                                    class="required">*</span></label>
                                            <input class="form-control" type="text" name="PAYTM_CHANNEL"
                                                id="paytm_channel"
                                                placeholder="{{ __('Please Enter Your PAYTM Channel') }}"
                                                aria-label="PAYTM Channel" value="{{ $env_files['PAYTM_CHANNEL'] }}"
                                                required>
                                            <div class="form-control-icon"><i class="flaticon-tutorial"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label for="PAYTM_INDUSTRY_TYPE" class="form-label">{{ __('PAYTM Industry Type') }}<span
                                                    class="required">*</span></label>
                                            <input class="form-control" type="text" name="PAYTM_INDUSTRY_TYPE"
                                                id="PAYTM_INDUSTRY_TYPE"
                                                placeholder="{{ __('Please Enter Your PAYTM Channel') }}"
                                                aria-label="PAYTM Industy Type" value="{{ $env_files['PAYTM_INDUSTRY_TYPE'] }}"
                                                required>
                                            <div class="form-control-icon"><i class="flaticon-tutorial"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="paytm_status" class="form-label">{{ __('Status') }}</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="paytm_status" name="paytm_enable" value="1" {{
                                                    $settings->paytm_enable == '1' ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-secondary mt-3 me-2" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" title="{{ __('Click to Show Key') }}">
                                    <i class="flaticon-view"></i> {{ __('Show Key') }}
                                </button>
                                <button type="submit" class="btn btn-primary mt-3" title="{{ __('Update') }}">
                                    <i class="flaticon-refresh"></i>{{ __('Update') }}
                                </button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-omise" role="tabpanel"
                            aria-labelledby="v-pills-omise-tab" tabindex="0">
                            <h5 class="block-heading">{{ __('OMISE ') }}</h5>
                            <form action="{{ route('payment_gateway.omise_store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label for="OMISE_PUBLIC_KEY" class="form-label">{{ __('OMISE PUBLIC KEY ')
                                                }}</label>
                                            <span class="required">*</span>
                                            <input class="form-control" type="password" name="omise_public_key"
                                                id="omise_public_key"
                                                placeholder="{{ __('Please Enter Your OMISE PUBLIC KEY') }}"
                                                aria-label="omise_public_key" value="{{ $settings->omise_public_key }}"
                                                required>
                                            <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label for="OMISE_SECRET_KEY" class="form-label">{{ __('Omise Secret Key')
                                                }}</label>
                                            <span class="required">*</span>
                                            <input class="form-control" type="password" name="omise_secret_key"
                                                id="omise_secret_key"
                                                placeholder="{{ __('Please Enter Your Omise Secret Key') }}"
                                                aria-label="omise_secret_key"
                                                value="{{ $settings->omise_secret_key }}" required>
                                            <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label for="OMISE_API_VERSION" class="form-label">{{ __('OMISE API VERSION')
                                                }}</label>
                                            <span class="required">*</span>
                                            <input class="form-control" type="text" name="OMISE_API_VERSION"
                                                id="omise_api_version"
                                                placeholder="{{ __('Please Enter Your OMISE API VERSION') }}"
                                                aria-label="omise_api_version"
                                                value="{{ $env_files['OMISE_API_VERSION'] }}" required>
                                            <div class="form-control-icon"><i class="flaticon-version"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label for="omise_enable" class="form-label">{{ __('Status') }}</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="omise_enable" name="omise_enable" value="1" {{
                                                    $settings->omise_enable == '1' ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-secondary mt-3 me-2" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <i class="flaticon-view"></i> {{ __('Show Key') }}
                                </button>
                                <button type="submit" class="btn btn-primary mt-3" title="{{ __('Update') }}">
                                    <i class="flaticon-refresh"></i>{{ __('Update') }}
                                </button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-moli" role="tabpanel" aria-labelledby="v-pills-moli-tab"
                            tabindex="0">
                            <h5 class="block-heading">{{ __('MOLI ') }}</h5>
                            <form action="{{ route('payment_gateway.mollie_store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8">
                                                    <label for="MOLLIE_KEY" class="form-label">{{ __('MOLI API KEY ')
                                                        }}</label>
                                                    <span class="required">*</span>
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <div class="suggestion-icon float-end">
                                                        <div class="tooltip-icon">
                                                            <div class="tooltip">
                                                                <div class="credit-block">
                                                                    <small class="recommended-font-size">
                                                                        {{ __('Enter Mollie API Key') }}<br>
                                                                        <strong>{{ __('Supported Mollie Currency')
                                                                            }}</strong> <a
                                                                            href="https://docs.mollie.com/payments/multicurrency"
                                                                            target="_blank" title="{{__('Supported Mollie Currency')}}">{{
                                                                            __('https://docs.mollie.com/payments/multicurrency')
                                                                            }}</a>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="form-control" type="password" name="mollie_key"
                                                id="mollie_key"
                                                placeholder="{{ __('Please Enter Your MOLI API KEY') }}"
                                                aria-label="mollie_key" value="{{ $settings->mollie_key }}" required>
                                            <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6">
                                        <div class="form-group">
                                            <label for="mollie_enable" class="form-label">{{ __('Status') }}</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="mollie_enable" name="mollie_enable" value="1" {{
                                                    $settings->mollie_enable == '1' ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-secondary mt-3 me-2" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <i class="flaticon-view"></i>
                                    {{ __(' Show Key') }}
                                </button>
                                <button type="submit" class="btn btn-primary mt-3" title="{{ __('Update') }}">
                                    <i class="flaticon-refresh"></i>{{ __('Update') }}
                                </button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-rave" role="tabpanel" aria-labelledby="v-pills-rave-tab"
                            tabindex="0">
                            <h5 class="block-heading">{{ __('Flutter Rave ') }}</h5>
                            <form action="{{ route('payment_gateway.rave_store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8">
                                                    <label for="FLUTTERWAVE_PUBLIC_KEY" class="form-label">{{ __('RAVE PUBLIC
                                                        KEY ') }}</label>
                                                    <span class="required">*</span>
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <div class="suggestion-icon float-end">
                                                        <div class="tooltip-icon">
                                                            <div class="tooltip">
                                                                <div class="credit-block">
                                                                    <small class="recommended-font-size">
                                                                        {{ __('Public Key: Your Rave publicKey. Sign up
                                                                        on https://rave.flutterwave.com/ to get one from
                                                                        your settings page') }}
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="form-control" type="password" name="flutterwave_public_key"
                                                id="flutterwave_public_key"
                                                placeholder="{{ __('Please Enter Your RAVE PUBLIC KEY') }}"
                                                aria-label="flutterwave_public_key" value="{{ $settings->flutterwave_public_key }}"
                                                required>
                                            <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8">
                                                    <label for="FLUTTERWAVE_SECRET_KEY" class="form-label">{{ __('RAVE SECRET
                                                        KEY ') }}</label>
                                                    <span class="required">*</span>
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <div class="suggestion-icon float-end">
                                                        <div class="tooltip-icon">
                                                            <div class="tooltip">
                                                                <div class="credit-block">
                                                                    <small class="recommended-font-size">
                                                                        {{ __('Secret Key: Your Rave secretKey. Sign up
                                                                        on https://rave.flutterwave.com/ to get one from
                                                                        your settings page') }}
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="form-control" type="password" name="flutterwave_secret_key"
                                                id="flutterwave_secret_key"
                                                placeholder="{{ __('Please Enter Your RAVE SECRET KEY') }}"
                                                aria-label="flutterwave_secret_key" value="{{ $settings->flutterwave_secret_key }}"
                                                required>
                                            <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8">
                                                    <label for="FLUTTERWAVE_ENCRYPTION_KEY" class="form-label">{{ __('RAVE ENCRYPTION KEY ') }}</label>
                                                    <span class="required">*</span>
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <div class="suggestion-icon float-end">
                                                        <div class="tooltip-icon">
                                                            <div class="tooltip">
                                                                <div class="credit-block">
                                                                    <small class="recommended-font-size">
                                                                        {{ __('This is the secret hash for your
                                                                        webhook') }}
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="form-control" type="password" name="flutterwave_encryption_key"
                                                id="flutterwave_encryption_key"
                                                placeholder="{{ __('Please Enter Your RAVE SECRET HASH') }}"
                                                aria-label="flutterwave_encryption_key"
                                                value="{{ $settings->flutterwave_encryption_key }}" required>
                                            <div class="form-control-icon"><i class="flaticon-hash"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6">
                                        <div class="form-group">
                                            <label for="status" class="form-label">{{ __('Status') }}</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="rave_enable" name="rave_enable" value="1" {{
                                                    $settings->rave_enable == '1' ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-secondary mt-3 me-2" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" title="{{ __('Show Key') }}">
                                    <i class="flaticon-view"></i> {{ __('Show Key') }}
                                </button>
                                <button type="submit" class="btn btn-primary mt-3" title="{{ __('Update') }}">
                                    <i class="flaticon-refresh"></i>{{ __('Update') }}
                                </button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-braintree" role="tabpanel"
                            aria-labelledby="v-pills-braintree-tab" tabindex="0">
                            <h5 class="block-heading">{{ __('BrainTree ') }}</h5>
                            <form action="{{ route('payment_gateway.braintree_store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="faq-block">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="BRAINTREE_ENV" class="form-label">{{ __('BrainTree Env') }}
                                                    <span class="required">*</span>
                                                </label>
                                                <input class="form-control" type="text" name="BRAINTREE_ENV"
                                                    id="braintree_env"
                                                    placeholder="{{ __('Please Enter Your BrainTree Env') }}"
                                                    aria-label="paytm_env" value="{{ $env_files['BRAINTREE_ENV'] }}"
                                                    required>
                                                    <div class="form-control-icon"><i class="flaticon-people"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="BRAINTREE_MERCHANT_ID" class="form-label">{{ __('BrainTree
                                                    Merchant ID') }}
                                                    <span class="required">*</span>
                                                </label>
                                                <input class="form-control" type="password" name="braintree_merchant_id"
                                                    id="braintree_merchant_id"
                                                    placeholder="{{ __('Please Enter Your BrainTree Merchant ID') }}"
                                                    aria-label="braintree_merchant_id"
                                                    value="{{ $settings->braintree_merchant_id }}" required>
                                                    <div class="form-control-icon"><i class="flaticon-id"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="BRAINTREE_PUBLIC_KEY" class="form-label">{{ __('BrainTree
                                                    Public Key') }}
                                                    <span class="required">*</span>
                                                </label>
                                                <input class="form-control" type="password" name="braintree_public_key"
                                                    id="braintree_public_key"
                                                    placeholder="{{ __('Please Enter Your BrainTree Public Key') }}"
                                                    aria-label="AWS Default Region"
                                                    value="{{ $settings->braintree_public_key }}" required>
                                                    <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="BRAINTREE_PRIVATE_KEY" class="form-label">{{ __('BrainTree
                                                    Private Key') }}
                                                    <span class="required">*</span>
                                                </label>
                                                <input class="form-control" type="password" name="braintree_private_key"
                                                    id="braintree_private_key"
                                                    placeholder="{{ __('Please Enter Your BrainTree Private Key') }}"
                                                    aria-label="AWS Default Region"
                                                    value="{{ $settings->braintree_private_key }}" required>
                                                    <div class="form-control-icon"><i class="flaticon-private-key"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="braintree_enable" class="form-label">{{ __('Status')
                                                    }}</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="braintree_enable" name="braintree_enable" value="1" {{
                                                        $settings->braintree_enable == '1' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-secondary mt-3 me-2" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" title="{{ __(' Show Key') }}">
                                        <i class="flaticon-view"></i>{{ __('Show Key') }}
                                    </button>
                                    <button type="submit" class="btn btn-primary mt-3" title="{{ __('Update') }}">
                                        <i class="flaticon-refresh"></i>{{ __('Update') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-midtrans-logo" role="tabpanel"
                            aria-labelledby="v-pills-midtrans-logo-tab" tabindex="0">
                            <form action="{{ route('payment_gateway.midtrans_store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="faq-block">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <h5 class="block-heading">{{ __('MIDTRANS PAYMENT') }}</h5>
                                        </div>
                                        <div class="col-lg-6 col-md-6 text-end">
                                            <a href="https://midtrans.com/" class="get_key"><i class="flaticon-key"></i>
                                                {{ __(' Get your keys from here') }}</a>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="MIDTRANS_CLIENT_KEY" class="form-label">{{ __('MID TRANS
                                                    CLIENT KEY') }}<span class="required"> *</span></label>
                                                <input class="form-control" type="password" name="midtrans_client_key"
                                                    id="midtrans_client_key"
                                                    placeholder="{{ __('Please Enter Your MID TRANS CLIENT KEY') }}"
                                                    aria-label="paytm_env"
                                                    value="{{ $settings->midtrans_client_key }}" required>
                                                    <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="MIDTRANS_SERVER_KEY" class="form-label">{{ __('MID TRANS
                                                    SERVER KEY') }}<span class="required"> *</span></label>
                                                <input class="form-control" type="password" name="midtrans_server_key"
                                                    id="midtrans_server_key"
                                                    placeholder="{{ __('Please Enter Your MID TRANS SERVER KEY') }}"
                                                    aria-label="" value="{{ $settings->midtrans_server_key }}"
                                                    required>
                                                    <div class="form-control-icon"><i class="flaticon-key"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="status">
                                                <div class="form-group">
                                                    <label for="MID_TRANS_MODE" class="form-label">{{ __('Live Mode')
                                                        }}</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="MID_TRANS_MODE" name="MID_TRANS_MODE" value="1" {{
                                                            $env_files['MID_TRANS_MODE'] ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="status">
                                                <div class="form-group">
                                                    <label for="midtrans_enable" class="form-label">{{ __('Status')
                                                        }}</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="midtrans_enable" name="midtrans_enable" value="1" {{
                                                            $settings->midtrans_enable == '1' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-secondary mt-3 me-2" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" title="{{ __(' Show Key') }}"><i
                                            class="flaticon-view"></i>
                                        {{ __('Show Key') }}
                                    </button>
                                    <button type="submit" class="btn btn-primary mt-3" title="{{ __('Update') }}">
                                        <i class="flaticon-refresh"></i>{{ __('Update') }}
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

<!-- Modal start -->
<!-- ✅ Modal HTML -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('Show Keys') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="keypassword" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="confirm_password" class="form-label">{{ __('User Login Password') }}
                            <span class="required">*</span></label>
                        <input id="confirm_password" class="form-control" type="password"
                            placeholder="{{ __('Please Enter Your Password') }}" name="password" required>
                        <div class="form-control-icon"><i class="flaticon-key"></i></div>
                        <span class="fa fa-fw fa-eye field-icon toggle-password"
                            onclick="togglePasswordVisibility('confirm_password')"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- STRIPE JS --}}
<script>
document.getElementById('keypassword').addEventListener('submit', function(e) {
    e.preventDefault();

    const password = document.getElementById('confirm_password').value;

    fetch("{{ route('admin.showStripeKeys') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ password: password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const stripeKeyField = document.getElementById('stripe_key');
            const stripeSecretField = document.getElementById('stripe_secret_key');

            // ✅ Update values
            stripeKeyField.value = data.stripe_key;
            stripeSecretField.value = data.secret_key;

            // ✅ Change input type from password to text
            stripeKeyField.type = 'text';
            stripeSecretField.type = 'text';

            // ✅ Hide the modal
            const modalEl = document.getElementById('exampleModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();
        } else {
            alert(data.message || 'Incorrect password!');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Something went wrong.');
    });
});
</script>

{{-- PAYPAL JS --}}
<script>
document.getElementById('keypassword').addEventListener('submit', function(e) {
    e.preventDefault();
    const password = document.getElementById('confirm_password').value;

    fetch("{{ route('admin.showPaypalClientID') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ password: password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const PayPalClientIDField = document.getElementById('paypal_client_id');
            const PayPalSecretIDField = document.getElementById('paypal_secret_id');

            // ✅ Update values
            PayPalClientIDField.value = data.paypal_client_id;
            PayPalSecretIDField.value = data.paypal_secret_id;

            // ✅ Show keys in plain text
            PayPalClientIDField.type = 'text';
            PayPalSecretIDField.type = 'text';

            // ✅ Close modal
            const modalEl = document.getElementById('exampleModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();
        } else {
            alert(data.message || 'Incorrect password!');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Something went wrong. Check console.');
    });
});
</script>

{{-- RAZORPAY JS --}}

<script>
document.getElementById('keypassword').addEventListener('submit', function(e) {
    e.preventDefault();
    const password = document.getElementById('confirm_password').value;

    fetch("{{ route('admin.showRazorpayKeys') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ password: password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const RazorpayKeyField = document.getElementById('razorpay_key');
            const RazorpaySecretKeyField = document.getElementById('razorpay_secret_key');

            // ✅ Update values
            RazorpayKeyField.value = data.razorpay_key;
            RazorpaySecretKeyField.value = data.razorpay_secret_key;

            // ✅ Show keys in plain text
            RazorpayKeyField.type = 'text';
            RazorpaySecretKeyField.type = 'text';

            // ✅ Close modal
            const modalEl = document.getElementById('exampleModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();
        } else {
            alert(data.message || 'Incorrect password!');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Something went wrong. Check console.');
    });
});
</script>

{{-- PAYSTACK JS --}}

<script>
document.getElementById('keypassword').addEventListener('submit', function(e) {
    e.preventDefault();
    const password = document.getElementById('confirm_password').value;

    fetch("{{ route('admin.showPaystackKeys') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ password: password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const PaystackPublicKeyField = document.getElementById('paystack_public_key');
            const PaystackSecretKeyField = document.getElementById('paystack_secret_key');

            // ✅ Update values
            PaystackPublicKeyField.value = data.paystack_public_key;
            PaystackSecretKeyField.value = data.paystack_secret_key;

            // ✅ Show keys in plain text
            PaystackPublicKeyField.type = 'text';
            PaystackSecretKeyField.type = 'text';

            // ✅ Close modal
            const modalEl = document.getElementById('exampleModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();
        } else {
            alert(data.message || 'Incorrect password!');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Something went wrong. Check console.');
    });
});
</script>

{{-- PAYTM JS --}}

<script>
document.getElementById('keypassword').addEventListener('submit', function(e) {
    e.preventDefault();
    const password = document.getElementById('confirm_password').value;

    fetch("{{ route('admin.showPaytmKeys') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ password: password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const PaytmMerchantIDField = document.getElementById('paytm_merchant_id');
            const PaytmMerchantKeyField = document.getElementById('paytm_merchant_key');

            // ✅ Update values
            PaytmMerchantIDField.value = data.paytm_merchant_id;
            PaytmMerchantKeyField.value = data.paytm_merchant_key;

            // ✅ Show keys in plain text
            PaytmMerchantIDField.type = 'text';
            PaytmMerchantKeyField.type = 'text';

            // ✅ Close modal
            const modalEl = document.getElementById('exampleModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();
        } else {
            alert(data.message || 'Incorrect password!');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Something went wrong. Check console.');
    });
});
</script>

{{-- OMISE JS --}}

<script>
document.getElementById('keypassword').addEventListener('submit', function(e) {
    e.preventDefault();
    const password = document.getElementById('confirm_password').value;

    fetch("{{ route('admin.showOmiseKeys') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ password: password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const OmisePublicKeyField = document.getElementById('omise_public_key');
            const OmiseSecretKeyField = document.getElementById('omise_secret_key');

            // ✅ Update values
            OmisePublicKeyField.value = data.omise_public_key;
            OmiseSecretKeyField.value = data.omise_secret_key;

            // ✅ Show keys in plain text
            OmisePublicKeyField.type = 'text';
            OmiseSecretKeyField.type = 'text';

            // ✅ Close modal
            const modalEl = document.getElementById('exampleModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();
        } else {
            alert(data.message || 'Incorrect password!');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Something went wrong. Check console.');
    });
});
</script>

{{-- MOLLIE JS --}}

<script>
document.getElementById('keypassword').addEventListener('submit', function(e) {
    e.preventDefault();
    const password = document.getElementById('confirm_password').value;

    fetch("{{ route('admin.showMollieKeys') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ password: password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const MollieApiKeyField = document.getElementById('mollie_key');

            // ✅ Update values
            MollieApiKeyField.value = data.mollie_key;

            // ✅ Show keys in plain text
            MollieApiKeyField.type = 'text';

            // ✅ Close modal
            const modalEl = document.getElementById('exampleModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();
        } else {
            alert(data.message || 'Incorrect password!');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Something went wrong. Check console.');
    });
});
</script>

{{-- RAVE JS --}}

<script>
document.getElementById('keypassword').addEventListener('submit', function(e) {
    e.preventDefault();
    const password = document.getElementById('confirm_password').value;

    fetch("{{ route('admin.showRaveKeys') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ password: password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const FlutterwavePublicKeyField = document.getElementById('flutterwave_public_key');
            const FlutterwaveSecretKeyField = document.getElementById('flutterwave_secret_key');
            const FlutterwaveEncryptionKeyField = document.getElementById('flutterwave_encryption_key');

            // ✅ Update values
            FlutterwavePublicKeyField.value = data.flutterwave_public_key;
            FlutterwaveSecretKeyField.value = data.flutterwave_secret_key;
            FlutterwaveEncryptionKeyField.value = data.flutterwave_encryption_key;

            // ✅ Show keys in plain text
            FlutterwavePublicKeyField.type = 'text';
            FlutterwaveSecretKeyField.type = 'text';
            FlutterwaveEncryptionKeyField.type = 'text';

            // ✅ Close modal
            const modalEl = document.getElementById('exampleModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();
        } else {
            alert(data.message || 'Incorrect password!');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Something went wrong. Check console.');
    });
});
</script>

{{-- BRAINTREE JS --}}

<script>
document.getElementById('keypassword').addEventListener('submit', function(e) {
    e.preventDefault();
    const password = document.getElementById('confirm_password').value;

    fetch("{{ route('admin.showBraintreeKeys') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ password: password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const BraintreeMerchantIDField = document.getElementById('braintree_merchant_id');
            const BraintreePublicKeyField = document.getElementById('braintree_public_key');
            const BraintreePrivateKeyField = document.getElementById('braintree_private_key');

            // ✅ Update values
            BraintreeMerchantIDField.value = data.braintree_merchant_id;
            BraintreePublicKeyField.value = data.braintree_public_key;
            BraintreePrivateKeyField.value = data.braintree_private_key;

            // ✅ Show keys in plain text
            BraintreeMerchantIDField.type = 'text';
            BraintreePublicKeyField.type = 'text';
            BraintreePrivateKeyField.type = 'text';

            // ✅ Close modal
            const modalEl = document.getElementById('exampleModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();
        } else {
            alert(data.message || 'Incorrect password!');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Something went wrong. Check console.');
    });
});
</script>

{{-- MIDTRANS JS --}}

<script>
document.getElementById('keypassword').addEventListener('submit', function(e) {
    e.preventDefault();
    const password = document.getElementById('confirm_password').value;

    fetch("{{ route('admin.showMidtransKeys') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ password: password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const MidtransClientKeyField = document.getElementById('midtrans_client_key');
            const MidtransServerKeyField = document.getElementById('midtrans_server_key');

            // ✅ Update values
            MidtransClientKeyField.value = data.midtrans_client_key;
            MidtransServerKeyField.value = data.midtrans_server_key;

            // ✅ Show keys in plain text
            MidtransClientKeyField.type = 'text';
            MidtransServerKeyField.type = 'text';

            // ✅ Close modal
            const modalEl = document.getElementById('exampleModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();
        } else {
            alert(data.message || 'Incorrect password!');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Something went wrong. Check console.');
    });
});
</script>
@endsection
