@extends('admin.layouts.master')
@section('title', 'General Setting')
@section('main-container')
    <div class="dashboard-card">

        @component('admin.components.breadcumb', ['thirdactive' => 'active'])
            @slot('heading')
                {{ __('General Settings ') }}
            @endslot
            @slot('menu1')
                {{ __('Project Settings') }}
            @endslot
            @slot('menu2')
                {{ __('General Settings ') }}
            @endslot
        @endcomponent

        <div class="contentbar  ">
            @include('admin.layouts.flash_msg')
            <div class="row">
                <div class="col-lg-12">
                    <!--form code start-->
                    <form action="{{ route('general-setting.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="client-detail-block mb-4">
                            <div class="row align-items-center">
                                <h5 class="block-heading">{{ __('Basic Setting') }}</h5>
                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for="Title" class="form-label">{{ __('Project Title') }} <span
                                                class="required">*</span></label>
                                        <input class="form-control form-control-lg" type="text" name="APP_NAME"
                                            placeholder="{{ __('Enter Your Title') }}" aria-label="title"
                                            value="{{ $appName }}">
                                        <div class="form-control-icon"><i class="flaticon-title"></i></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for="Contact" class="form-label">{{ __('Contact') }} <span
                                                class="required">*</span></label>
                                        <input class="form-control form-control-lg" type="number" name="contact"
                                            placeholder="{{ __('Enter Your Contact Number') }}"
                                            value="{{ $settings->contact }}" aria-label="Contact">
                                        <div class="form-control-icon"><i class="flaticon-telephone"></i></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for="Contact" class="form-label">{{ __('Support Mail') }} <span
                                                class="required">*</span></label>
                                        <input class="form-control form-control-lg" type="email" name="support_email"
                                            placeholder="Enter Your Support Mail" value="{{ $settings->support_email }}"
                                            aria-label="Contact">
                                        <div class="form-control-icon"><i class="flaticon-mail"></i></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <label for="Email" class="form-label">{{ __('Email') }} <span
                                                class="required">*</span></label>
                                        <input class="form-control form-control-lg " type="email" name="email"
                                            placeholder="{{ __('Enter Your Email') }}" value="{{ $settings->email }}">
                                        <div class="form-control-icon"><i class="flaticon-email"></i></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-8">
                                                <label for="promoLink" class="form-label">{{ __('Favicon') }}<span
                                                        class="required">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-4">
                                                <div class="suggestion-icon float-end">
                                                    <div class="tooltip-icon">
                                                        <div class="tooltip">
                                                            <div class="credit-block">
                                                                <small
                                                                    class="recommended-font-size">{{ __(' (Note -
                                                                    Recommended Size : 35x35PX) ') }}</small>
                                                            </div>
                                                        </div>
                                                        <span class="float-end"><i class="flaticon-info"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-lg-8 col-md-8 col-8">
                                                <input class="form-control " type="file" name="favicon_logo"
                                                    id="promoLink" onchange="readURL(this);">
                                                <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-4">
                                                <div class="edit-img-show">
                                                    <img src="{{ asset('images/favicon/' . $settings->favicon_logo) }}"
                                                        alt="{{ __('Favicon Logo') }}" class="img-fluid"
                                                        id="favicon_logo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <div class="form-group" id="preloaderSection">
                                        <div class="row" >
                                            <div class="col-lg-8 col-md-10 col-8">
                                                <label for="promoLink" class="form-label">{{ __('Preloader logo ') }}</label>
                                            </div>
                                            <div class="col-lg-4 col-md-2 col-4">
                                                <div class="suggestion-icon float-end">
                                                    <div class="tooltip-icon">
                                                        <div class="tooltip">
                                                            <div class="credit-block">
                                                                <small class="recommended-font-size">{{ __(' (Note - Recommended Size : 300x90PX) ') }}</small>
                                                            </div>
                                                        </div>
                                                        <span class="float-end"><i class="flaticon-info"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                
                                        <!-- 👇 Wrap this section to control show/hide -->
                                        <div >
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-8" id="preloaderLogoInputBox">
                                                    <input class="form-control" type="file" name="preloader_logo"
                                                        id="promoLink_3" onchange="readURL(this);">
                                                    <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-4">
                                                    <div class="edit-img-show">
                                                        @if (!empty($settings->preloader_logo))
                                                            <img src="{{ asset('images/preloader/' . $settings->preloader_logo) }}"
                                                                alt="{{ __('Preloader Logo') }}" class="img-fluid"
                                                                id="preloader_logo">
                                                        @else
                                                            <img src="{{ Avatar::create($settings->title)->toBase64() }}"
                                                                class="example-img" alt="{{ __('Preloader Logo') }}">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- 👆 End wrapper -->
                                    </div>
                                </div>
                                
                                <div class="col-lg-2 col-md-4">
                                    <div class="form-group">
                                        <label for="app_status" class="form-label">{{ __('Preloader Enable') }}</label>
                                        <div class="form-check form-switch">
                                            <!-- ✅ Set id here for JS -->
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="preloaderEnableToggle" name="preloader_enable_status" value="1"
                                                {{ $settings->preloader_enable_status == 1 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="col-lg-4 col-md-12">
                                    <div class="row align-items-center">
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label for="status" class="form-label">{{ __('Logo') }}</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="customSwitch" name="logostatus" value="1" checked>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-9 col-md-9">
                                            <div class="form-group" id="textInputBox">
                                                <div class="row">
                                                    <div class="col-lg-8 col-md-8 col-8">
                                                        <label for="promoLink"
                                                            class="form-label">{{ __('Logo Image') }}<span
                                                                class="required">*</span> </label>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-4">
                                                        <div class="suggestion-icon float-end">
                                                            <div class="tooltip-icon">
                                                                <div class="tooltip">
                                                                    <div class="credit-block">
                                                                        <small
                                                                            class="recommended-font-size">{{ __(' (Note -
                                                                                Recommended Size : 300x90PX) ') }}
                                                                            <br> {{ __(' (Note - .jpg , .png) ') }}</small>
                                                                    </div>
                                                                </div>
                                                                <span class="float-end"><i
                                                                        class="flaticon-info"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-8 col-md-8 col-8">
                                                        <input class="form-control form-control-lg " type="file"
                                                            name="logo" id="promoLink_1" aria-label="Promo Link"
                                                            onchange="readURL(this);">
                                                        <div class="form-control-icon"><i class="flaticon-upload"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-4">
                                                        <div class="edit-img-show">
                                                            <img src="{{ asset('images/logo/' . $settings->logo) }}"
                                                                alt="{{ __('logo') }}" class="img-fluid"
                                                                id="logo">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-group hidden" id="logoInputBox">
                                                <label for="" class="form-label">{{ __('Logo Name') }}<span
                                                        class="required">*</span></label>
                                                <input class="form-control form-control-lg" type="text" name="logo"
                                                    id="" placeholder="logo name" aria-label=""
                                                    value="{{ old('offer_price') }}" min="0">
                                                <div class="form-control-icon"><i class="flaticon-gross"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-8">
                                                <label for="breadcrumb" class="form-label">{{ __('Breadcrumb Image') }}<span
                                                        class="required">*</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-4">
                                                <div class="suggestion-icon float-end">
                                                    <div class="tooltip-icon">
                                                        <div class="tooltip">
                                                            <div class="credit-block">
                                                                <small class="recommended-font-size">{{ __(' (Note -
                                                                    Recommended Size : 336x336PX) ') }}</small>
                                                            </div>
                                                        </div>
                                                        <span class="float-end"><i class="flaticon-info"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-8">
                                                <input class="form-control " type="file" name="breadcrumb_img" id="breadcrumb"
                                                    onchange="readURL(this);">
                                                <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-4">
                                                <div class="edit-img-show">
                                                    <img src="{{ asset('images/breadcrumb/' . $settings->breadcrumb_img) }}"
                                                        alt="{{ __('Breadcrumb Image') }}" class="img-fluid" id="breadcrumbimg">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="Address" class="form-label">{{ __('Address') }}</label>
                                        <textarea name="address" id="desc" cols="40" rows="1" class="form-control form-control-padding_15"
                                            placeholder="{{ __('Address') }}">{{ $settings->address }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="client-detail-block mb-4">
                            <h5 class="block-heading">{{ __('Map Settings') }}
                            </h5>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-8">
                                        <label for="slug" class="form-label">{{ __('Iframe URL') }}</label>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-4">
                                        <div class="suggestion-icon float-end">
                                            <div class="tooltip-icon">
                                                <div class="tooltip">
                                                    <div class="credit-block">
                                                        <small class="recommended-font-size">{{ __(' () ') }}</small>
                                                    </div>
                                                </div>
                                                <span class="float-end"><i class="flaticon-info"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input class="form-control form-control-lg " type="text" name="iframe_url"
                                    id="iframe_url" placeholder="{{ __('Please Enter Your Iframe URL') }}"
                                    aria-label="Iframe URL" value="{{ $settings->iframe_url }}">
                                <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                            </div>
                        </div>

                        <div class="client-detail-block mb-4">
                            <div class="row ">
                                <h5 class="block-heading">{{ __('Promo Bar') }}</h5>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label for="promoText" class="form-label">{{ __('Promo Text') }}</label>
                                        <input class="form-control form-control-lg " type="text" name="promo_text"
                                            id="promoText" placeholder="{{ __('Please Enter Promo Text') }}"
                                            value="{{ $settings->promo_text }}" aria-label="Promo Text">
                                        <div class="form-control-icon"><i class="flaticon-title"></i></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label for="promoLink" class="form-label">{{ __('Promo Link') }}</label>
                                        <input class="form-control form-control-lg " type="url" name="promo_link"
                                            id="promoLink" placeholder="{{ __('Please Enter Your Promo Text Link') }}"
                                            aria-label="Promo Link" value="{{ $settings->promo_link }}">
                                        <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <button type="submit" title="{{ __('Update') }}" class="btn btn-primary mt-3"><i
                                class="flaticon-upload-1"></i> {{ __('Update') }}</button>
                </div>
                </form>
                <!--form code end -->
            </div>
        </div>
    </div>
    <!-- ✅ JavaScript Code -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggle = document.getElementById('preloaderEnableToggle');
            const section = document.getElementById('preloaderSection');
    
            function updateSectionVisibility() {
                section.style.display = toggle.checked ? 'block' : 'none';
            }
    
            toggle.addEventListener('change', updateSectionVisibility);
            updateSectionVisibility(); // Initial check
        });
    </script>
    
    
@endsection
