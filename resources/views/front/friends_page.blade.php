@extends('front.layouts.master')
@section('title', 'Quizly | Friend')
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
                    <h2 class="breadcrumb-title mb_30">{{ 'Profile: '. $user->name }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{ $user->name}} </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--end Breadcrumb-->
<!-- Friend start -->
<section id="friend" class="friend-main-block">
    <div class="container">
        <div class="friend-profile-header mb_30">
            <div class="row align-items-center">
                <div class="col-lg-2 col-md-3 col-6">
                    <div class="friend-profile-img">
                        <img src="{{asset('images/users/'.$user->image)}}" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-lg-7 col-md-5 col-6">
                    <h2 class="friend-profile-name mb_10">{{$user->name}}</h2>
                    <ul class="friend-profile-lst">
                        <li>{{ __('Score: '.$user->score)}}</li>
                        <li>{{ __('Rank: '.$user->rank )}}</li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 col-12 text-center">
                    @if(!$friendship)
                        <form action="{{ route('friend.request', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn friends-page-btn add-btn btn-primary">{{ __('Add Friend')}}</button>
                        </form>
                    @elseif($friendship->status === 'pending')
                        @if($friendship->user_id === Auth::id())
                            <form action="{{ route('friend.cancel', $friendship) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn friends-page-btn btn-warning">{{ __('Cancel Request')}}</button>
                            </form>
                        @else
                            <form action="{{ route('friend.accept', $friendship) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn mb_20 friends-page-btn btn-success">{{ __('Accept')}}</button>
                            </form>
                            <form action="{{ route('friend.reject', $friendship) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">{{ __('Reject')}}</button>
                            </form>
                        @endif
                    @elseif($friendship->status === 'accepted')
                        <h5 class="friend-status mb_10">{{ __('Friend')}}</h5>
                        <form action="{{ route('friend.remove', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn friends-page-btn add-btn btn-warning">{{ __('Remove Friend')}}</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <h3 class="friend-profile-sub-title mb_10">{{ __('More about user')}}</h3>
                <div class="friend-profile-about mb_30">
                    <p class="friend-profile-text mb_30">{!! $user->desc !!}</p>
                </div>
                <div class="friend-contact-block">
                    <div class="row mb_30">
                        @if($user->show_mobile == 1 )
                            @if($user->mobile)
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="contact-user-block">
                                        <div class="contact-icon">
                                            <i class="flaticon-telephone"></i>
                                        </div>
                                        <div class="contact-dtls">
                                            <h5 class="contact-heading">{{__('Phone Number')}}</h5>
                                            <a href="tel:" title="{{$user->name}}">{{$user->mobile}}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        @if($user->show_email == 1 )
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="contact-user-block mb_10">
                                    <div class="contact-icon">
                                        <i class="flaticon-mail"></i>
                                    </div>
                                    <div class="contact-dtls">
                                        <h5 class="contact-heading">{{__('Email')}}</h5>
                                        <a href="mailto:" title="{{$user->name}}">{{ $user->email }}</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if($socialMedia->isNotEmpty())
                        <div class="follow">
                            <h3 class="about-heading mb_10">{{__('Follow Me')}}</h3>
                            <div class="user-social">
                                <ul>
                                    @foreach($socialMedia as $social)
                                        @switch($social->type)
                                            @case('facebook')
                                                <li><a href="{{ $social->url }}" title="Facebook"><i class="flaticon-facebook"></i></a></li>
                                                @break
                                            @case('instagram')
                                                <li><a href="{{ $social->url }}" title="Instagram"><i class="flaticon-instagram"></i></a></li>
                                                @break
                                            @case('twitter')
                                                <li><a href="{{ $social->url }}" title="Twitter"><i class="flaticon-twitter"></i></a></li>
                                                @break
                                            @case('linkedIn')
                                                <li><a href="{{ $social->url }}" title="LinkedIn"><i class="flaticon-linkedin"></i></a></li>
                                                @break
                                        @endswitch
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="profile-user-info mb_20">
                    <h3 class="friend-profile-sub-title mb_10">{{ __('User Info')}}</h3>
                    <ul class="firend-info-lst">
                        <li>{{'Location: ' .$user->city. ', '.$user->state }}</li>
                        <li>{{'Age: '.$user->age}}</li>
                        <li>{{'Joined: '.$user->created_at->format('F d, Y') }}</li>
                    </ul>
                </div>
                <div class="profile-user-info">
                    <h3 class="friend-profile-sub-title mb_20">{{ __('User Badges')}}</h3>
                    <div class="row">
                        @if(isset($badges) && $badges->isNotEmpty())
                            @foreach($badges->take(3) as $data)
                                <div class="col-lg-4 col-2 text-center">
                                    <div class="badge-block">
                                        <div class="badge-img">
                                            <img src="{{asset('images/badge/'.$data->image)}}" class="img-fluid" alt="{{$data->name}}">
                                        </div>
                                        <h5 class="badge-name">{{$data->name}}</h5>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center">
                                <p>{{ __('Player have no badges yet.') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Friend end-->
@endsection
