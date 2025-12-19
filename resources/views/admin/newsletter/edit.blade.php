@extends('admin.layouts.master')
@section('title', 'Newsletter Edit')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['fourthactive' => 'active'])
    @slot('heading')
    {{ __('Newsletter ') }}
    @endslot
    @slot('menu1')
    {{ __('Front panel ') }}
    @endslot
    @slot('menu2')
    {{ __('Newsletter ') }}
    @endslot
    @slot('menu3')
    {{ __('Edit') }}
    @endslot
    @slot('button')
    
    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('newsletter.index') }}" class="btn btn-primary"><i class="flaticon-back"
                    title=" {{ __('Back') }}"></i>
                {{ __('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent

    <!-- Start Contentbar -->
    <div class="contentbar ">
        @include('admin.layouts.flash_msg');
        <div class="client-detail-block">
            <!-- Form  Code start-->
            <form action="{{ url('admin/newsletter/' . $newsletter->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-8 col-md-8">
                                    <label for="image" class="form-label">{{ __('Image') }}</label>
                                    <span class="required">*</span>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="suggestion-icon float-end">
                                        <div class="tooltip-icon">
                                            <div class="tooltip">
                                                <div class="credit-block">
                                                    <small class="recommended-font-size">{{ __('Recommended Size :
                                                        720x900') }}</small>
                                                </div>
                                            </div>
                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-9 col-md-9">
                                    <input class="form-control form-control-lg" type="file" name="images" id="image"
                                        accept="image/*">
                                    <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="edit-img-show">
                                        @if ($newsletter->image)
                                        <img src="{{ asset('/images/newsletter/' . $newsletter->image) }}"
                                            alt="{{ __('newsletter img') }}" width="50px" height="50px">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label for="title" class="form-label">{{ __('Title') }}<span
                                    class="required">*</span></label>
                            <input class="form-control form-control-lg" type="text" name="title" id="title"
                                placeholder="{{ __('Title') }}" aria-label="Title" required
                                value="{{ $newsletter->title }}">
                            <div class="form-control-icon"><i class="flaticon-customer"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label for="btn_text" class="form-label">{{ __('Button Text') }}<span
                                    class="required">*</span></label>
                            <input class="form-control form-control-lg" type="text" name="btn_text" id="btn_text"
                                placeholder="{{ __('Button Text') }}" aria-label="Title" required
                                value="{{ $newsletter->btn_text }}">
                            <div class="form-control-icon"><i class="flaticon-customer"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label for="desc" class="form-label">{{ __('Details') }}<span
                                    class="required">*</span></label>
                            <textarea class="form-control form-control-padding_15" name="details"
                                rows="4">{{ $newsletter->details }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="form-group-btn">
                        <button type="submit" class="btn btn-warning me-1" name="status" title="{{ __('Save Draft') }}"
                            value="draft"><i class="flaticon-draft"></i> {{ __('Save Draft') }}</button>
                        <button type="submit" class="btn btn-success" name="status" title="{{ __('Publish') }}"
                            value="publish"><i class="flaticon-paper-plane"></i> {{ __('Publish') }}</button>
                    </div>
                </div>
            </form>
            <!-- Form  Code end -->
        </div>
    </div>
</div>
@endsection
