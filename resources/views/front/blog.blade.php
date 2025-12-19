@extends('front.layouts.master')
@section('title', 'Quizly | Blogs')
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
                    <h2 class="breadcrumb-title mb_30">{{__('Blogs')}}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Blogs')}} </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--end Breadcrumb-->
<!-- Start Blog Page -->
<section id="blog-page" class="blog-page-main-block">
    <div class="container">
        <div class="row">
            @if($blogs->isEmpty())
            <div class="nothing-here-block">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <img src="{{asset('images/nothing-here/nothing-01.jpg')}}" class="img-fluid mb_30" alt="{{__('Nothing here')}}">
                        <h2>{{__('Seems like no blog has been uploaded yet')}}</h2>
                        <p>{{__('Check back soon for our first blog post!')}}</p>
                    </div>
                </div>
            </div>
            @else
            @foreach ($blogs as $data)
            @php
                $approvedCommentsCount = \App\Models\BlogComment::where('blog_id', $data->id)
                                                    ->where('approved', '1')
                                                    ->count();
            @endphp
                <div class="col-lg-4">
                    <div class="blog-block mb_30">
                        @if($data['thumbnail_img'] !== NULL && $data['thumbnail_img'] !== '')
                        <div class="blog-img mb_20">
                            <a href="{{ route('blog.details', $data->slug) }}" title="{{ $data->title }}">
                                <img src="{{ asset('images/blog/' . $data->banner_img) }}" alt="{{ $data->title }}" class="img-fluid">
                            </a>
                        </div>
                        @else
                        <div class="blog-img mb_20">
                            <a href="{{ route('blog.details', $data->slug) }}" title="{{ $data->title }}"><img src="Avatar::create($data->name)->toBase64()" class="img-fluid" alt="{{ $data->title }}"></a>
                        </div>
                        @endif
                        <div class="blog-dtls">
                            <ul class="blog-lst">
                                <li><i class="flaticon-calendar"></i>{{ $data->created_at->format('M d, Y') }}</li>
                                <li><i class="flaticon-chat"></i>{{ __( $approvedCommentsCount .' comments') }}</li>
                            </ul>
                            <hr>
                            <div class="truncated-content">
                                <a href="{{ route('blog.details', $data->slug) }}" title="{{ $data->title }}">
                                    <h4 class="blog-heading mb_20">{{ $data->title }}</h4>
                                </a>
                            </div>
                            <a href="{{ route('blog.details', $data->slug) }}" title="{{ $data->title }}">
                                <p class="blog-txt mb_20">{{ strip_tags(Str::limit($data->desc, 200, '... Read More')) }}</p>
                            </a>
                            <a href="{{ route('blog.details', $data->slug) }}" class="btn btn-primary blog-btn" title="{{ $data->title }}">{{ __('Read More') }}<i class="flaticon-right-arrow"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
            @endif
        </div>
        <!-- Pagination Links -->
        <div class="pagination">
            {{ $blogs->links() }}
        </div>
    </div>
</section>
<!-- End Blog Page -->
@endsection
