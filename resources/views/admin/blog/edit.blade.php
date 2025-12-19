@extends('admin.layouts.master')
@section('title', 'Post Edit')
@section('main-container')


<div class="dashboard-card">
    @component('admin.components.breadcumb',['fourthactive' => 'active'])
    @slot('heading')
    {{ __('Post') }}
    @endslot
    @slot('menu1')
    {{ __('Front Settings') }}
    @endslot
    @slot('menu2')
    {{ __('Post') }}
    @endslot
    @slot('menu3')
    {{ __('Edit') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('post.show') }}" title="{{__('Back')}}" class="btn btn-primary"><i class="flaticon-back"></i>{{ __('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent
    <!-- Start Contentbar -->
    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="client-detail-block">
            <div class="registration-block">
                <!-- Form  Code start -->
                <form action="{{ url('admin/post/' . $blog->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Use PUT method for updating -->
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-8">
                                        <label for="image" class="form-label">{{ __('Thumbnail Image') }}</label>
                                        <span class="required">*</span>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-4">
                                        <div class="suggestion-icon float-end">
                                            <div class="tooltip-icon">
                                                <div class="tooltip">
                                                    <div class="credit-block">
                                                        <small class="recommended-font-size">{{ __('Recommended Size :720x900') }}</small>
                                                    </div>
                                                </div>
                                                <span class="float-end"><i class="flaticon-info"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-9 col-md-8 col-8">
                                        <input class="form-control" type="file" name="thumbnail_img" id="image"
                                            accept="image/*" onchange="readURL(this);">
                                        <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-4">
                                        <div class="edit-img-show">
                                            @if ($blog->thumbnail_img)
                                            <img src="{{ asset('/images/blog/' . $blog->thumbnail_img) }}"
                                                alt="{{ __('blog img') }}" class="img-fluid" id="images">
                                            @else
                                            <img src="{{ Avatar::create($blog->name)->toBase64() }}"  alt=" {{ __('blog img') }}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-8">
                                        <label for="image" class="form-label">{{ __('Banner Image') }}</label>
                                        <span class="required">*</span>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-4">
                                        <div class="suggestion-icon float-end">
                                            <div class="tooltip-icon">
                                                <div class="tooltip">
                                                    <div class="credit-block">
                                                        <small class="recommended-font-size">{{ __('Recommended Size :720x900') }}</small>
                                                    </div>
                                                </div>
                                                <span class="float-end"><i class="flaticon-info"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-9 col-md-8 col-8">
                                        <input class="form-control" type="file" name="banner_img" id="image"
                                            accept="image/*" onchange="readURL(this);">
                                        <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-4">
                                        <div class="edit-img-show">
                                            @if ($blog->banner_img)
                                            <img src="{{ asset('/images/blog/' . $blog->banner_img) }}"
                                                alt="{{ __('blog img') }}" class="img-fluid" id="images">
                                                @else
                                                <img src="{{ Avatar::create($blog->name)->toBase64() }}"  alt=" {{ __('blog img') }}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-group">
                                <label for="Heading" class="form-label">{{ __('Title') }}<span
                                        class="required">*</span></label>
                                <input class="form-control" type="text" name="title" id="title"
                                    placeholder="{{ __('Please Enter Your Title') }}" aria-label="Heading" required
                                    value="{{ $blog->title }}">
                                <div class="form-control-icon"><i class="flaticon-heading"></i></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="form-group">
                                <label for="client_name" class="form-label">{{ __('Slug') }}<span
                                        class="required">*</span></label>
                                <input class="form-control custom-input" type="text" name="slug" id="slug"
                                    placeholder="{{ __('Please Enter Your Slug') }}" aria-label="Slug"
                                    value="{{ $blog->slug }}" required>
                                <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4">
                        <div class="form-group">
                            <label for="category_id" class="form-label">{{ __('Category') }}<span class="required"> *</span></label>
                            <select class="form-select" aria-label=" " name="category_id">
                                <option disabled>{{ __('Select Category') }}</option>
                                @foreach ($categoryData as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $blog->category_id ? 'selected' : '' }}>{{ $category->categories }}</option>
                                @endforeach
                            </select>
                            <div class="form-control-icon"><i class="flaticon-pages"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label for="desc" class="form-label">{{ __('Details') }}</label>
                            <textarea class="form-control" required name="desc" id="desc"
                                rows="4">{{ $blog->desc }}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-4">
                        <div class="form-group">
                            <label for="status" class="form-label">{{ __('Sticky') }}</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="statusToggle"
                                    name="sticky" value="1" {{ $blog->sticky == 1 ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-4">
                        <div class="form-group">
                            <label for="status" class="form-label">{{ __('Approved') }}</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="statusToggle"
                                    name="approved" value="1" {{ $blog->approved == 1 ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-4">
                        <div class="form-group">
                            <label for="status" class="form-label">{{ __('Featured') }}</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="statusToggle"
                                    name="is_featured" value="1" {{ $blog->is_featured == 1 ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group-btn">
                            <button type="submit" class="btn btn-warning me-1" name="status"
                                title="{{ __('Save Draft') }}" value="draft"><i class="flaticon-draft"></i> {{__('Save Draft') }}</button>
                            <button type="submit" class="btn btn-success" name="status" title="{{ __('Publish') }}"
                                value="publish"><i class="flaticon-paper-plane"></i> {{ __('Publish') }}</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Form  Code end -->
            </div>
        </div>
    </div>
    <!-- End Contentbar -->
</div>
@endsection
