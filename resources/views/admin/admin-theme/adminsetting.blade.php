@extends('admin.layouts.master')
@section('title', 'Admin Settings')
@section('main-container')
<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Admin Settings') }}
    @endslot
    @slot('menu1')
    {{ __('Admin Settings') }}
    @endslot
    @slot('menu2')
    {{ __('Admin Settings') }}
    @endslot
    @endcomponent

    <div class="contentbar ">
        @include('admin.layouts.flash_msg')
                <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- form code start -->
                <form action="{{ route('adminsetting.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block">
                        <div class="row">

                                    <div class="col-lg-2 col-md-2">
                                        <div class="form-group">
                                            <label for="status" class="form-label">{{ __('Admin Logo') }}</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="customSwitch" name="logostatus" value="1" checked>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-5 col-md-5">
                                        <div class="form-group" id="textInputBox">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-8">
                                                    <label for="promoLink" class="form-label">{{ __('Logo Image (Light Theme)')
                                                    }}<span class="required">*</span> </label>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-4">
                                                    <div class="suggestion-icon float-end">
                                                        <div class="tooltip-icon">
                                                            <div class="tooltip">
                                                                <div class="credit-block">
                                                                    <small class="recommended-font-size">{{ __(' (Note -
                                                                        Recommended Size : 300x90PX) ') }}
                                                                        <br> {{ __(' (Note - .jpg , .png) ') }}</small>
                                                                </div>
                                                            </div>
                                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-8">
                                                    <input class="form-control form-control-lg " type="file" name="admin_logo"
                                                        id="promoLink_1" aria-label="Promo Link"
                                                        onchange="readURL(this);">
                                                    <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-4">
                                                    <div class="edit-img-show">
                                                        @if (!empty($adsetting->admin_logo))
                                                        <img src="{{ asset('images/admin_logo/' . $adsetting->admin_logo) }}"
                                                            alt="{{ __('Admin Logo') }}" class="img-fluid" id="admin_logo">
                                                        @else
                                                        <img src="{{ Avatar::create($adsetting->title)->toBase64() }}"
                                                            class="example-img" alt="{{ __('Admin Logo') }}">
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group hidden" id="logoInputBox">
                                            <label for="" class="form-label">{{ __('Logo Name') }}<span
                                                    class="required">*</span></label>
                                            <input class="form-control form-control-lg" type="text" name="admin_logo"
                                                id="" placeholder="logo name" aria-label=""
                                                value="{{ old('offer_price') }}" min="0">
                                            <div class="form-control-icon"><i class="flaticon-title"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <button type="submit" class="btn btn-primary mt-3" title="{{ __('Submit') }}"><i
                            class="flaticon-upload-1"></i> {{
                        __('Submit')}}</button>
                </form>
                <!--form code end -->
            </div>
        </div>
    </div>
</div>
@endsection
