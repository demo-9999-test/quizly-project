@extends('admin.layouts.master')
@section('title', 'Footer Settings')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Footer Settings ') }}
    @endslot
    @slot('menu1')
    {{ __('Front Settings') }}
    @endslot
    @slot('menu2')
    {{ __('Footer Settings ') }}
    @endslot
    @endcomponent

    <div class="contentbar">
        @include('admin.layouts.flash_msg')
                <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- form code start -->
                <form action="{{ route('footer.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block mb-4">
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="title" class="form-label">{{ __('Title') }}</label>
                                    <input class="form-control form-control-lg" type="text" name="title" id="title"
                                        placeholder="{{ __('Please Enter Title') }}" value="{{ $settings->title }}">
                                    <div class="form-control-icon"><i class="flaticon-title"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8">
                                            <label for="image" class="form-label">{{ __('Footer Image') }}</label>
                                            <span class="required">*</span>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
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
                                        <div class="col-lg-9 col-md-9">
                                            <input class="form-control form-control-lg" type="file" name="image"
                                                id="image" accept="image">
                                            <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="edit-img-show">
                                                @if (!empty($settings->image))
                                                <img src="{{ asset('images/footer/' . $settings->image) }}"
                                                    alt="{{ $settings->name }}" class="img-fluid">
                                                @else
                                                <img src="{{ Avatar::create($settings->title)->toBase64() }}"
                                                    alt="{{ $settings->name }}" class="example-img">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="fb_url" class="form-label">{{ __('Facebook') }}</label>
                                    <input class="form-control form-control-lg" type="url" name="fb_url" id="fb_url"
                                        placeholder="{{ __('Please Enter Facebook URL') }}"
                                        value="{{ $settings->fb_url }}">
                                    <div class="form-control-icon"><i class="flaticon-facebook"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="linkedin_url" class="form-label">{{ __('Linkedin') }}</label>
                                    <input class="form-control form-control-lg" type="url" name="linkedin_url"
                                        id="linkedin_url" placeholder="{{ __('Please Enter Linkedin URL') }}"
                                        value="{{ $settings->linkedin_url }}">
                                    <div class="form-control-icon"><i class="flaticon-linkedin"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="twitter_url" class="form-label">{{ __('Twitter') }}</label>
                                    <input class="form-control form-control-lg" type="url" name="twitter_url"
                                        id="twitter_url" placeholder="{{ __('Please Enter Twitter URL') }}"
                                        value="{{ $settings->twitter_url }}">
                                    <div class="form-control-icon"><i class="flaticon-twitter"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="insta_url" class="form-label">{{ __('Instagram') }}</label>
                                    <input class="form-control form-control-lg" type="url" name="insta_url"
                                        id="insta_url" placeholder="{{ __('Please Enter Instagram URL') }}"
                                        value="{{ $settings->insta_url }}">
                                    <div class="form-control-icon"><i class="flaticon-instagram"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="Copyright Text" class="form-label">{{ __('Copyright Text') }}</label>
                                    <input class="form-control form-control-lg " type="text" name="copyright_text"
                                        placeholder="{{ __('Please Enter Your Copyright Text') }}"
                                        value="{{ $settings->copyright_text }}">
                                    <div class="form-control-icon"><i class="flaticon-copyright"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-8">
                                            <label for="promoLink" class="form-label">{{ __('Footer Logo ') }}</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-4">
                                            <div class="suggestion-icon float-end">
                                                <div class="tooltip-icon">
                                                    <div class="tooltip">
                                                        <div class="credit-block">
                                                            <small class="recommended-font-size">{{ __(' (Note -Recommended Size : 180X55px) ') }}</small>
                                                        </div>
                                                    </div>
                                                    <span class="float-end"><i class="flaticon-info"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-8">
                                            <input class="form-control" type="file" name="footer_logo" id="promoLink_2"
                                                onchange="readURL(this);">
                                            <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-4">
                                            <div class="edit-img-show">
                                                @if (!empty($settings->footer_logo))
                                                <img src="{{ asset('images/footer_logo/' . $settings->footer_logo) }}"
                                                    alt="{{ __('Footer Logo') }}" class="img-fluid" id="footer_logo">
                                                @else
                                                <img src="{{ Avatar::create($settings->title)->toBase64() }}"
                                                    class="example-img" alt="{{ __('Footer Logo') }}">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label for="desc" class="form-label">{{ __('Description') }}</label>
                                    <textarea name="desc" id="desc">{{ $settings->desc }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" title="{{ __('Submit') }}">
                        <i class="flaticon-upload-1"></i>{{__('Submit') }}</button>
                </form>
            </div>
        </div>
        <!--form code end--->
    </div>
</div>
@endsection
