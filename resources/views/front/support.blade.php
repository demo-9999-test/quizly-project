@extends('front.layouts.master')
@section('title','Quizly | Contact Us')
@section('content')

<!--Start Breadcrumb-->
<div id="breadcrumb" class="breadcrumb-main-block"
    @if(isset($setting->breadcrumb_img) && $setting->breadcrumb_img)
        style="background-image: url('{{ asset('images/breadcrumb/'.$setting->breadcrumb_img) }}')"
    @endif
>
    <div class="overlay-bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center ">
                <nav  style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <h2 class="breadcrumb-title mb_30">{{__('Help and Support')}}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Help and Support')}} </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--end Breadcrumb-->

<!-- Support Message start -->
<div id="support" class="support-main-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb_30">
                <h2 class="support-heading">{{__('How can we help you?')}}</h2>
                <p class="support-txt">{{__('Find answers to common questions or get in touch with our support team.')}}</p>
            </div>
        </div>
        <div class="support-form">
            <form action="{{ route('support.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Support Message end -->


                    <!-- Priority Dropdown -->
                    <div class="col-lg-4">
                        <label for="priority">{{__('Priority')}}</label>
                        <select class="form-select" aria-label="Select Priority" name="priority" required>
                            <option value="" selected disabled>{{ __('Select Priority') }}</option>
                            <option value="L">{{__('Low')}}</option>
                            <option value="M">{{__('Medium')}}</option>
                            <option value="H">{{__('High')}}</option>
                            <option value="C">{{__('Critical')}}</option>
                        </select>
                    </div>

                    <!-- Support Type Dropdown -->
                    <div class="col-lg-4">
                        <label for="support_id">{{__('Support Type')}}</label>
                        <select class="form-control" id="support_id" name="support_id" required>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label for="image">{{__('Upload Image (Optional)')}}</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                    <div class="col-lg-12">
                        <label for="message">{{__('Message')}}</label>
                        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Enter your message" required></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
