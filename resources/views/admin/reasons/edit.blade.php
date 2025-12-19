@extends('admin.layouts.master')
@section('title', 'Reason')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Reason ') }}
    @endslot
    @slot('menu1')
    {{ __('Reason ') }}
    @endslot
    @slot('menu2')
    {{ __('Edit ') }}
    @endslot

    @slot('button')
    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('reason.show') }}" title="{{__('Back')}}" class="btn btn-primary"><i class="flaticon-back"></i>
                {{ __('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent

    <!-- Start Contentbar -->
    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <form action="{{ route('reason.update', $reason->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="client-detail-block mb-4">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-4">
                            <label for="reason" class="form-label">{{ __('Reason') }}<span class="required">*</span></label>
                            <input class="form-control mb-2" type="text" name="reason" required id="reason" value="{{ $reason->reason }}" placeholder="{{ __('Enter Your Title') }}" aria-label="reason" value="{{ old('reason') }}">
                            <div class="form-control-icon"><i class="flaticon-title"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="col-lg-4 col-md-4 col-4">
                            <div class="status">
                                <div class="form-group">
                                    <label for="status" class="form-label">{{ __('Status') }}</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="1" {{ $reason->status ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
            </form>
        </div>
    </div>
@endsection
