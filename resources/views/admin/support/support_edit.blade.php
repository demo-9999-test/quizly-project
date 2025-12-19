@extends('admin.layouts.master')
@section('title', 'Supports')
@section('main-container')
<div class="dashboard-card">
    @component('admin.components.breadcumb',['fourthactive' => 'active'])
    @slot('heading')
    {{ __('Supports') }}
    @endslot
    @slot('menu1')
    {{ __('Help & Support') }}
    @endslot
    @slot('menu2')
    {{ __('Supports') }}
    @endslot
    @slot('menu3')
    {{ __('Edit') }}
    @endslot
    @slot('button')
    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#bulk_delete"><i
                    class="flaticon-delete"></i> {{ __('Delete') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent
    <div class="contentbar profile-main-block">
        @include('admin.layouts.flash_msg')
                <div class="row">
            <div class="col-lg-12">
                <!--form code start-->
                <form action="{{ url('admin/support_users/' . $supportsissues->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="client-detail-block">
                        <h5 class="block-heading"></h5>
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __('Priority') }}<span
                                            class="required">*</span></label>
                                            <select class="form-select" aria-label=" " name="priority">
                                                <option selected disabled>{{ __('Select Priority ') }}</option>
                                                <option {{ $supportsissues->priority == 'L' ? 'selected' : '' }} value="L">{{ __('Lower') }}</option>
                                                <option {{ $supportsissues->priority == 'M' ? 'selected' : '' }} value="M">{{ __('Mid') }}</option>
                                                <option {{ $supportsissues->priority == 'H' ? 'selected' : '' }} value="H">{{ __('High') }}</option>
                                                <option {{ $supportsissues->priority == 'C' ? 'selected' : '' }} value="C">{{ __('Critical') }}</option>
                                            </select>
                                            <div class="form-control-icon"><i class="flaticon-stock-exchange-app"></i></div>

                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="email" class="form-label">{{ __('Support Type') }}<span
                                            class="required">*</span></label>
                                            <select class="form-select" aria-label=" " name="support_id">
                                                <option selected disabled>{{ __('Select support Type ') }}</option>
                                                @foreach ($supports_types as $support)
                                                <option {{ $supportsissues->support_id == $support->id ? 'selected' : '' }} value="{{ $support->id }}">{{ $support->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="form-control-icon"><i class="flaticon-email-2"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-8">
                                            <label for="image" class="form-label">{{ __('Image') }}</label>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-8">
                                            <input class="form-control" type="file" name="image"
                                            id="images" accept="image/*" onchange="readURL(this);">
                                            <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-4">
                                            <div class="edit-img-show">
                                                <img src="{{ asset('/images/support_issue/' . $supportsissues->image) }}" alt="img"
                                                class="img-fluid" id="image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label for="slug" class="form-label">{{ __('Message	') }}<span
                                            class="required">*</span></label>
                                            <textarea class="form-control" name="message" id="desc" cols="30" rows="5"  placeholder="{{__('Please enter your message')}}" required>{{ $supportsissues->message }}</textarea>
                                </div>

                            </div>

                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="flaticon-upload-1"></i> {{ __('Submit') }}</button>
                </form>
                <!-- form code end -->
            </div>

        </div>
    </div>
</div>
@endsection
