@extends('front.layouts.master')
@section('title', 'Quizzly | My Friends ')
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
                    <h2 class="breadcrumb-title mb_30">{{__('My friends')}}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('My friends')}} </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--end Breadcrumb-->

<!-- Friend Request inbox start -->
<section class="my-friends-main-block">
    <div class="container">
        <div class="row mb_30">
            <div class="col-lg-2 col-6">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pendingRequestsModal">
                    {{__('Pending Requests')}}
                </button>
            </div>
            <div class="col-lg-2 col-6">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#friendRequestsModal">
                    {{__('Friend Requests')}}
                </button>
            </div>
        </div>
        <div class="row">
            @forelse($friendsWithColors as $data)
            <div class="col-lg-4 col-md-6">
                <div class="find-friends-block">
                    @if($data['image'] !== NULL && $data['image'] !== '')
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
            @empty
            <div class="nothing-here-block">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <img src="{{asset('images/nothing-here/nothing-01.jpg')}}" class="img-fluid mb_30" alt="{{__('Nothing here')}}">
                        <h2>{{__('Seems like you dont have friends')}}</h2>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>
<!-- Friend Request inbox end -->

<!-- Pending Requests Modal -->
<div class="modal request-model fade" id="pendingRequestsModal" tabindex="-1" aria-labelledby="pendingRequestsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pendingRequestsModalLabel">{{__('Pending Requests')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @forelse($pendingSentRequests as $request)
                <div class="request-item">
                    <div class="row align-items-center">
                        <div class="col-lg-2 col-md-2 col-4">
                            <div class="request-friend-image">
                                @if($request->friend['image'] !== NULL && $request->friend['image'] !== '')
                                <img src="{{asset('images/users/'.$request->friend->image)}}" class="pending-friend-avatar" alt="{{$request->friend->name}}">
                                @else
                                <img src="{{Avatar::create($request->friend->name)->toBase64()}}" class="pending-friend-avatar" alt="{{$request->friend->name}}">
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-8">
                            <div class="request-friends-dtls">
                                <h4 class="request-friend-name">{{$request->friend->name}}</h4>
                                <h5 class="request-friend-username">{{'@'.$request->friend->slug}}</h5>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-12">
                            <form action="{{ route('friend.cancel', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn request-btn btn-warning">{{ __('Cancel Request')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <p class="no-request-txt">{{__('No pending request')}}</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Friend Requests Modal -->
<div class="modal request-model fade" id="friendRequestsModal" tabindex="-1" aria-labelledby="friendRequestsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="friendRequestsModalLabel">Friend Requests</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @forelse($receivedRequests as $request)
                <div class="row align-items-center">
                    <div class="col-lg-2 col-md-2 col-4">
                        <div class="request-friend-image">
                        @if($request->user['image'] !== NULL && $request->user['image'] !== '')
                        <img src="{{asset('images/users/'.$request->user->image)}}" class="friend-avatar" alt="{{$request->user->name}}">
                        @else
                        <img src="{{Avatar::create($request->user->name)->toBase64()}}" class="friend-avatar" alt="{{$request->user->name}}">
                        @endif
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-8">
                        <div class="request-friends-dtls">
                            <h4 class="request-friend-name">{{$request->user->name}}</h4>
                            <h5 class="request-friend-username">{{'@'.$request->user->slug}}</h5>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-12">
                        <div class="row align-items-center">
                            <div class="col-lg-12 col-md-12 col-6">
                                <form action="{{ route('friend.accept', $request->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn mb_20 friends-page-btn btn-success">{{ __('Accept')}}</button>
                                </form>
                            </div>
                            <div class="col-lg-12 col-md-12 col-6">
                                <form action="{{ route('friend.reject',$request->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">{{ __('Reject')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <p class="no-request-txt">{{__('No request')}}</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
