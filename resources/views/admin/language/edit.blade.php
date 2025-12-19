@extends('admin.layouts.master')
@section('title', 'Language Edit')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['fourthactive' => 'active'])
    @slot('heading')
    {{ __('Languages') }}
    @endslot
    @slot('menu1')
    {{ __('Project Settings') }}
    @endslot
    @slot('menu2')
    {{ __('Languages') }}
    @endslot
    @slot('menu3')
    {{ __('Edit') }}
    @endslot
    @slot('button')
    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('language.show') }}" title="{{__('Back')}}" class="btn btn-primary"><i class="flaticon-back"></i>{{ __('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent
    <div class="contentbar ">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <!-- Massage Print Code Start --->
                 @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('success'))
                    <h6 class="alert alert-success">{{ session('success') }}</h6>
                @elseif (session('warning'))
                    <h6 class="alert alert-warning">{{ session('warning') }}</h6>
                @endif
                <!-- Massage Print Code end -->
                <!----form code start--->
                <form action="{{ url('admin/language/' . $language->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="client-detail-block">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-10 col-10">
                                            <label for="Title" class="form-label">{{ __('Local') }}</label>
                                            <a href="https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes"> <small
                                                class="link_recommendation" title="{{ __('(Language ISO Code)') }}">{{ __('(Language ISO Code)') }}</small></a>
                                            <span class="required">*</span>
                                        </div>
                                        <div class="col-lg-4 col-md-2 col-2">
                                            <div class="suggestion-icon float-end">
                                                <div class="tooltip-icon">
                                                    <div class="tooltip">
                                                        <div class="credit-block">
                                                            <small class="recommended-font-size">{{ __('(Ex. local: en)') }}</small>
                                                        </div>
                                                    </div>
                                                    <span class="float-end"><i class="flaticon-info"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input class="form-control" type="text" name="local"
                                        id="title" placeholder="Enter Your Language Local Name" aria-label="title"
                                        required value="{{ $language->local }}">
                                    <div class="form-control-icon"><i class="flaticon-language"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-8">
                                            <label for="name" class="form-label">{{ __('Name') }}</label>
                                            <span class="required">*</span>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-4">
                                            <div class="suggestion-icon float-end">
                                                <div class="tooltip-icon">
                                                    <div class="tooltip">
                                                        <div class="credit-block">
                                                            <small class="recommended-font-size">{{ __('(Ex. Name: English)') }}</small>
                                                        </div>
                                                    </div>
                                                    <span class="float-end"><i class="flaticon-info"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input class="form-control" type="text" name="name"
                                        placeholder="Please Enter Your Language Name" aria-label="Slug"
                                        value="{{ $language->name }}" required>
                                    <div class="form-control-icon"><i class="flaticon-user"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-10 col-8">
                                            <label for="image" class="form-label">{{ __('Language Image') }}</label>
                                            <span class="required">*</span>
                                        </div>
                                        <div class="col-lg-4 col-md-2 col-4">
                                            <div class="suggestion-icon float-end">
                                                <div class="tooltip-icon">
                                                    <div class="tooltip">
                                                        <div class="credit-block">
                                                            <small class="recommended-font-size">{{ __('(Ex.') }}
                                                                <img src="{{ url('admin_theme/assets/images/ex.flag.jpg') }}" alt="flag"
                                                                    class="exmaple-img" alt={{('Ex.')}}>
                                                                {{ __(')') }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <span class="float-end"><i class="flaticon-info"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-9 col-md-9 col-8">
                                            <input class="form-control form-control-lg" type="file" name="image"
                                            id="images" accept="image/*" onchange="readURL(this);">
                                            <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-4">
                                            <div class="edit-img-show">
                                                <img src="{{ asset('/images/language/' . $language->image) }}" alt="img"
                                                class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="status" class="form-label">{{ __('Set Default') }}</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            name="status" value="1"
                                            {{ $language->status == 1 ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3"><i class="flaticon-upload-1"></i> {{ __('Submit') }}</button>
                    </div>
                </form>
                <!--form code end -->
            </div>
        </div>
    </div>
</div>
@endsection
