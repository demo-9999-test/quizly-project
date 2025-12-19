@extends('admin.layouts.master')
@section('title', 'Affiliate Settings')
@section('main-container')
<div class="dashboard-card">

    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Affiliate Settings') }}
    @endslot
    @slot('menu1')
    {{ __('Affiliate') }}
    @endslot
    @slot('menu2')
    {{ __('Affiliate Settings') }}
    @endslot

    @endcomponent
    <div class="contentbar profile-main-block">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <!--form code start-->
                <form action="{{ route('affiliates.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block">
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="title" class="form-label">{{ __('Title') }}<span
                                    class="required">*</span></label>
                                    <input name="title" type="text"
                                    class="form-control" autofocus="" placeholder="{{ __('Please enter title') }}"
                                    required="" value="{{ $affiliates ? strip_tags($affiliates->title) : "" }}">
                                    <div class="form-control-icon"><i class="flaticon-tag"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="sub_title" class="form-label">{{ __('Sub Title') }}<span
                                    class="required">*</span></label>
                                    <input name="sub_title" type="text"
                                    class="form-control" autofocus="" placeholder="{{ __('Please enter sub title') }}"
                                    required="" value="{{ $affiliates ? strip_tags($affiliates->sub_title) : "" }}">
                                    <div class="form-control-icon"><i class="flaticon-tag"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __('Referral Code Length:') }}<span
                                    class="required">*</span></label>
                                    <input name="ref_length" autofocus="" type="number" min="4" max="100"
                                    class="form-control" placeholder="{{ __('Please enter Refferal code Length') }}"
                                    required="" value="{{ $affiliates ? strip_tags($affiliates->ref_length) : "" }}">
                                    <div class="form-control-icon"><i class="flaticon-tag"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="email" class="form-label">{{ __('Point per referral:') }}<span
                                    class="required">*</span></label>
                                    <input name="point_per_referral" autofocus="" type="number" min="0" step="any"
                                    class="form-control" placeholder="{{ __('Enter Point for per Referral') }}"
                                    value="{{ $affiliates ? strip_tags($affiliates->point_per_referral) : "" }}">
                                    <div class="form-control-icon"><i class="flaticon-editing-1"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="slug" class="form-label">{{ __('Affiliate Minimum Withdrawal') }}<span
                                    class="required">*</span></label>
                                    <input type="number" class="form-control" id="affiliate_minimum_withdrawal"
                                    name="affiliate_minimum_withdrawal"
                                    value="{{$affiliates ? strip_tags($affiliates->affiliate_minimum_withdrawal) : ""}}">
                                    <div class="form-control-icon"><i class="flaticon-cash-withdrawal"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="desc" class="form-label">{!! __('Description') !!}</label>
                                    <textarea class="form-control" id="desc" name="desc" placeholder="{!! __('Enter Description') !!}">{{$affiliates->desc}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="status" class="form-label">{{ __('Status') }}</label>
                                    <div class="form-check form-switch ">
                                        <input class="form-check-input" type="checkbox" name="status" role="switch"
                                        id="status_toggle" {{ optional($affiliates)['status']=='1' ? 'checked' : ''
                                        }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" title="{{ __('Save Setting') }}" class="btn btn-primary"><i
                    class="flaticon-upload-1"></i> {{ __('Save Setting') }}</button>
                </form>
                <!-- form code end -->
            </div>
        </div>
    </div>
</div>
@endsection
