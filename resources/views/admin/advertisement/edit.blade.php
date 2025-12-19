@extends('admin.layouts.master')
@section('title', 'Advertisements')
@section('main-container')
<div class="dashboard-card">

    @component('admin.components.breadcumb',['fourthactive' => 'active'])
    @slot('heading')
    {{ __('Advertisements') }}
    @endslot
    @slot('menu1')
    {{ __('Advertisements') }}
    @endslot
    @slot('menu3')
    {{ __('Edit') }}
    @endslot
    @slot('button')

    <div class="col-md-7 col-lg-6">
                <div class="widget-button">
                    <a href="{{ route('advertisement.show') }}" class="btn btn-primary">
                        <i class="flaticon-back" title="{{ __('Back') }}"></i> {{ __('Back') }}
                    </a>
                </div>
            </div>
        @endslot
    @endcomponent

    <div class="contentbar profile-main-block">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('advertisement.update', $advertisement->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="client-detail-block">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="Title" class="form-label">{{ __('URL') }}<span
                                            class="required">*</span></label>
                                    <input class="form-control" type="url" name="url" id="title"
                                        placeholder="{{ __('Please Enter Your URL') }}" aria-label="title"
                                        value="{{ $advertisement->url }}">
                                    <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="client_name" class="form-label">{{ __('Position') }}<span
                                            class="required">*</span></label>
                                    <select class="form-select" aria-label=" " name="position">
                                        <option selected disabled> {{ __('Please Select Position') }}</option>
                                        <option value="bs" {{ old('position', $advertisement->position) === 'bs' ?
                                            'selected' : '' }}>
                                            {{ __('Below Slider') }}</option>
                                        <option value="brc" {{ old('position', $advertisement->position) === 'brc' ?
                                            'selected' : '' }}>
                                            {{ __('Below Recent Courses') }}</option>
                                        <option value="bbc" {{ old('position', $advertisement->position) === 'bbc' ?
                                            'selected' : '' }}>
                                            {{ __('Below Bundle Courses') }}</option>
                                        <option value="bt" {{ old('position', $advertisement->position) === 'bt' ?
                                            'selected' : '' }}>
                                            {{ __('Below Testimonial') }}</option>
                                    </select>
                                    <div class="form-control-icon"><i class="flaticon-position"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="client_name" class="form-label">{{ __('Pages') }}<span
                                            class="required">*</span></label>
                                    <select class="form-select" aria-label=" " name="page_type">
                                        <option selected disabled> {{ __('Please Select Position') }}</option>
                                        <option value="hp" {{ old('page_type', $advertisement->page_type) === 'hp' ?
                                            'selected' : '' }}>
                                            {{ __('Home Page') }}</option>
                                        <option value="ap" {{ old('page_type', $advertisement->page_type) === 'ap' ?
                                            'selected' : '' }}>
                                            {{ __('About Page') }}</option>
                                        <option value="bp" {{ old('page_type', $advertisement->page_type) === 'bp' ?
                                            'selected' : '' }}>
                                            {{ __('Blog Page') }}</option>
                                        <option value="tp" {{ old('page_type', $advertisement->page_type) === 'tp' ?
                                            'selected' : '' }}>
                                            {{ __('Testimonial Page') }}</option>
                                        <option value="cp" {{ old('page_type', $advertisement->page_type) === 'cp' ?
                                            'selected' : '' }}>
                                            {{ __('Contact Page') }}</option>
                                    </select>
                                    <div class="form-control-icon"><i class="flaticon-position"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <label for="title" class="form-label">{{ __('Image') }}</label>
                                            <span class="required">*</span>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="suggestion-icon float-end">
                                                <div class="tooltip-icon">
                                                    <div class="tooltip">
                                                        <div class="credit-block">
                                                            <small class="recommended-font-size">{{ __('Recommended Size
                                                                : 720x900') }}</small>
                                                        </div>
                                                    </div>
                                                    <span class="float-end"><i class="flaticon-info"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <input class="form-control" type="file" name="image" id="title" aria-label="image" accept="image/*" onchange="readURL(this);">
                                            <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="edit-img-show">
                                                <img src="{{ asset('/images/advertisement/' . $advertisement->image) }}"
                                                    alt="{{ __('advertisement_image') }}" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3" title="{{ __('Update') }}"><i
                                class="flaticon-upload-1"></i>{{ __('Update') }}</button>
                    </div>
                </form>
                <!-- form Code end -->
            </div>
        </div>
    </div>
</div>
@endsection
