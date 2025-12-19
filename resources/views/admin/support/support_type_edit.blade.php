@extends('admin.layouts.master')
@section('title', 'Supports Type')
@section('main-container')
<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Supports Types Edit') }}
    @endslot
    @slot('menu1')
    {{ __('Help & Support') }}
    @endslot
    @slot('menu2')
    {{ __('Supports Types Edit') }}
    @endslot

    @slot('button')
    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('support_type.index') }}" class="btn btn-primary"><i class="flaticon-back"></i>
                {{ __('Back') }}</a>
        </div>
    </div>
    @endslot

    @endcomponent

    <div class="contentbar profile-main-block">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <!--form code start-->
                <form action="{{ url('admin/support_type/' . $supports_types->id) }}" method="post"
                    enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="client-detail-block">
                        <h5 class="block-heading"></h5>
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __('Support Type Name') }}<span
                                            class="required">*</span></label>
                                    <input class="form-control" type="text" name="name" id="heading"
                                        placeholder="Please Enter Your Name" aria-label="Heading"
                                        value="{{ $supports_types->name }}">
                                    <div class="form-control-icon"><i class="flaticon-user"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="status" class="form-label">{{ __('Status') }}</label>
                                    <div class="form-check form-switch ">
                                        <input class="form-check-input" type="checkbox" name="status" role="switch"
                                            id="status_toggle" {{ optional($supports_types)['status']=='1' ? 'checked'
                                            : '' }}>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="flaticon-upload-1"></i> {{ __('Submit')
                        }}</button>
                </form>
                <!-- form code end -->
            </div>

        </div>
    </div>
</div>
@endsection
