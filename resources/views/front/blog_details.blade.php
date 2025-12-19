@extends('front.layouts.master')
@section('title', 'Blog Details')
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
                    <h2 class="breadcrumb-title mb_30">{{__('Blog Details')}}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{$currentBlog->title}} </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--end Breadcrumb-->
<section id="blog-details" class="blog-details-main-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="input-group">
                    <input class="form-control front-search-bar mb_30" placeholder="Search" id="example-search-input">
                    <span class="input-group-append">
                        <button class="btn btn-search" type="button">
                            <i class="flaticon-search-interface-symbol"></i>
                        </button>
                    </span>
                </div>
                <div id="search-results" class="search-results"></div>
                <div class="blog-categories mb_30">
                    <h4 class="category-heading mb_30">{{__('Categories')}}</h4>
                    <ul class="categories-lst">
                        @foreach($category as $data)
                        <li>
                            <a href="" title="{{$data->categories}}">{{$data->categories}}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="blog-latest-post">
                    <div class="latest-post-lst">
                    <h4 class="latest-heading mb_30">{{__('Latest Blog')}}</h4>
                        @php $count = 1; @endphp
                        @foreach ($blogsExceptCurrent as $data)
                            <div class="latest-block mb_30">
                                <div class="latest-block-heading">
                                    <a href="{{ route('blog.details', $data->slug) }}" title="{{ $data->title }}"><h3 class="heading-number">{{ $count++ }}</h3></a>
                                </div>
                                <div class="latest-block-dtls">
                                    <a href="{{ route('blog.details', $data->slug) }}" title="{{ $data->title }}"><h5 class="latest-heading">{{ $data->title }}</h5></a>
                                        <h6 class="latest-sub-heading">{{$data->created_at->toDateString()}}</h6>
                                    <a href="{{ route('blog.details', $data->slug) }}" title="{{ $data->title }}"><p class="latest-txt">{{ strip_tags(Str::limit($data['desc'], 20, '...')) }}</p></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                @if($currentBlog['banner_img'] !== NULL && $currentBlog['banner_img'] !== '')
                <div class="blog-banner mb_20">
                    <img src="{{asset('images/blog/'.$currentBlog->banner_img)}}"  class="img-fluid" alt="{{$currentBlog->title}}">
                </div>
                @else
                <div class="blog-banner mb_20">
                    <a href="{{route('home.page')}}" title="{{ $currentBlog->title }}"><img src="Avatar::create($data->name)->toBase64()" class="img-fluid" alt="{{ $currentBlog->title }}"></a>
                </div>
                @endif
                <div class="blog-details-dtls mb_10">
                    <h3 class="blog-deatils-heading">{{$currentBlog->title}}</h3>
                </div>
                @php
                    $approvedComments = \App\Models\BlogComment::where('blog_id', $currentBlog->id)
                                                    ->where('approved', '1')
                                                    ->count();
                @endphp
                <ul class="blog-dtls-lst">
                    <li><i class="flaticon-calendar"></i>{{$currentBlog->created_at->toDateString()}}</li>
                    <li><i class="flaticon-chat"></i>{{__($approvedComments .' comments')}}</li>
                </ul>
                <div class="mb_30">
                    {!! $currentBlog->desc !!}
                </div>
                <div class="blog-comment">
                    <h4 class="blog-comment-title mb_20">{{__('Leave a comment')}}</h4>
                    <form class="mb_30" action="{{ route('blog.comment', $currentBlog->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="blog_id" value="{{ $currentBlog->id }}">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 mb_15">
                                <input type="text" class="form-control" id="name" placeholder="Name" name="name" required>
                            </div>
                            <div class="col-lg-6 col-md-6 mb_30">
                                <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
                            </div>
                            <div class="col-lg-12">
                                <textarea class="form-control mb_30" rows="4" placeholder="Comment" id="message" name="comment" required></textarea>
                                <button type="submit" class="btn post-comment-btn btn-primary">{{ __('Post Comment') }}</button>
                            </div>
                        </div>
                    </form>
                    <div class="show-comments">
                        @php
                            $approvedComments = $comment->filter(function($data) use ($currentBlog) {
                                return $data->blog_id == $currentBlog->id && $data->approved == 1;
                            })->take(3);
                        @endphp

                        @if ($approvedComments->isEmpty())
                        <h4 class="blog-comment-title mb_20">{{ __('No comment') }}</h4>
                        @else
                        <h4 class="blog-comment-title mb_20">{{ __('Top comments') }}</h4>
                            @foreach ($approvedComments as $data)
                                <div class="user-comment mb_30">
                                    <h4 class="comment-title">{{ $data->name }}</h4>
                                    <h6 class="comment-email">{{ $data->email }}</h6>
                                    <p class="comment-txt">{{ $data->comment }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
