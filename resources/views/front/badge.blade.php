@extends('front.layouts.master')
@section('title', 'Quizzly | Badge')
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
                    <h2 class="breadcrumb-title mb_30">{{__('Badges')}}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Badges')}} </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--end Breadcrumb-->
<!-- Badges Start -->
<section id="badges" class="badges-main-block">
    <div class="container">
        @if(!$badges->isEmpty() && isset($badges))
        <div class="row">
            @foreach($badges as $data)
            <div class="col-lg-3 text-center">
                <div class="badge-block {{ $user->badges->contains($data->id) ? 'owned' : '' }}">
                    @if($data['image'] !== NULL && $data['image'] !== '')
                    <div class="badge-img mb_10">
                       <img src="{{ asset('images/badge/' . $data->image) }}" class="img-fluid" alt="{{$data->name}}">
                    </div>
                    @else
                    <div class="badge-img mb_10">
                        <img src="Avatar::create($data->name)->toBase64()" class="img-fluid" alt="{{$data->name}}">
                    </div>
                    @endif
                    <div class="badge-title">
                        <h6 class="badge-title">{{$data->name}}</h6>
                        <p class="badge-txt">{{ strip_tags(Str::limit($data['description'], 70, '...')) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="nothing-here-block">
            <div class="row">
                <div class="col-md-12 text-center">
                    <img src="{{asset('images/nothing-here/nothing-01.jpg')}}" class="img-fluid mb_30" alt="{{__('Nothing here')}}">
                    <h2>{{__('Seems like no badges here yet')}}</h2>
                    <p>{{__('Check back soon as badge will upload!')}}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
<!-- Badges End -->
@endsection
