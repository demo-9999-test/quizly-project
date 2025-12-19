@extends('admin.layouts.master')
@section('title', 'Post Categories')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['fourthactive' => 'active'])
    @slot('heading')
    {{ __('Post Categories') }}
    @endslot
    @slot('menu1')
    {{ __('Front Settings') }}
    @endslot
    @slot('menu2')
    {{ __('Post Categories') }}
    @endslot
    @slot('menu3')
    {{ __('Edit') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('post_category.index') }}" title={{__('Back')}} class="btn btn-primary"><i class="flaticon-back"></i>{{ __('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent
    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-4 col-md-5">
                <!-- form Code start -->
                <form action="{{ url('admin/post-category/' . $category->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="client-detail-block mb-4">
                        <div class="form-group">
                            <label for="title" class="form-label">{{ __('Categories') }}<span
                                class="required">*</span></label>
                            <input class="form-control" type="text" name="categories" required id="categories"
                                placeholder="{{ __('Enter Your categories') }}" aria-label="title"
                                value="{{$category->categories }}">
                            <div class="form-control-icon"><i class="flaticon-heading"></i></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-4">
                                <div class="status">
                                    <div class="form-group">
                                        <label for="status" class="form-label">{{ __('Status') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="status"
                                                name="status" value="1" {{ $category->status == 1 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-btn">
                            <button type="submit" class="btn btn-primary"><i class="flaticon-upload-1"></i>{{ __('Submit') }}</button>
                        </div>
                    </div>
                </form>
                <!-- form Code end -->
                </div>
            </div>
        </div>
    </div>
    @endsection
