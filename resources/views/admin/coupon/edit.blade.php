@extends('admin.layouts.master')
@section('title', 'Coupons')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Coupons') }}
    @endslot
    @slot('menu1')
    {{ __('Coupons') }}
    @endslot
    @slot('menu2')
    {{ __('Edit') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('coupon.show') }}" title="{{ __('Back') }}" class="btn btn-primary"><i
                    class="flaticon-back"></i>{{ __('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent
    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <!-- From Code Start -->
                <form action="{{ url('admin/coupon/' . $coupon->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="client-detail-block">
                        <div class="row">
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label for="Coupon Code" class="form-label">{{ __('Coupon Code') }}<span
                                            class="required">*</span></label>
                                    <input class="form-control" type="text" name="coupon_code" id="title"
                                        placeholder="{{ __('Please Enter Your Coupon Code') }}" aria-label="title"
                                        required value="{{ $coupon->coupon_code }}">
                                    <div class="form-control-icon"><i class="flaticon-promo-code"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label for="Discount Type" class="form-label">{{ __('Discount Type') }}<span
                                            class="required">*</span></label>
                                    <select class="form-select" aria-label=" " name="discount_type">
                                        <option selected disabled> {{ __('Please Select Discount Type') }}</option>
                                        <option value="fix" {{ old('discount_type', $coupon->discount_type) === 'fix' ?
                                            'selected' : '' }}>{{ __('Fix Amount') }}
                                        </option>
                                        <option value="percentage" {{ old('discount_type', $coupon->discount_type) ===
                                            'percentage' ? 'selected' : '' }}>{{ __('% Percentage') }}
                                        </option>
                                    </select>
                                    <div class="form-control-icon"><i class="flaticon-discount"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label for="Amount" class="form-label">{{ __('Amount') }}<span
                                            class="required">*</span></label>
                                    <input class="form-control form-control-lg" type="number" name="amount" id=""
                                        placeholder="0.00" aria-label="title" required value="{{ $coupon->amount }}">
                                    <div class="form-control-icon"><i class="flaticon-gross"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label for="Min Amount" class="form-label">{{ __('Min Amount') }}</label>
                                    <input class="form-control form-control-lg" type="number" name="min_amount" id=""
                                        placeholder="0.00" aria-label="title" required
                                        value="{{ $coupon->min_amount }}">
                                    <div class="form-control-icon"><i class="flaticon-gross"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label for="Min Amount" class="form-label">{{ __('Max Amount') }}</label>
                                    <input class="form-control form-control-lg" type="number" name="max_amount" id=""
                                        placeholder="0.00" aria-label="title" required
                                        value="{{ $coupon->max_amount }}">
                                    <div class="form-control-icon"><i class="flaticon-gross"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label for="Expiry Date" class="form-label">{{ __('Start Date') }}<span
                                        class="required">*</span></label>
                                    <input class="form-control form-control-lg" type="date" name="start_date" id=""
                                        placeholder="{{ __('Please Enter Your Expiry Date') }}" aria-label="title"
                                        required value="{{ $coupon->start_date }}">
                                    <div class="form-control-icon"><i class="flaticon-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label for="Expiry Date" class="form-label">{{ __('Expiry Date') }}</label>
                                    <input class="form-control form-control-lg" type="date" name="expiry_date" id="expiry_date"
                                        placeholder="{{ __('Please Enter Your Expiry Date') }}" aria-label="title" 
                                        required value="{{ $coupon->expiry_date }}">
                                    <div class="form-control-icon"><i class="flaticon-calendar"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <label for="image" class="form-label">{{ __('Max Usage Limit') }}<span
                                                class="required">*</span></label>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="suggestion-icon float-end">
                                                <div class="tooltip-icon">
                                                    <div class="tooltip">
                                                        <div class="credit-block">
                                                            <small class="recommended-font-size">{{ __('( type 0 and this value in infinite limit )') }}</small>
                                                        </div>
                                                    </div>
                                                    <span class="float-end"><i class="flaticon-info"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input class="form-control form-control-padding_15" type="number" name="limit" id=""
                                        placeholder="{{ __('Limit') }}" aria-label="title" required
                                        value="{{ $coupon->limit }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="status">
                                    <div class="form-group">
                                        <label for="status" class="form-label">{{ __('Code Display at Checkout') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="status"
                                                name="code_display" value="1" {{ $coupon->code_display == 1 ? 'checked': '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="status">
                                    <div class="form-group">
                                        <label for="status" class="form-label">{{ __('Only For New User') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="status"
                                                name="active_user" value="1" {{ $coupon->active_user == 1 ? 'checked' :'' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                        $expiryDate = \Carbon\Carbon::parse($coupon->expiry_date ?? now())->format('Y-m-d');
                        @endphp
                        <small id="update-msg" class="text-danger" style="display: none;">
                            This coupon has expired. You cannot update.
                        </small>
                    <!-- ✅ Existing Update Button -->
                        <button type="submit" id="update-button" title="{{ __('Update') }}" class="btn btn-primary mt-3">
                            <i class="flaticon-refresh"></i> {{ __('Update') }}
                        </button>
                   <!-- ✅ Script for Expiry Validation -->
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                    const expiryDateInput = document.getElementById('expiry_date');
                                    const updateButton = document.getElementById('update-button');
                                    const msg = document.getElementById('update-msg');

                                    function checkExpiryDate() {
                                    const expiryDate = new Date(expiryDateInput.value);
                                    const today = new Date();

                                // Strip time for accurate date-only comparison
                                    expiryDate.setHours(0, 0, 0, 0);
                                    today.setHours(0, 0, 0, 0);

                                if (expiryDate < today) {
                                    updateButton.disabled = true;
                                    msg.style.display = 'inline';
                                } else {
                                    updateButton.disabled = false;
                                    msg.style.display = 'none';
                                }
                                }

                                // Initial check on page load
                                checkExpiryDate();

                                // Recheck on change
                                expiryDateInput.addEventListener('change', checkExpiryDate);
                            });
                        </script>
                    </div>
                </form>
                <!-- From Code end -->
            </div>
        </div>
    </div>
</div>
@endsection
