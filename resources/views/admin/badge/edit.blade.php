@extends('admin.layouts.master')
@section('title', 'Badge')
@section('main-container')
<div class="dashboard-card">

    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Badge ') }}
    @endslot
    @slot('menu1')
    {{ __('Badge') }}
    @endslot
    @slot('menu2')
    {{ __('Add') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('badge.index') }}" class="btn btn-primary" title="{{ __('Back') }}"><i class="flaticon-back"></i>{{ __('Back') }}</a>
        </div>
    </div>

    @endslot
    @endcomponent

    <!-- Start Contentbar -->
    <div class="contentbar  ">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <!-- form code start -->
                <form action="{{ route('badge.update', ['id' => $badges->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block">
                        <h5 class="block-heading">{{__('Add Badge')}}</h5>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-12 col-md-6">
                                        <div class="form-group">
                                            <label for="badgeName" class="form-label">{{ __('Badge Name') }}<span class="required">*</span></label>
                                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="badgeName" placeholder="{{ __('Enter Name of your Badge') }}" aria-label="Badge Name" value="{{ isset($badges->name) ? $badges->name : '' }}">
                                            <div class="form-control-icon"><i class="flaticon-star-medal"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-8">
                                                    <label for="image" class="form-label">{{ __('Image') }}</label>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-4">
                                                    <div class="suggestion-icon float-end">
                                                        <div class="tooltip-icon">
                                                            <div class="tooltip">
                                                                <div class="credit-block">
                                                                    <small class="recommended-font-size">{{ __('Recommended Size: 720x900') }}</small>
                                                                </div>
                                                            </div>
                                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="form-control" type="file" name="image" id="image" accept="image/*">
                                            <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-6">
                                        <div class="form-group">
                                            <label for="score" class="form-label">{{ __('Milestone') }}<span class="required">*</span></label>
                                            <input class="form-control @error('score') is-invalid @enderror" type="number" name="score" id="score" placeholder="{{ __('Enter Milestone of Badge') }}" aria-label="Badge Milestone" value="{{ isset($badges->score) ? $badges->score : '' }}">
                                            <div class="form-control-icon"><i class="flaticon-achieve-1"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="status" class="form-label">{{ __('Status') }}</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="1" {{ isset($badges->status) && $badges->status == 1 ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="desc" class="form-label">{!! __('Description') !!}<span class="required">*</span></label>
                                            <textarea class="form-control" id="desc" name="desc" placeholder="{!! __('Enter Description') !!}">{{ isset($badges->description) ? $badges->description : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" title="{{ __('Update') }}" class="btn btn-primary mt-3"><i
                            class="flaticon-upload-1"></i>{{ __('Update') }}</button>
                        </form>
                    </div>
                    <!-- form code end -->
                    </div>
                </div>
                <!-- End Contentbar -->
                </div>
                @endsection
