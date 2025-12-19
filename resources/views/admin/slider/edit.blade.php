@extends('admin.layouts.master')
@section('title', 'Slider Edit')
@section('main-container')
<div class="dashboard-card">

    @component('admin.components.breadcumb',['fourthactive' => 'active'])
    @slot('heading')
    {{ __('Sliders ') }}
    @endslot
    @slot('menu1')
    {{ __('Front Settings ') }}
    @endslot
    @slot('menu2')
    {{ __('Sliders ') }}
    @endslot
    @slot('menu3')
    {{ __('Edit') }}
    @endslot
    @slot('button')
    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('slider.show') }}" title="{{ __('Back') }}" class="btn btn-primary"><i
                    class="flaticon-back"></i>
                {{ __('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent


    <!-- Start Contentbar -->
    <div class="contentbar  ">
        @include('admin.layouts.flash_msg')
        <div class="client-detail-block">
            <div class="registration-block">

                <!-- Form  Code start-->
                <form action="{{ url('admin/slider/' . $slider->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="client_name" class="form-label">{{ __('Heading') }}<span
                                        class="required">*</span></label>
                                <input class="form-control form-control-lg" type="text" name="heading" id="client_name"
                                    placeholder="{{ __('Enter Heading') }}" aria-label="Heading" required
                                    value="{{ $slider->heading }}">
                                <div class="form-control-icon"><i class="flaticon-heading"></i></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="client_name" class="form-label">{{ __('Sub Heading') }}<span
                                        class="required">*</span></label>
                                <input class="form-control form-control-lg" type="text" name="sub_heading" required
                                    id="client_name" placeholder="{{ __('Enter Sub Heading') }}"
                                    aria-label="sub_heading" value="{{ $slider->sub_heading }}">
                                <div class="form-control-icon"><i class="flaticon-heading"></i></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="status" class="form-label">{{ __('Text Position') }}</label>
                                <select class="form-select" aria-label=" " name="text_position">
                                    <option selected disabled>{{ __('Select Text Position') }}</option>
                                    <option value="l" {{ old('left', $slider->text_position) === 'l' ? 'selected' : ''
                                        }}>
                                        {{ __('Left') }}</option>
                                    <option value="c" {{ old('center', $slider->text_position) === 'c' ? 'selected' : ''
                                        }}>
                                        {{ __('Center') }}</option>
                                    <option value="r" {{ old('right', $slider->text_position) === 'r' ? 'selected' : ''
                                        }}>
                                        {{ __('Right') }}</option>
                                </select>
                                <div class="form-control-icon"><i class="flaticon-position"></i></div>
                            </div>
                        </div>
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
                                            accept="image/*" onchange="readURL(this);">
                                        <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="edit-img-show">
                                            @if ($slider->images)
                                            <img src="{{ asset('/images/slider/' . $slider->images) }}"
                                                alt="{{ __('slider img') }}" id="images" class="widget-img">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="desc" class="form-label">{{ __('Details') }}<span
                                        class="required">*</span></label>
                                <textarea class="form-control form-control-padding_15" name="details" id="desc" required
                                    rows="4">{{ $slider->details }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group-btn">
                                <button type="submit" class="btn btn-warning me-1" name="status"
                                    title="{{ __('Save Draft') }}" value="draft"><i class="flaticon-draft"></i> {{
                                    __('Save Draft') }}</button>
                                <button type="submit" class="btn btn-success" name="status" title="{{ __('Publish') }}"
                                    value="publish"><i class="flaticon-paper-plane"></i> {{ __('Publish') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Form  Code end-->
            </div>
        </div>
    </div>
</div>
@endsection
