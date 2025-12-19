@extends('front.layouts.master')
@section('title', 'Quizzly | Find Friends')
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
                    <h2 class="breadcrumb-title mb_30">{{__('Find Friends')}}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Find Friends')}} </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--end Breadcrumb-->
<!-- Start find friends -->
<section id="friends-page" class="friends-page-main-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-6">
                <div class="search-container">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="search-input" placeholder="Search users" aria-label="Search" aria-describedby="search-addon">
                        <span class="input-group-text" id="search-addon">
                            <i class="flaticon-search-interface-symbol"></i>
                        </span>
                    </div>
                    <div id="search-suggestions" class="suggestion-lst"></div>
                </div>
            </div>
            <div class="col-lg-6 col-6 text-end">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        {{__('Sort By')}}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="{{ route('find.friends', ['sort' => 'name_asc']) }}">{{__('Name (A-Z)')}}</a></li>
                        <li><a class="dropdown-item" href="{{ route('find.friends', ['sort' => 'name_desc']) }}">{{__('Name (Z-A)')}}</a></li>
                        <li><a class="dropdown-item" href="{{ route('find.friends', ['sort' => 'date_newest']) }}">{{__('Date Added (Newest)')}}</a></li>
                        <li><a class="dropdown-item" href="{{ route('find.friends', ['sort' => 'date_oldest']) }}">{{__('Date Added (Oldest)')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="user-container">
            <div class="row">
                @foreach ($usersWithColors  as $data )
                    @if($data->role != 'A' && Auth::id() != $data->id)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="find-friends-block">
                                @if($data->image !== NULL && $data->image !== '')
                                <div class="find-friend-banner" style="background-color: {{ $data->bannerColor }}">
                                    <a href="{{route('friend.page',['slug'=>$data->slug])}}" title="{{$data->name}}"><img src="{{asset('images/users/'.$data->image)}}" class="img-fluid" alt="{{$data->name}}"></a>
                                </div>
                                @else
                                <div class="find-friend-banner" style="background-color: {{ $data->bannerColor }}">
                                    <a href="{{route('friend.page',['slug'=>$data->slug])}}" title="{{$data->name}}"><img src="{{Avatar::create($data->name)->toBase64()}}" class="img-fluid" alt="{{$data->name}}"></a>
                                </div>
                                @endif
                                <div class="find-friends-details">
                                    <a href="{{route('friend.page',['slug'=>$data->slug])}}" title="{{$data->name}}"><h3 class="find-friends-name">{{$data->name}}</h3></a>
                                    <a href="{{route('friend.page',['slug'=>$data->slug])}}" title="{{$data->name}}"><h5 class="find-friends-username mb_30">{{ '@' .$data->slug}}</h5></a>
                                    <div class="find-friends-lst mb_30">
                                        <div class="find-friend-info text-center">
                                            <h4 class="find-friend-info-title">{{__('Score')}}</h4>
                                            <h5 class="find-friend-info-txt">{{$data->score}}</h5>
                                        </div>
                                        <div class="line"></div>
                                        <div class="find-friend-info text-center">
                                            <h4 class="find-friend-info-title">{{__('Rank')}}</h4>
                                            <h5 class="find-friend-info-txt">{{$data->rank}}</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="offset-lg-4 col-lg-6">
                                            <a href="{{route('friend.page',['slug'=>$data->slug])}}" class="btn btn-primary">{{__('View Profile')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                <div class="pagination">
                {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
