@extends('admin.layouts.master')
@section('title', 'Pacakage Features Edit')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['fourthactive' => 'active'])
    @slot('heading')
    {{ __('Packages Features') }}
    @endslot
    @slot('menu1')
    {{ __('Packages Features') }}
    @endslot
    @slot('menu2')
    {{ __('Packages Features') }}
    @endslot
    @slot('menu3')
    {{ __('Edit') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('packages_features.show') }}" title="{{ __('Back') }}" class="btn btn-primary"><i
                class="flaticon-back"></i>{{ __('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent
    <div class="contentbar  ">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
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
                @if (session('success'))
                <h6 class="alert alert-success">{{ session('success') }}</h6>
                @elseif (session('warning'))
                <h6 class="alert alert-warning">{{ session('warning') }}</h6>
                @endif
                <!-- Massage Print Code end  -->
                <form action="{{ url('admin/packages-features/' . $pfeatures->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="client-detail-block">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="Title" class="form-label">{{ __('Package Feature') }}<span
                                            class="required">*</span></label>
                                    <input class="form-control" type="text" name="title" id="title"
                                        placeholder="{{ __('Please Enter Your Package Feature') }}" aria-label="title"
                                        required value="{{ $pfeatures->title }}">
                                    <div class="form-control-icon"><i class="flaticon-task"></i></div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" title="{{ __('Update') }}" class="btn btn-primary mt-3"><i
                                class="flaticon-refresh"></i> {{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
