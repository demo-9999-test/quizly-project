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
                    <h2 class="breadcrumb-title mb_30">{{__('Contact Us')}}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Contact Us')}} </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--end Breadcrumb-->
<div id="contact-us" class="contact-us-main-block">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="contact-heading">{{__('Get in Touch')}}</h2>
            <p class="contact-txt mb_30">{{__('We are here to help and answer any questions you might have. We look forward to hearing from you.')}}</p>
        </div>
        <div class="contact-us-form">
            <form action="{{route('send.message')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="name">{{__('Your Name')}}</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Your Name" required>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="subject">{{__('Subject')}}</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Subject" required>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="email">{{__('Your Email Address')}}</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Your Email Address" required>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="number">{{__('Mobile Number')}}</label>
                            <input type="number" name="number" id="number" class="form-control" placeholder="Enter your phone number" required>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label for="message">{{__('Your Message')}}</label>
                            <textarea name="message" id="message" class="form-control" rows="6" placeholder="Your Message" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">{{__('Send Message')}}</button>
                </div>
            </form>
        </div>

        <!-- Direct Contact Information -->
        <div class="contact-information">
            <div class="row">
                <div class="col-lg-12 mb_30 text-center"><h3 class="contact-info-heading">{{__('Contact Information')}}</h3></div>
                <div class="col-lg-4 col-md-4">
                    <div class="contact-block">
                        <div class="contact-block-icon">
                        <i class="flaticon-mail"></i>
                        </div>
                        <h4 class="contact-block-heading">{{__('Email')}}</h4>
                        <a href="mailto:{{ $setting->email }}" title="{{ $setting->email }}">{{$setting->email}}</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="contact-block">
                        <div class="contact-block-icon">
                        <i class="flaticon-telephone"></i>
                        </div>
                        <h4 class="contact-block-heading">{{__('Mobile')}}</h4>
                        <a href="tel:{{ $setting->contact }}" title="{{ $setting->contact }}">{{'Office: '.$setting->contact}}</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="contact-block">
                        <div class="contact-block-icon">
                        <i class="flaticon-location"></i>
                        </div>
                        <h4 class="contact-block-heading">{{__('Address')}}</h4>
                        {!!$setting->address!!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="map-container">
                    <iframe src="{{ $setting->iframe_url }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
