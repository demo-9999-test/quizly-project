@extends('admin.layouts.master')
@section('title', 'Testimonials Edit')
@section('main-container')
<div class="dashboard-card">
    @component('admin.components.breadcumb',['fourthactive' => 'active'])
    @slot('heading')
    {{ __('Testimonials ') }}
    @endslot
    @slot('menu1')
    {{ __('Front panel ') }}
    @endslot
    @slot('menu2')
    {{ __('Testimonials ') }}
    @endslot
    @slot('menu3')
    {{ __('Edit') }}
    @endslot
    @slot('button')
    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('testimonial.show') }}" class="btn btn-primary" title=" {{ __('Back') }}"><i class="flaticon-back"></i>
                {{ __('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent

    <!-- Start Contentbar -->
    <div class="contentbar ">
        @include('admin.layouts.flash_msg')
        <div class="client-detail-block">
            <!-- Form  Code start-->
            <form action="{{ url('admin/testimonial/' . $testimonial->id) }}" method="post"
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
                                        @if ($testimonial->images)
                                        <img src="{{ asset('/images/testimonial/' . $testimonial->images) }}"
                                            alt="{{ __('testimonial img') }}" width="50px" height="50px">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label for="client_name" class="form-label">{{ __('Client Name') }}<span
                                    class="required">*</span></label>
                            <input class="form-control form-control-lg" type="text" name="client_name" id="client_name"
                                placeholder="{{ __('Client Name') }}" aria-label="Client Name" required
                                value="{{ $testimonial->client_name }}">
                            <div class="form-control-icon"><i class="flaticon-customer"></i></div>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <label class="form-label">{{ __('Rating') }}<span class="required">*</span></label>
                            <div id="full-stars-example-two">
                                <div class="rating-group">

                                    <label aria-label="1 star" class="rating__label" for="rating3-1"><i
                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                    <input class="rating__input" name="rating" id="rating3-1" value="1" type="radio" {{
                                        $testimonial->rating == 1 ? 'checked' : '' }}>
                                    <label aria-label="2 stars" class="rating__label" for="rating3-2"><i
                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                    <input class="rating__input" name="rating" id="rating3-2" value="2" type="radio" {{
                                        $testimonial->rating == 2 ? 'checked' : '' }}>
                                    <label aria-label="3 stars" class="rating__label" for="rating3-3"><i
                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                    <input class="rating__input" name="rating" id="rating3-3" value="3" type="radio" {{
                                        $testimonial->rating == 3 ? 'checked' : '' }}>
                                    <label aria-label="4 stars" class="rating__label" for="rating3-4"><i
                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                    <input class="rating__input" name="rating" id="rating3-4" value="4" type="radio" {{
                                        $testimonial->rating == 4 ? 'checked' : '' }}>
                                    <label aria-label="5 stars" class="rating__label" for="rating3-5"><i
                                            class="rating__icon rating__icon--star fa fa-star"></i></label>
                                    <input class="rating__input" name="rating" id="rating3-5" value="5" type="radio" {{
                                        $testimonial->rating == 5 ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label for="desc" class="form-label">{{ __('Details') }}<span
                                    class="required">*</span></label>
                            <textarea class="form-control form-control-padding_15" name="details" id="desc"
                                rows="4">{{ $testimonial->details }}</textarea>
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
