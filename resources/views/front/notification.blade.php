@extends('front.layouts.master')
@section('title', 'Quizly | Notification')
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
                    <h2 class="breadcrumb-title mb_30">{{__('Notifications')}}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Notifications')}} </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--end Breadcrumb-->


<!-- Friend Request Notification -->
<!-- Notification Block start -->
<section id="notification" class="notification-main-block">
    <div class="container">
        <h2 class="notification_title mb_30">{{ __('Notifications')}}</h2>
        <div class="notification-box">
            <div class="row">
                <div class="col-lg-12">
                    @forelse (auth()->user()->notifications as $notification)
                        @if ($notification->type === 'App\Notifications\FriendRequestNotification')
                            @php
                                $friendship = App\Models\Friendship::find($notification->data['friendship_id']);
                                $sender = $friendship ? $friendship->user : null;
                            @endphp
                            <div class="notification-block mb_10">
                                <div class="row align-items-center">
                                    <div class="col-lg-2 text-center">
                                        <div class="notification-img">
                                            <a href="{{route('friend.page',['slug'=>$sender->slug])}}" title="{{$sender->name}}"><img src="{{asset('images/users/'.$sender->image)}}" class="img-fluid" alt="{{$sender->name}}"></a>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <a href="{{route('friend.page',['slug'=>$sender->slug])}}" title="{{$sender->name}}"><h4 class="notification-heading mb_10">{{$notification->data['message']}}</h4></a>
                                        <a href="{{route('friend.page',['slug'=>$sender->slug])}}" title="{{$sender->name}}"><p class="notification-txt">{{ strip_tags(Str::limit($sender['desc'], 250, '...')) }}</p></a>
                                    </div>
                                    <div class="col-lg-2">
                                        @if (!isset($notification->data['status']) || $notification->data['status'] === 'pending')
                                            <form action="{{ route('friend.accept', $notification->data['friendship_id']) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary notification-btn">{{__('Accept')}}</button>
                                            </form>
                                            <form action="{{ route('friend.reject', $notification->data['friendship_id']) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary notification-btn">{{ __('Reject')}}</button>
                                            </form>
                                        @else
                                            <form action="{{ route('notifications.delete', $notification->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger notification-btn">{{ __('Delete')}}</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @elseif ($notification->type === 'App\Notifications\BadgeEarned')
                            <div class="notification-block mb_10">
                                <div class="row align-items-center">
                                    <div class="col-lg-2 text-center">
                                        <div class="notification-img">
                                            <img src="{{ asset('images/badge/'.$notification->data['badge_image']) }}" class="img-fluid" alt="{{ $notification->data['badge_name'] }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <h4 class="notification-heading mb_10">{{ $notification->data['message'] }}</h4>
                                        <p class="notification-txt">{{('You earned the')}} {{ $notification->data['badge_name'] }}{{__('By completing task: ')}}{{ $notification->data['badge_description'] }}</p>
                                    </div>
                                    <div class="col-lg-2">
                                        <form action="{{ route('notifications.delete', $notification->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger notification-btn">{{ __('Delete') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @elseif ($notification->type === 'App\Notifications\QuizResultApproved')
                            <div class="notification-block mb_10">
                                <div class="row align-items-center">
                                    <div class="col-lg-2 text-center">
                                        <div class="notification-img">
                                            <img src="{{ asset('images/quiz/'.$notification->data['quiz_image']) }}" class="img-fluid" alt="{{ $notification->data['quiz_name'] }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <h4 class="notification-heading mb_10">{{ $notification->data['message'] }}</h4>
                                        <p class="notification-txt">{{ __('Quiz Name: ') }}{{ $notification->data['quiz_name'] }}</p>
                                        <p class="notification-txt">{{ __('Description: ') }}{{ $notification->data['quiz_description'] }}</p>
                                        <p class="notification-txt">{{ __('Approved at: ') }}{{ $notification->data['approved_at'] }}</p>
                                    </div>
                                    <div class="col-lg-2">
                                        <a href="{{ route('report.quiz', ['quiz_slug' => $notification->data['quiz_slug'], 'user_slug' => auth()->user()->slug]) }}" class="btn btn-primary notification-btn">{{ __('View Result') }}</a>
                                        <form action="{{ route('notifications.delete', $notification->id) }}" method="POST" class="mt-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger notification-btn">{{ __('Delete') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <p>{{ __('No notifications') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Notification Block end -->

@endsection
