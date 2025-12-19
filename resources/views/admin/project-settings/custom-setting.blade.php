@extends('admin.layouts.master')
@section('title', 'Custom Settings')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Custom Css & Js ') }}
    @endslot
    @slot('menu1')
    {{ __('Project Settings') }}
    @endslot
    @slot('menu2')
    {{ __('Custom Css & Js ') }}
    @endslot
    @endcomponent

    <div class="contentbar ">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <!-- form code start -->
                <div class="row">
                    <div class="col-lg-6 col-md-6 mb-5">
                        <form action="{{ route('custom-code-css.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="client-detail-block">
                                <label for="" class="form-label">{{ __('Custom CSS') }}</label>
                                <textarea name="custom_css" id="msg" class="text-area-size" placeholder="a{color:red;}"></textarea>
                            </div>
                            <button type="reset" class="btn btn-danger mt-3" title="{{ __('Reset') }}"><i class="flaticon-restore"></i>{{
                                __('Reset') }}</button>
                            <button type="submit" class="btn btn-primary mt-3" title="{{ __('Update') }}"><i
                                        class="flaticon-upload-1"></i> {{ __('Update') }}</button>
                        </form>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <form action="{{ route('custom-code-js.store') }}" method="post" enctype="multipart/form-data">
                            <div class="client-detail-block">
                                @csrf
                                <label for="" class="form-label">{{ __('Custom JavaScript') }}</label>
                                <textarea name="custom_js" id="msg" class="text-area-size" placeholder="$(document).ready(function{//code});"></textarea>
                            </div>
                            <button type="reset" class="btn btn-danger mt-3" title="{{ __('Reset') }}"><i class="flaticon-restore"></i>{{
                                __('Reset') }}</button>
                            <button type="submit" class="btn btn-primary mt-3" title="{{ __('Update') }}"><i
                                    class="flaticon-upload-1"></i> {{ __('Update') }}</button>
                        </form>
                    </div>
                </div>
                <!-- form code end --->
            </div>
        </div>
    </div>
</div>
@endsection
