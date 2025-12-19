@extends('admin.layouts.master')
@section('title', 'Edit Trusted Slider')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb', ['thirdactive' => 'active'])
        @slot('heading')
            {{ __('Edit Trusted Slider') }}
        @endslot
        @slot('menu1')
            {{ __('Trusted Slider') }}
        @endslot
        @slot('menu2')
            {{ __('Edit') }}
        @endslot
        @slot('button')
            <div class="col-md-6 col-lg-6">
                <div class="widget-button">
                    <a href="{{ route('trusted.slider.index') }}" class="btn btn-primary" title="{{ __('Back') }}"><i class="flaticon-back"></i> {{ __('Back') }}</a>
                </div>
            </div>
        @endslot
    @endcomponent

<div class="contentbar">
    @include('admin.layouts.flash_msg')
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('trusted.slider.update', $trustedslider->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="url" class="form-label">{{ __('URL') }}<span class="text-danger">*</span></label>
                                    <input class="form-control @error('url') is-invalid @enderror" type="url" name="url" id="url" placeholder="{{ __('Enter URL') }}" value="{{ old('url', $trustedslider->url) }}">
                                    <div class="form-control-icon"><i class="flaticon-browser"></i></div>

                                    @error('url')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="image" class="form-label">{{ __('Image') }}<span class="text-danger">*</span></label>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image" accept="image/*">
                                    <div class="form-control-icon"><i class="flaticon-upload"></i></div>

                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 mt-3">
                                <div class="image-preview-container">
                                    <img id="imagePreview" src="{{ asset('images/trusted-slider/' . $trustedslider->image) }}" alt="{{__('Current Image')}}" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                </div>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <div class="form-group">
                                    <label for="status" class="form-label">{{ __('Status') }}</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="1" {{ old('status', $trustedslider->status) ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('admin_theme/assets/js/image-preview.js') }}"></script>
@endsection
