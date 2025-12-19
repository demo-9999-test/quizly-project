@extends('front.layouts.master')
@section('title', 'Quizz')
@section('content')

<div id="breadcrumb" class="breadcrumb-main-block"
    @if(isset($setting->breadcrumb_img) && $setting->breadcrumb_img)
        style="background-image: url('{{ asset('images/breadcrumb/'.$setting->breadcrumb_img) }}')"
    @endif
>
    <div class="overlay-bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center ">
                <nav  style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <h2 class="breadcrumb-title mb_30">{{__('Checkout')}}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Checkout')}} </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Checkout Start -->
<section id="checkout-block" class="checkout-block-main-block">
    <div class="container">
        <h2 class="mb-4">{{__('Checkout')}}</h2>
        <div class="row">
            <div class="col-lg-3">
                <div class="plan-checkout-block text-center mb_30">
                    <h4 class="plan-checkout-heading">{{$plan->pname}}</h4>
                    @php
                        $currency = DB::table('currencies')->where('default', 1)->first();
                    @endphp
                    <h2 class="plan-checkout-rate mb_30">{{$currency->symbol}} {{ currencyConverter($plan->currency, $currency->code, $plan->plan_amount)}}</h2>
                    <div class="plan-rate-icon">
                        <i class="flaticon-coin"></i>
                    </div>
                    <h5 class="checkout-txt">{{'Buy: '.$plan->preward.' Coins'}}</h5>
                </div>
                <div class="coupon-block">
                    <form action="{{ route('checkout.applyCoupon') }}" method="post">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                        <div class="apply-group dropdown mb-2">
                            <input type="text" name="coupon_code" id="coupon_code" class="form-control dropdown-toggle" onclick="toggleDropdown()" readonly value="{{ request('coupon') }}">
                            <ul id="couponDropdown" class="dropdown-menu">
                                @foreach ($coupons as $coupon)
                                    @if ($coupon->code_display == 1)
                                        <li><a href="#" class="dropdown-item" onclick="selectCoupon('{{ $coupon->coupon_code }}')">{{ $coupon->coupon_code }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                            <button type="submit" class="btn apply-btn btn-primary">{{ __('Apply') }}</button>
                        </div>
                    </form>

                    @php
                        if (!function_exists('calculateGrandTotal')) {
                            function calculateGrandTotal($subtotal, $couponAmount = 0, $couponType = null) {
                                if ($couponType === 'fix') {
                                    return max(0, $subtotal - $couponAmount);
                                } elseif ($couponType === 'percentage') {
                                    $discountAmount = ($couponAmount / 100) * $subtotal;
                                    return max(0, $subtotal - $discountAmount);
                                } else {
                                    return $subtotal;
                                }
                            }
                        }

                        $couponType = $appliedCoupon ? $appliedCoupon->discount_type : null;
                        $couponAmount = $appliedCoupon ? $appliedCoupon->amount : 0;
                        $usageLimit = $appliedCoupon ? $appliedCoupon->limit : null;
                        $expiryDate = $appliedCoupon ? $appliedCoupon->expiry_date : null;

                        if ($expiryDate !== null && now()->greaterThan($expiryDate)) {
                            $couponType = null;
                            $couponAmount = 0;
                            $message = 'Coupon has expired.';
                        } elseif ($usageLimit !== null && $usageLimit <= 0) {
                            $couponType = null;
                            $couponAmount = 0;
                            $message = 'Coupon usage limit reached.';
                        }
                        $grandTotal = calculateGrandTotal($plan->plan_amount, $couponAmount, $couponType);
                        $convertedGrandTotal = currencyConverter($plan->currency, $currency->code, $grandTotal);
                    @endphp

                    @if ($appliedCoupon)
                        <div class="mb_30" id="coupon-section">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <p class="coupon-block-txt">{{ $appliedCoupon->coupon_code }}:</p>
                                </div>
                                <div class="col-lg-6 text-end">
                                    @if ($expiryDate && now()->greaterThan($expiryDate))
                                        <span class="text-danger">({{__('Coupon expired')}})</span>
                                    @endif
                                    <form action="{{ route('checkout.removeCoupon') }}" method="POST" class="coupon-form">
                                        @csrf
                                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                        <button type="submit" class="btn btn-danger">{{__('Remove')}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                        <h4 class="coupon-block-heading mb_30">{{ __('Price Details') }}</h4>
                        <div class="row">
                            <div class="col-lg-6 mb_10">
                                <p class="coupon-block-txt">{{ __('Total price:') }}</p>
                            </div>
                            <div class="col-lg-6 text-end">
                                <strong class="coupon-block-txt">{{ $currency->symbol }} {{ currencyConverter($plan->currency, $currency->code, $plan->plan_amount) }}</strong>
                            </div>
                            <div class="col-lg-6 mb_10">
                                <p class="coupon-block-txt">{{ __('Coupon discount:') }}</p>
                            </div>
                            <div class="col-lg-6 text-end">
                                <strong class="coupon-block-txt">
                                    @if ($couponType === 'fix')
                                        {{ $currency->symbol }} {{ currencyConverter($plan->currency, $currency->code, $couponAmount) }}
                                    @elseif ($couponType === 'percentage')
                                        {{ $couponAmount }}{{__('%')}}
                                    @else
                                        {{ $currency->symbol }} {{__('0')}}
                                    @endif
                                </strong>
                            </div>
                            <hr>
                            <div class="col-lg-6">
                                <p class="coupon-block-txt">{{ __('Total amount:') }}</p>
                            </div>
                            <div class="col-lg-6 text-end">
                                @php
                                $curr = DB::table('currencies')->where('default', 1)->first();
                                @endphp
                                <strong class="coupon-block-txt">
                                    @if ($curr == $plan->currency)
                                    {{ $currency->symbol }} {{ $convertedGrandTotal }}
                                    @endif
                                    @if ($curr != $plan->currency)
                                    {{ $currency->symbol }}{{ $convertedGrandTotal }}
                                    @endif
                                </strong>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
                if ($curr == $plan->currency) {
                    $plan_price = $grandTotal;
                } else {
                    $plan_price = $convertedGrandTotal;
                }
            ?>
            <div class="col-lg-9">
                @if ($paymentsetting->stripe_enable == '1')
                    @if (isset($currency->code) &&  in_array($currency->code, ['USD', 'AED', 'AFN', 'ALL', 'AMD', 'ANG', 'AOA', 'ARS', 'AUD', 'AWG', 'AZN', 'BAM', 'BBD', 'BDT', 'BGN', 'BIF', 'BMD', 'BND', 'BOB', 'BRL', 'BSD', 'BWP', 'BYN', 'BZD', 'CAD', 'CDF', 'CHF', 'CLP', 'CNY', 'COP', 'CRC', 'CVE', 'CZK', 'DJF', 'DKK', 'DOP', 'DZD', 'EGP', 'ETB', 'EUR', 'FJD', 'FKP', 'GBP', 'GEL', 'GIP', 'GMD', 'GNF', 'GTQ', 'GYD', 'HKD', 'HNL', 'HTG', 'HUF', 'IDR', 'ILS', 'INR', 'ISK', 'JMD', 'JPY', 'KES', 'KGS', 'KHR', 'KMF', 'KRW', 'KYD', 'KZT', 'LAK', 'LBP', 'LKR', 'LRD', 'LSL', 'MAD', 'MDL', 'MGA', 'MKD', 'MMK', 'MNT', 'MOP', 'MUR', 'MVR', 'MWK', 'MXN', 'MYR', 'MZN', 'NAD', 'NGN', 'NIO', 'NOK', 'NPR', 'NZD', 'PAB', 'PEN', 'PGK', 'PHP', 'PKR', 'PLN', 'PYG', 'QAR', 'RON', 'RSD', 'RUB', 'RWF', 'SAR', 'SBD', 'SCR', 'SEK', 'SGD', 'SHP', 'SLE', 'SOS', 'SRD', 'STD', 'SZL', 'THB', 'TJS', 'TOP', 'TRY', 'TTD', 'TWD', 'TZS', 'UAH', 'UGX', 'UYU', 'UZS', 'VND', 'VUV', 'WST', 'XAF', 'XCD', 'XOF', 'XPF', 'YER', 'ZAR', 'ZMW']))
                        <div class="checkout-block mb_30">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <h4 class="checkout-heading">{{__('Checkout with Stripe')}}</h4>
                                </div>
                                <div class="col-lg-6 text-start">
                                    <form method="POST" action="{{ route('stripe.post') }}" class="stripe-form" id="stripe-form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                            <input type="hidden" name="plan_amount" value="{{ $plan_price }}">
                                            @if($appliedCoupon)
                                                <input type="hidden" name="coupon_id" value="{{ $appliedCoupon->id }}">
                                            @endif
                                            <div class="col-lg-12 col-md-12">
                                                <div class="form-group mb-3" id="card-number-field">
                                                    <label class="form-label" for="cardNumber">{{ __('Card Number') }}</label>
                                                    <div id="card-number-element" class="form-control"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group mb-3" id="expiry">
                                                    <label class="form-label">{{ __('Expiration Date') }}</label>
                                                    <div id="card-expiry-element" class="form-control"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group CVV mb-3">
                                                    <label class="form-label" for="cvv">{{ __('CVV') }}</label>
                                                    <div id="card-cvc-element" class="form-control"></div>
                                                </div>
                                            </div>
                                            <div id="card-errors" role="alert"></div>
                                        </div>
                                        <button type="submit" value="Submit Payment" class="btn paytm-btn"><img src="{{ asset('images/payment_img/stripe.png') }}" class="img-fluid" alt="{{ __('Stripe') }}"></button>
                                        <script src="https://js.stripe.com/v3/"></script>
                                        <script>
                                        const stripe = Stripe("{{ config('services.stripe.key') }}");
                                        const elements = stripe.elements();
                                        const cardNumber = elements.create('cardNumber');
                                        cardNumber.mount('#card-number-element');
                                        const cardExpiry = elements.create('cardExpiry');
                                        cardExpiry.mount('#card-expiry-element');
                                        const cardCvc = elements.create('cardCvc');
                                        cardCvc.mount('#card-cvc-element');

                                        const form = document.getElementById('stripe-form');
                                        const errorElement = document.getElementById('card-errors');

                                        [cardNumber, cardExpiry, cardCvc].forEach((element) => {
                                            element.on('change', (event) => {
                                                if (event.error) {
                                                    errorElement.textContent = event.error.message;
                                                } else {
                                                    errorElement.textContent = '';
                                                }
                                            });
                                        });

                                        form.addEventListener('submit', async (event) => {
                                            event.preventDefault();

                                            const { paymentMethod, error } = await stripe.createPaymentMethod({
                                                type: 'card',
                                                card: cardNumber,
                                            });

                                            if (error) {
                                                errorElement.textContent = error.message;
                                            } else {
                                                // Add the payment method ID to your form
                                                const hiddenInput = document.createElement('input');
                                                hiddenInput.setAttribute('type', 'hidden');
                                                hiddenInput.setAttribute('name', 'paymentMethodId');
                                                hiddenInput.setAttribute('value', paymentMethod.id);
                                                form.appendChild(hiddenInput);

                                                // Submit the form
                                                form.submit();
                                            }
                                        });
                                        </script>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @if ($paymentsetting->razorpay_enable == '1')
                    @if (isset($currency->code) && $currency->code == 'INR')
                        <div class="checkout-block mb_30">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <h4 class="checkout-heading">{{__('Checkout with razorpay')}}</h4>
                                </div>
                                <div class="col-lg-6 text-end">
                                    <form action="{{ route('payment',['plan_id'=>$plan->id,'plan_amount'=>$plan_price]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                        <input type="hidden" name="plan_amount" value="{{ $plan_price }}">
                                        <input type="hidden" name="currency" value="{{ $plan->currency }}">
                                        @if($appliedCoupon)
                                            <input type="hidden" name="coupon_id" value="{{ $appliedCoupon->id }}">
                                        @endif
                                        <script src="https://checkout.razorpay.com/v1/checkout.js"
                                            data-key="{{ env('RAZORPAY_KEY') }}" data-amount={{ $plan_price*100 }}
                                            data-buttontext="Razorpay" data-name="{{ $setting->project_title }}"
                                            data-description="Razorpay"
                                            data-image="{{ asset('images/logo/'.$setting->logo) }}"
                                            data-prefill.name="name"
                                            data-theme.color="#293FCC">
                                        </script>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @if ($paymentsetting->paytm_enable == '1')
                    @if (isset($currency->code) && $currency->code == 'INR')
                        <div class="checkout-block mb_30">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <h4 class="checkout-heading">{{__('Checkout with paytm')}}</h4>
                                </div>
                                <div class="col-lg-6 text-end">
                                    <form action="{{ route('paytm.payment') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                        <input type="hidden" name="plan_amount" value="{{ $plan_price }}">
                                        @if($appliedCoupon)
                                            <input type="hidden" name="coupon_id" value="{{ $appliedCoupon->id }}">
                                        @endif
                                        <button class="btn paytm-btn" title="{{ __('Checkout') }}" type="submit"><img
                                            src="{{asset('images/payment_img/paytm.png')}}"
                                            class="img-fluid" alt="{{ __('paytm') }}">
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @if ($paymentsetting->paypal_enable == '1')
                    @if (isset($currency->code) &&  in_array($currency->code, ['USD', 'THB', 'CHF', 'SEK', 'SGD','GBP', 'PLN', 'PHP', 'NOK', 'NZD','TWD', 'MXN', 'MYR', 'JPY', 'ILS','HUF', 'HKD', 'EUR', 'DKK', 'CZK','HUF', 'CNY', 'CAD', 'BRL', 'AUD']))
                        <div class="checkout-block mb_30">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <h4 class="checkout-heading">{{__('Checkout with paypal')}}</h4>
                                </div>
                                <div class="col-lg-6 text-end">
                                    <form action="{{ route('paypal') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                        <input type="hidden" name="plan_amount" value="{{ $plan_price }}">
                                        @if($appliedCoupon)
                                            <input type="hidden" name="coupon_id" value="{{ $appliedCoupon->id }}">
                                        @endif
                                        <button class="btn paytm-btn" title="{{ __('Checkout') }}" type="submit"><img
                                            src="{{asset('images/payment_img/paypal.png')}}"
                                            class="img-fluid" alt="{{ __('paytm') }}">
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @if ($paymentsetting->rave_enable == '1')
                    @if (isset($currency->code) && $currency->code == 'NGN')
                    <div class="checkout-block mb_30">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <h4 class="checkout-heading">{{__('Checkout with flutterwave')}}</h4>
                            </div>
                            <div class="col-lg-6 text-end">
                                <form method="POST" action="{{ route('flutterwave.pay') }}">
                                    @csrf
                                    <input type="text" name="name" placeholder="Name" hidden value="{{auth()->user()->name}}">
                                    <input type="email" name="email" placeholder="Email" hidden value="{{auth()->user()->email}}">
                                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                    <input type="hidden" name="plan_amount" value="{{ $plan_price }}">
                                    @if($appliedCoupon)
                                        <input type="hidden" name="coupon_id" value="{{ $appliedCoupon->id }}">
                                     @endif
                                    <button class="btn paytm-btn" title="{{ __('Checkout') }}" type="submit">
                                        <img src="{{asset('images/payment_img/rave.png')}}" class="img-fluid" alt="{{ __('flutterwave') }}">
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                @endif
                @if ($paymentsetting->paystack_enable == '1')
                    @if (isset($currency->code) &&  in_array($currency->code, ['GHS', 'NGN', 'ZAR', 'KES']))
                        <div class="checkout-block mb_30">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <h4 class="checkout-heading">{{__('Checkout with paystack')}}</h4>
                                </div>
                                <div class="col-lg-6 text-end">
                                    <form method="POST" action="{{ route('paystack.payment') }}">
                                        @csrf
                                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                        <input type="hidden" name="plan_amount" value="{{ $plan_price}}">
                                        @if($appliedCoupon)
                                            <input type="hidden" name="coupon_id" value="{{ $appliedCoupon->id }}">
                                        @endif
                                        <button class="btn paytm-btn" title="{{ __('Checkout') }}" type="submit" type="submit"><img
                                            src="{{asset('images/payment_img/paystack.png')}}"
                                            class="img-fluid" alt="{{ __('paystack') }}">
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @if ($paymentsetting->instamojo_enable == '1')
                    @if (isset($currency->code) && $currency->code == 'INR')
                        <div class="checkout-block mb_30">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <h4 class="checkout-heading">{{__('Checkout with Instamojo')}}</h4>
                                </div>
                                <div class="col-lg-6 text-end">
                                    <form method="POST" action="{{route('instamojo.payment')}}">
                                        @csrf
                                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                        <input type="hidden" name="plan_amount" value="{{ $plan_price }}">
                                        @if($appliedCoupon)
                                            <input type="hidden" name="coupon_id" value="{{ $appliedCoupon->id }}">
                                        @endif
                                        <button class="btn paytm-btn" title="{{ __('Checkout') }}" type="submit" type="submit"><img
                                            src="{{asset('images/payment_img/instamojo.png')}}"
                                            class="img-fluid" alt="{{ __('paystack') }}"></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @if ($paymentsetting->omise_enable == '1')
                    @if (isset($currency->code) &&  in_array($currency->code, ['EUR', 'USD', 'GBP', 'CHF', 'PLN', 'SEK', 'NOK', 'DKK']))
                        <div class="checkout-block mb_30">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <h4 class="checkout-heading">{{__('Checkout with omise')}}</h4>
                                </div>
                                <div class="col-lg-6 text-end">
                                    <form method="POST" action="{{ route('pay.omise') }}">
                                        @csrf
                                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                        <input type="hidden" name="plan_amount" value="{{ $plan_price}}">
                                        @if($appliedCoupon)
                                            <input type="hidden" name="coupon_id" value="{{ $appliedCoupon->id }}">
                                        @endif
                                        <script type="text/javascript" src="https://cdn.omise.co/omise.js"
                                        data-key="{{ env('OMISE_PUBLIC_KEY') }}" data-amount="{{$plan_price*10000 }}"
                                        data-frame-label="{{ config('app.name') }}"
                                        data-image="{{ url('images/logo/'.$setting->logo) }}"
                                        data-currency="{{ $currency->code }}"
                                        data-default-payment-method="credit_card">
                                        </script>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @if ($paymentsetting->aamarpay_enable == '1')
                    @if (isset($currency->code) && $currency->code == 'BDT')
                    <div class="checkout-block">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <h4 class="checkout-heading">{{__('Checkout with aamarpay')}}</h4>
                            </div>
                            <div class="col-lg-6 text-end">
                                <form method="POST" action="{{ route('aamarpay.payment') }}">
                                    @csrf
                                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                    <input type="hidden" name="plan_amount" value="{{ $plan_price }}">
                                    @if($appliedCoupon)
                                        <input type="hidden" name="coupon_id" value="{{ $appliedCoupon->id }}">
                                    @endif
                                    <button class="btn paytm-btn" title="{{ __('Checkout') }}" type="submit">
                                        <img src="{{asset('images/payment_img/aamarpay.png')}}" class="img-fluid" alt="{{ __('aamarpay') }}">
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                @endif

                @if ($paymentsetting->mollie_enable == '1')
                    @if (isset($currency->code) &&  in_array($currency->code, ['THB', 'AUD', 'CAD', 'CHF', 'CNY','DKK','EUR','GBP','HKD','JPY','MYR','SGD','USD']))
                        <div class="checkout-block mb_30">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <h4 class="checkout-heading">{{__('Checkout with mollie')}}</h4>
                                </div>
                                <div class="col-lg-6 text-end">
                                    <form method="POST" action="{{route('mollie.payment')}}">
                                        @csrf
                                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                        <input type="hidden" name="plan_amount" value="{{ $plan_price }}">
                                        @if($appliedCoupon)
                                        <input type="hidden" name="coupon_id" value="{{ $appliedCoupon->id }}">
                                        @endif
                                        <button class="btn paytm-btn" title="{{ __('Checkout') }}" type="submit" type="submit"><img
                                            src="{{asset('images/payment_img/moli.png')}}"
                                            class="img-fluid" alt="{{ __('mollie') }}">
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @if ($paymentsetting->braintree_enable == '1')
                    @if (isset($currency->code) &&  in_array($currency->code, ['AED', 'AMD', 'AOA', 'ARS', 'AUD', 'AWG', 'AZN', 'BAM', 'BBD', 'BDT', 'BGN', 'BIF', 'BMD', 'BND', 'BOB', 'BRL', 'BSD', 'BWP', 'BYN', 'BZD', 'CAD', 'CHF', 'CLP', 'CNY', 'COP', 'CRC', 'CVE', 'CZK', 'DJF', 'DKK', 'DOP', 'DZD', 'EGP', 'ETB', 'EUR', 'FJD', 'FKP', 'GBP', 'GEL', 'GHS', 'GIP', 'GMD', 'GNF', 'GTQ', 'GYD', 'HKD', 'HNL', 'HRK', 'HTG', 'HUF', 'IDR', 'ILS', 'INR', 'ISK', 'JMD', 'JPY', 'KES', 'KGS', 'KHR', 'KMF', 'KRW', 'KYD', 'KZT', 'LAK', 'LBP', 'LKR', 'LRD', 'LSL', 'LTL', 'MAD', 'MDL', 'MKD', 'MNT', 'MOP', 'MUR', 'MVR', 'MWK', 'MXN', 'MYR', 'MZN', 'NAD', 'NGN', 'NIO', 'NOK', 'NPR', 'NZD', 'PAB', 'PEN', 'PGK', 'PHP', 'PKR', 'PLN', 'PYG', 'QAR', 'RON', 'RSD', 'RUB', 'RWF', 'SAR', 'SBD', 'SCR', 'SEK', 'SGD', 'SHP', 'SLL', 'SOS', 'SRD', 'STD', 'SVC', 'SYP', 'SZL', 'THB', 'TJS', 'TOP', 'TRY', 'TTD', 'TWD', 'TZS', 'UAH', 'UGX', 'USD', 'UYU', 'UZS', 'VES', 'VND', 'VUV', 'WST', 'XAF', 'XCD', 'XOF', 'XPF', 'YER', 'ZAR', 'ZMK', 'ZWD']))
                    <div class="checkout-block mb_30">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <h4 class="checkout-heading">{{__('Checkout with Braintree')}}</h4>
                            </div>
                            <div class="col-lg-6 text-end">
                                <div id="dropin-container"></div>
                                <button id="submit-button" class="button button--small button--green" style="display: none;">{{__('Purchase')}}</button>
                            </div>
                        </div>
                        <script src="https://js.braintreegateway.com/web/dropin/1.33.0/js/dropin.min.js"></script>
                        <script>
                            var button = document.querySelector('#submit-button');

                            // Function to fetch client token
                            function getClientToken() {
                                return fetch('{{ route("braintree.token") }}', {
                                    method: 'GET',
                                    headers: {
                                        'Accept': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => data.clientToken);
                            }

                            // Initialize Braintree Drop-in UI
                            getClientToken().then(clientToken => {
                                braintree.dropin.create({
                                    authorization: clientToken,
                                    container: '#dropin-container',
                                    }, function (createErr, instance) {
                                    if (createErr) {
                                        console.error('Error creating Braintree UI:', createErr);
                                        return;
                                    }
                                    button.style.display = 'inline-block';
                                    button.addEventListener('click', function (event) {
                                        event.preventDefault();
                                        instance.requestPaymentMethod(function (err, payload) {
                                            if (err) {
                                                console.error('Error:', err);
                                                return;
                                            }

                                            // Send payload.nonce to your server
                                            fetch('{{ route("braintree.process") }}', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                    'X-Requested-With': 'XMLHttpRequest'
                                                },
                                                body: JSON.stringify({
                                                    payment_method_nonce: payload.nonce,
                                                    amount: {{ $plan_price }},
                                                    plan_id: {{ $plan->id }}
                                                })
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                if (data.success) {
                                                    window.location.href = data.redirect;
                                                }
                                            })
                                            .catch(error => {
                                                console.error('Error:', error);
                                                alert('An error occurred while processing the payment.');
                                            });
                                        });
                                    });
                                });
                            }).catch(error => {
                                console.error('Failed to get client token:', error);
                            });
                        </script>
                    </div>
                    @endif
                @endif

                @if($paymentsetting->midtrans_enable == '1')
                    @if(isset($currency->code) && $currency->code == 'IDR')
                        <div class="checkout-block mb_30">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <h4 class="checkout-heading">{{__('Checkout with midtrans')}}</h4>
                                </div>
                                <div class="col-lg-6 text-end">
                                    <form id="midtrans-payment-form">
                                        @csrf
                                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                        <input type="hidden" name="plan_amount" value="{{ $plan_price }}">
                                        <input type="hidden" name="pname" value="{{ $plan->name }}">
                                        <button class="btn paytm-btn" title="{{ __('Checkout') }}" type="button" onclick="payWithMidtrans()">
                                            <img src="{{asset('images/payment_img/midtrans-logo.png')}}" class="img-fluid" alt="{{ __('midtrans') }}">
                                        </button>
                                    </form>
                                    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
                                    <script>
                                    function payWithMidtrans() {
                                        var form = document.getElementById('midtrans-payment-form');
                                        var formData = new FormData(form);

                                        fetch('/midtrans/payment/process', {
                                            method: 'POST',
                                            body: formData,
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                            }
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.snap_token) {
                                                snap.pay(data.snap_token, {
                                                    onSuccess: function(result){
                                                        // Create a form element
                                                        var form = document.createElement('form');
                                                        form.method = 'POST';
                                                        form.action = '/midtrans/payment/success';

                                                        // Add CSRF token
                                                        var csrfToken = document.createElement('input');
                                                        csrfToken.type = 'hidden';
                                                        csrfToken.name = '_token';
                                                        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                                                        form.appendChild(csrfToken);

                                                        // Add Midtrans result data
                                                        for (var key in result) {
                                                            if (result.hasOwnProperty(key)) {
                                                                var hiddenField = document.createElement('input');
                                                                hiddenField.type = 'hidden';
                                                                hiddenField.name = key;
                                                                hiddenField.value = result[key];
                                                                form.appendChild(hiddenField);
                                                            }
                                                        }

                                                        // Append form to body and submit
                                                        document.body.appendChild(form);
                                                        form.submit();
                                                    },
                                                    onPending: function(result){
                                                        alert("Payment pending. Please complete your payment.");
                                                    },
                                                    onError: function(result){
                                                        alert("Payment failed. Please try again.");
                                                    },
                                                    onClose: function(){
                                                        alert("You closed the popup without finishing the payment");
                                                    }
                                                });
                                            } else if (data.error) {
                                                console.error('Error:', data.error);
                                                alert("An error occurred. Please try again.");
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            alert("An error occurred. Please try again.");
                                        });
                                    }
                                    </script>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</section>
<script>
    function toggleDropdown() {
        var dropdown = document.getElementById("couponDropdown");
        dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
    }

    function selectCoupon(couponCode) {
        var couponCodeInput = document.getElementById("coupon_code");
        couponCodeInput.value = couponCode;
        toggleDropdown();
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        var dropdown = document.getElementById("couponDropdown");
        var couponInput = document.getElementById("coupon_code");
        if (event.target !== couponInput && !couponInput.contains(event.target)) {
            dropdown.style.display = "none";
        }
    });

    // Ensure dropdown is properly positioned
    window.addEventListener('load', function() {
        var dropdown = document.getElementById("couponDropdown");
        var couponInput = document.getElementById("coupon_code");
        dropdown.style.width = couponInput.offsetWidth + 'px';
        dropdown.style.top = (couponInput.offsetTop + couponInput.offsetHeight) + 'px';
        dropdown.style.left = couponInput.offsetLeft + 'px';
    });
</script>
@endsection
