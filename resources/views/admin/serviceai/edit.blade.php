@extends('admin.layouts.master')
@section('title', 'Service')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Service') }}
    @endslot
    @slot('menu1')
    {{ __('Front Panel') }}
    @endslot
    @slot('menu2')
    {{ __('Service') }}
    @endslot
    @slot('button')

    <div class="col-md-7 col-lg-7">
        <div class="widget-button">
            <a href="{{ route('services.index') }}" type="button" title="{{__('Back')}}" class="btn btn-success"><i class="flaticon-back"></i>{{__('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent
    <div class="contentbar">
        @include('admin.layouts.flash_msg')
                <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- form Code start -->
                <form action="{{url('admin/services/' . $service->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="client-detail-block mb-4">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="title" class="form-label">{{ __('Title') }}<span
                                        class="required">*</span></label>
                                <input class="form-control" type="text" name="name" required id="title"
                                    placeholder="{{ __('Enter Your Title') }}" aria-label="title"
                                    value="{{$service->name }}">
                                <div class="form-control-icon"><i class="flaticon-heading"></i></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-4">
                                <div class="status">
                                    <div class="form-group">
                                        <label for="status" class="form-label">{{ __('Status') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="sticky"
                                                name="status" value="1" {{ $service->status == 1 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-btn">
                            <button type="submit" class="btn btn-success" title="{{ __('Submit') }}"><i
                                class="flaticon-paper-plane"></i> {{ __('Submit') }}</button>
                        </div>
                    </div>
                </form>
                <!-- form Code end -->
            </div>
        </div>
    </div>
</div>
@endsection
