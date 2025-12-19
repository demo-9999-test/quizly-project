@extends('admin.layouts.master')
@section('title', 'Permission')
@section('main-container')

    <div class="contentbar bardashboard-card ">
        @include('admin.layouts.flash_msg')
        <div class="dashboard-card">
            <div class="invoice-main-block-two">
                <div class="row">
                    <div class="col-lg-12">
                          <!-----------form code start--------->
                        <form action="{{ route('permission.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="client-detail-block">
                                <h5>{{__('Create a new Permission')}}</h5>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="client-name">
                                            <label for="heading" class="form-label">{{ __('Permission Name ') }}<span
                                                    class="required">*</span></label>
                                            <input class="form-control form-control-lg" type="text" name="name"
                                                id="heading" placeholder="{{ __('Please Enter Permission Name') }}"
                                                aria-label="Heading" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" title="{{ __('Submit') }}" class="btn btn-primary add-items mt-3">{{ __('Submit') }}</button>
                            </div>
                        </form>
                         <!-----------form code end-------->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
