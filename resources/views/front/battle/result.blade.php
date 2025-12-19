@extends('front.layouts.master')
@section('title', 'Play Quiz')
@section('content')
<!--Start Breadcrumb-->
<div id="breadcrumb" class="breadcrumb-main-block" style="background-image: url('{{ asset('images/breadcrumb/'.$setting->breadcrumb_img) }}')">
    <div class="overlay-bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <h2 class="breadcrumb-title mb_30">{{__('Battle result')}}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Result')}}</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--end Breadcrumb-->
<section id="battle-result" class="battle-result-main-block">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="battle-result-heading text-center mb_30">{{__('Battle Results')}}</h2>
                @if(auth()->user()->id == $winner->id)
                    <div class="row mb_30">
                        <div class="col-lg-8">
                            <div class="battle-result-status">
                                <h3 class="battle-resul-staus-heading">{{__('Congratulation you won the battle')}}</h3>
                                <h6 class="battle-result-staus-txt">{{__('You have been awarded: ')}}{{$battle->bid_amount*2}}{{' Coins'}}</h6>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row mb_30">
                        <div class="col-lg-8">
                            <div class="battle-result-status">
                                <h3 class="battle-resul-staus-heading">{{__('Unfotunatly you lost battle')}}</h3>
                                <h6 class="battle-result-staus-txt">{{__('Better luck next time')}}</h6>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row justify-content-center">
                    <!-- Authenticated User Card -->
                    <div class="col-lg-3 col-md-5 col-12 text-center">
                        <div class="play-card-block {{ auth()->user()->id == $winner->id ? 'winner' : '' }}">
                            @if(auth()->user()->id == $winner->id)
                            <span class="badge winner-badge text-bg-success">{{__('Winner')}}</span>
                            @endif
                            <div class="player-card-image">
                                <img src="{{ asset('/images/users/' . auth()->user()->image) }}" class="card-img-top img-fluid user-image" alt="{{ auth()->user()->name }}">
                            </div>
                            <div class="player-card-details">
                                <h4 class="player-card-name">{{ auth()->user()->name }}</h4>
                                <p class="card-text">{{__('Score: ')}} {{ $scores[auth()->user()->id] }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- VS Divider -->
                    <div class="offset-lg-2 col-lg-2 col-md-2  col-12 d-flex justify-content-center align-items-center">
                        <h2 class="vs-text">{{__('VS')}}</h2>
                    </div>

                    <!-- Opponent Card -->
                    <div class="offset-lg-2 col-lg-3 col-md-5 col-12 text-center">
                        <div class="play-card-block {{ $opponent->id == $winner->id ? 'winner' : '' }}">
                            @if($opponent->id == $winner->id)
                            <span class="badge winner-badge text-bg-success">{{__('Winner')}}</span>
                            @endif
                            <div class="player-card-image">
                                <img src="{{ asset('/images/users/' . $opponent->image) }}" class="card-img-top img-fluid" alt="{{ $opponent->name }}">
                            </div>
                            <div class="player-card-details">
                                <h4 class="player-card-name">{{ $opponent->name }}</h4>
                                <p class="card-text">{{__('Score: ')}} {{ $scores[$opponent->id] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class=" offset-lg-6 offset-md-5 mt-4 col-lg-3 col-md-4">
                            <a href="{{route('home.page')}}" class="btn-primary btn" title="{{__('Home')}}">{{__('Home')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
