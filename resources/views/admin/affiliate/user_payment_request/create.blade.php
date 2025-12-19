@extends('admin.layouts.master')
@section('title', 'Payment Request - Admin')
@section('main-container')
<div class="dashboard-card">

    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Payment Request Create') }}
    @endslot
    @slot('menu1')
    {{ __('Affiliate History') }}
    @endslot
    @slot('menu2')
    {{ __('Payment Request Create') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a class="btn btn-primary" type="button" href="{{ route('payment.request') }}" title="{{ __('Back')}}"><i
            class="flaticon-arrow"></i> {{ __("Back")}}</a>
        </div>
    </div>
    @endslot
    @endcomponent
    <div class="contentbar profile-main-block">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <!--form code start-->
                <form action="{{ route('payment.request.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="bank_details" class="form-label">{{ __('Bank Details') }}<span
                                    class="required">*</span></label>
                                    <textarea name="bank_details" class="form-control" id="bank_details" rows="1" 
                                    placeholder="{{__('Enter Bank Details')}}" required></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="amount" class="form-label">{{ __('Amount') }}<span class="required">*</span></label>
                                    <input type="number" name="amount" class="form-control"
                                        placeholder="{{__('Enter Amount')}}" required>
                                        <p>{{ 'Reaming Amount:' }}{{ $totalReferralAmount }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="reset" class="btn btn-secondary" title="{{ __('Reset') }}"><i
                        class="flaticon-ban-circle-symbol"></i>{{ __("Reset")}}</button>
                        <button type="submit" class="btn btn-primary" title="{{ __('Submit') }}"><i
                        class="flaticon-upload-1"></i> {{ __('Submit') }}</button>
                    </form>
                    <!-- form code end -->
                    </div>
                </div>
            </div>
        </div>
        @endsection
