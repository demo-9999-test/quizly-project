@extends('admin.layouts.master')
@section('title', 'Pages Edit')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['fourthactive' => 'active'])
    @slot('heading')
    {{ __('Pages ') }}
    @endslot
    @slot('menu1')
    {{ __('Front panel ') }}
    @endslot
    @slot('menu2')
    {{ __('Pages ') }}
    @endslot
    @slot('menu3')
    {{ __('Edit') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('pages.show') }}" title=" {{ __('Back') }}" class="btn btn-primary"><i
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
                <!-- Massage Print Code Start -->
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <!-- Massage Print Code end -->
                <!-- Form  Code start -->
                <form action="{{ url('admin/pages/' . $pages->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Use PUT method for updating -->
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="client_name" class="form-label">{{ __('Title') }}<span
                                        class="required">*</span></label>
                                <input class="form-control form-control-lg" type="text" name="title" id="heading"
                                    placeholder=" {{ __('Please Enter Your Title') }}" aria-label="Heading" required
                                    value="{{ $pages->title }}">
                                <div class="form-control-icon"><i class="flaticon-title"></i></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="client_name" class="form-label">{{ __('Slug') }}<span
                                        class="required">*</span></label>
                                <input class="form-control form-control-lg" type="text" name="slug" id="slug"
                                    placeholder=" {{ __('Please Enter Your Slug') }}" aria-label="Slug"
                                    value="{{ $pages->slug }}" required>
                                <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="client_name" class="form-label">{{ __('Page Type') }}<span
                                        class="required">*</span></label>
                                <select class="form-select" aria-label=" " name="page_link">
                                    <option value="tc" {{ old('page_link', $pages->page_link) === 'tc' ? 'selected' : ''
                                        }}>
                                        {{ __('Terms And Conditions') }}</option>
                                    <option value="pp" {{ old('page_link', $pages->page_link) === 'pp' ? 'selected' : ''
                                        }}>
                                        {{ __('Privacy Policy') }}</option>
                                    <option value="retp" {{ old('page_link', $pages->page_link) === 'retp' ? 'selected'
                                        : '' }}>
                                        {{ __('Return Policy') }}</option>
                                    <option value="refp" {{ old('page_link', $pages->page_link) === 'refp' ? 'selected'
                                        : '' }}>
                                        {{ __('Refund Policy') }}</option>
                                    <option value="ap" {{ old('page_link', $pages->page_link) === 'ap' ? 'selected' : ''
                                        }}>
                                        {{ __('Affiliate Policy') }}</option>
                                    <option value="gp" {{ old('page_link', $pages->page_link) === 'gp' ? 'selected' : ''
                                        }}>
                                        {{ __('General Policy') }}</option>
                                    <option value="au" {{ old('page_link', $pages->page_link) === 'au' ? 'selected' : ''
                                        }}>
                                        {{ __('About Us') }}</option>
                                    <option value="sp" {{ old('page_link', $pages->page_link) === 'sp' ? 'selected' : ''
                                        }}>
                                        {{ __('Shipping Policy') }}</option>
                                    <option value="tp" {{ old('page_link', $pages->page_link) === 'tp' ? 'selected' : ''
                                        }}>
                                        {{ __('Terms And Use Policy') }}</option>
                                    <option value="cp" {{ old('page_link', $pages->page_link) === 'cp' ? 'selected' : ''
                                        }}>
                                        {{ __('Cookiee Policy') }}</option>
                                    <option value="op" {{ old('page_link', $pages->page_link) === 'op' ? 'selected' : ''
                                        }}>
                                        {{ __('Other Pages') }}</option>
                                </select>
                                <div class="form-control-icon"><i class="flaticon-pages"></i></div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="desc" class="form-label">{{ __('Details') }}<span
                                        class="required">*</span></label>
                                <textarea class="form-control" required name="desc" id="desc" rows="4"
                                    placeholder=" {{ __('Please Enter Your Answer') }}">{{ $pages->desc }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group-btn">
                        <button type="submit" class="btn btn-warning me-1" name="status" title="{{ __('Save Draft') }}"
                            value="draft"><i class="flaticon-draft"></i> {{ __('Save Draft') }}</button>
                        <button type="submit" class="btn btn-success" name="status" title="{{ __('Publish') }}"
                            value="publish"><i class="flaticon-paper-plane"></i> {{ __('Publish') }}</button>
                    </div>
                </form>
                <!-- Form Code end -->
            </div>
        </div>
    </div>
</div>
@endsection
