@extends('front.layouts.master')
@section('title','Quizly – Laravel Online Quiz and Exam System')
@section('content')

    <!-- Slider Start -->
    @if(!$slider->isEmpty() && isset($slider))
        @if($hsetting->slider == 1)
            <section id="slider" class="slider-main-block">
                <div class="shape rect-1"></div>
                <div class="shape rect-2"></div>
                <div class="shape tri-1"></div>
                <div class="shape tri-2"></div>
                <div class="shape tri-3"></div>
                <div class="shape star-1"></div>
                <div class="shape star-2"></div>
                <div class="shape circle-1"></div>
                <div class="container">
                @foreach($slider as $data)
                <div class="row">
                    <div class="col-lg-8 col-md-8">
                        @php
                        $words = explode(' ', $data->heading);
                        $lastTwoWords = array_slice($words, -2);
                        $firstPart = implode(' ', array_slice($words, 0, -2));
                        @endphp
                        <h1 class="slider-heading">{{$firstPart}} <span class="blue-text">{{implode(' ', $lastTwoWords)}}</span></h1>
                        <h4 class="slider-sub-heading mb_20"></h4>
                        <p class="intro-text mb_30">{{$data->details}}</p>
                        @if($data->btn_status == 1)
                        <a href="{{route('home.page')}}" class="btn btn-primary slider-btn" title="{{$data->heading}}"><span>{{$data->buttontext}}</span></a>
                        @endif
                    </div>
                    <div class="col-lg-4 col-md-4">
                        @if($data['images'] !== NULL && $data['images'] !== '')
                        <img src="{{asset('images/slider/'.$data->images)}}" class="img-fluid" alt="{{$data->heading}}">
                        @else
                        <img src="{{asset('images/slider/slider-01.png')}}" class="img-fluid" alt="{{$data->heading}}">
                        @endif
                    </div>
                </div>
                @endforeach
                </div>
            </section>
        @endif
    @endif
    <!-- Slider end -->

    <!-- advertisement start -->
    @isset($advertisement)
    <div class="advertisement-main-block">
        <div class="container">
            <div class="row">
                @foreach($advertisement as $adver)
                    @if ($adver->page_type == "hp" && $adver->position == "bs")
                        <div class="col-md-8 offset-md-2">
                            <div class="video-section">
                                <img src="{{ asset('images/advertisement/'.$adver->image) }}" class="img-fluid adv-img" alt="{{ __('Advertisement image') }}">
                                <div class="play-icon" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="flaticon-play-button"></i>
                                </div>
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <iframe src="{{ $adver->url }}" id="videoFrame" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($adver->page_type == "hp" && $adver->position == "bs")
                        <div class="col-md-8 offset-md-2">
                            <div class="video-section">
                                <img src="{{ asset('images/advertisement/' . $adver->image) }}" class="img-fluid adv-img" alt="{{ __('Advertisement image') }}" onclick="showVideoPopup('{{ $adver->url }}')">
                                <div class="play-icon" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="flaticon-play-button"></i>
                                </div>
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <iframe src="{{ $adver->url }}" id="videoFrame" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @endisset
    <!-- advertisement end -->

    <!-- Counter Start -->
    @if(auth()->check() )
        @if($hsetting->counter == 1)
            <section id="counter" class="counter-main-block">
                <div class="shape star-2"></div>
                <div class="shape circle-1"></div>
                <div class="shape rect-1"></div>
                <div class="container">
                    <div class="counter-box wow bounceInDown" data-wow-duration = "1s" data-wow-delay="0.3s">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-4 text-center divide-right">
                                <div class="counter-block">
                                    <div class="counter-icon mb_15"><i class="flaticon-medal-ribbon"></i></div>
                                    <h2 class="coutner-heading mb_15">{{__('Rank')}}</h2>
                                    @if(auth()->user()->role == 'U')
                                        <h3 class="number">{{auth()->user()->rank}}</h3>
                                    @else
                                        <h3 class="number">{{__('99999')}}</h3>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4 text-center divider">
                                <div class="counter-block">
                                    <div class="counter-icon mb_15"><i class="flaticon-coin"></i></div>
                                    <h2 class="coutner-heading mb_15">{{__('Coins')}}</h2>
                                    @if(auth()->user()->role == 'U')
                                        <h3 class="number">{{auth()->user()->coins}}</h3>
                                    @else
                                        <h3 class="number">{{__('99999')}}</h3>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4 text-center divide-left">
                                <div class="counter-block">
                                    <div class="counter-icon mb_15"><i class="flaticon-scoreboard"></i></div>
                                    <h2 class="coutner-heading mb_15">{{__('Score')}}</h2>
                                    @if(auth()->user()->role == 'U')
                                        <h3 class="number">{{auth()->user()->score}}</h3>
                                    @else
                                        <h3 class="number">{{__('99999')}}</h3>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif
    <!-- Counter End -->

    <!-- Categories Start -->
    @if(!$categories->isEmpty() && isset($categories))
        @if($hsetting->categories == 1)
            <section id="categories" class="categories-main-block">
                <div class="shape tri-3"></div>
                <div class="shape rect-2"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 col-9">
                            <div class="section wow bounceInLeft" data-wow-duration="3s" data-wow-delay="0.5s">
                                <h3 class="section-title">{{__('Categories')}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="category-slider wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.8s">
                        @foreach ($categories as $data)
                            @php
                                $quizzesInCategory = $quiz->where('category_id', $data->id);
                            @endphp
                            @if ($quizzesInCategory->isNotEmpty())
                                <div class="categories-block wow fadeIn" data-wow-duration="2.5s" data-wow-delay="0.2s">
                                    @if ($data->image !== NULL && $data->image !== '')
                                        <div class="categories-img">
                                            <a href="{{ route('category.single', $data->slug) }}" title="{{ $data->name }}"><img src="{{ $data->image }}" class="img-fluid" alt="{{ $data->name }}"></a>
                                        </div>
                                    @else
                                        <div class="categories-img">
                                            <a href="{{ route('category.single',$data->slug) }}" title="{{ $data->name }}"><img src="{{ Avatar::create($data->name)->toBase64() }}" class="img-fluid" alt="{{ $data->name }}"></a>
                                        </div>
                                    @endif
                                    <div class="categories-dtls">
                                        <a href="{{ route('category.single', $data->slug) }}" title="{{ $data->name }}"><h4 class="categories-title">{{ $data->name }}</h4></a>
                                    </div>
                                    <div class="door left-door"></div>
                                    <div class="door right-door"></div>
                                </div>
                            @endif
                        @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif
    <!-- Categories End -->

    <!-- Find-Friends Start -->
    @if(auth()->check())
        @if($hsetting->friends == 1)
            <section id="find-friend" class="find-friend-main-block">
                <div class="shape circle-1"></div>
                <div class="shape tri-1"></div>
                <div class="container">
                    <div class="find-friend-block wow bounceInDown" data-wow-duration="2s" data-wow-delay="0.2s">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-7">
                                <h2 class="find-friend-heading mb_20 wow bounce" data-wow-duration="3s" data-wow-delay="0.3s">
                                    {{__('Play this quiz with your friends right now!')}}
                                </h2>
                                <a href="{{route('find.friends')}}" title="{{route('find.friends')}}" class="btn btn-primary find-friend-btn wow tada" data-wow-duration="3s" data-wow-delay="0.2s">{{__('Find Friends')}}<i class="flaticon-search-interface-symbol"></i></a>
                            </div>
                            <div class="col-lg-6 col-5">
                                <div class="find-friend-img-block">
                                    <div class="row text-center">
                                        @foreach ($users->take(6) as $data )
                                            @if($data->role != 'A' && Auth::id() != $data->id)
                                                <div class="col-lg-4 col-md-4 col-6">
                                                    @if ($data->image !== NULL && $data->image !== '')
                                                    <a href="{{route('friend.page',['slug'=>$data->slug])}}" title="{{ $data->name }}"><img src="{{asset('images/users/'.$data->image)}}" class="img-fluid friend-img mb_20 wow fadeInLeft" data-wow-duration="3s" data-wow-delay="0.3s" alt="{{ $data->name }}"></a>
                                                    @else
                                                    <a href="{{route('friend.page',['slug'=>$data->slug])}}" title="{{ $data->name }}"><img src="{{ Avatar::create($data->name)->toBase64() }}" class="img-fluid friend-img " alt="{{ $data->name }}"></a>
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif
    <!-- Find-Friends End -->

    <!-- Discover Start -->
    @if(!$quiz->isEmpty() && isset($quiz))
        @if($hsetting->discover_quiz == 1)
            <section id="discover" class="discover-main-block">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 col-6">
                            <div class="section wow bounceInLeft"  data-wow-duration="2s" data-wow-delay="0.2s">
                                <h3 class="section-title">{{__('Discover Quizzes')}}</h3>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6 text-end">
                            <a href="{{route('discover.page')}}" title="{{__('See all')}}" class="btn btn-primary see-all-btn wow bounceInRight"  data-wow-duration="2s" data-wow-delay="0.2s">{{__('See all')}}</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="discover-slider wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.8s">
                            @if(auth()->check())
                            @php
                                $user_id = auth()->user()->id;
                            @endphp
                            @endif
                            @foreach ($quiz->take(5) as $data )
                                @if($data->status == "1")
                                    @if(auth()->check())
                                    @php
                                        $user = auth()->user();
                                        $hasAttemptedObj = \App\Models\ObjectiveAnswer::where('quiz_id', $data->id)
                                            ->where('user_id', $user->id)
                                            ->exists();
                                        $hasAttemptedSub = \App\Models\SubjectiveAnswer::where('quiz_id', $data->id)
                                            ->where('user_id', $user->id)
                                            ->exists();
                                    @endphp
                                    <div class="discover-block">
                                        @if($data['image'] !== NULL && $data['image'] !== '')
                                            <div class="discover-image mb_10">
                                                <button id="bookmark-btn-{{ $data->id }}" class="bookmark-btn {{ in_array($data->id, $bookmarkedQuizIds) ? 'active' : '' }}" data-quiz-id="{{ $data->id }}" data-quiz-id="{{ $data->id }}">
                                                    <i class="flaticon-bookmark"></i>
                                                </button>
                                                @if(($data->type == 1 && !$hasAttemptedObj) || ($data->type != 1 && !$hasAttemptedSub))
                                                    @if($data->type==1)
                                                        <a href="{{route('play.objective', $data->slug)}}" title="{{$data->name}}"> <img src="{{asset('images/quiz/'.$data->image)}}" class="img-fluid" alt="{{$data->name}}"></a>
                                                    @else
                                                        <a href="{{route('play.quiz', $data->slug)}}" title="{{$data->name}}"> <img src="{{asset('images/quiz/'.$data->image)}}" class="img-fluid" alt="{{$data->name}}"></a>
                                                    @endif
                                                @else
                                                    @if($hasAttemptedObj || $hasAttemptedSub )
                                                        @if($data->reattempt == 1)
                                                            @if($data->type == 1)
                                                                <a href="{{route('play.objective', $data->slug)}}" title="{{$data->name}}"> <img src="{{asset('images/quiz/'.$data->image)}}" class="img-fluid" alt="{{$data->name}}"></a>
                                                            @else
                                                                <a href="{{route('play.quiz', $data->slug)}}" title="{{$data->name}}"> <img src="{{asset('images/quiz/'.$data->image)}}" class="img-fluid" alt="{{$data->name}}"></a>
                                                            @endif
                                                        @else
                                                            <a href="{{ route('report.quiz', ['quiz_slug' => $data->slug, 'user_slug' => $user->slug]) }}" title="{{$data->name}}"><img src="{{asset('images/quiz/'.$data->image)}}" class="img-fluid" alt="{{$data->name}}"></a>
                                                        @endif
                                                    @endif
                                                @endif
                                            </div>
                                        @else
                                            <div class="discover-image mb_10">
                                                <button id="bookmark-btn-{{ $data->id }}" class="bookmark-btn btn btn-primary" data-quiz-id="{{ $data->id }}">
                                                    <i class="flaticon-bookmark"></i>
                                                </button>
                                                @if(($data->type == 1 && !$hasAttemptedObj) || ($data->type != 1 && !$hasAttemptedSub))
                                                    @if($data->type==1)
                                                        <a href="{{route('play.objective', $data->slug)}}" title="{{$data->name}}"> <img src="{{Avatar::create($data->name)->toBase64()}}" class="img-fluid" alt="{{$data->name}}"></a>
                                                    @else
                                                        <a href="{{route('play.quiz', $data->slug)}}" title="{{$data->name}}"><img src="{{Avatar::create($data->name)->toBase64()}}" class="img-fluid" alt="{{$data->name}}"></a>
                                                    @endif
                                                @else
                                                @if($hasAttemptedObj || $hasAttemptedSub )
                                                    @if($data->reattempt == 1)
                                                        @if($data->type == 1)
                                                            <a href="{{route('play.objective', $data->slug)}}" title="{{$data->name}}"><img src="{{Avatar::create($data->name)->toBase64()}}" class="img-fluid" alt="{{$data->name}}"></a>
                                                        @else
                                                            <a href="{{route('play.quiz', $data->slug)}}" title="{{$data->name}}"><img src="{{Avatar::create($data->name)->toBase64()}}" class="img-fluid" alt="{{$data->name}}"></a>
                                                        @endif
                                                        @else
                                                            <a href="{{ route('report.quiz', ['quiz_slug' => $data->slug, 'user_slug' => $user->slug]) }}" title="{{$data->name}}"><img src="{{Avatar::create($data->name)->toBase64()}}" class="img-fluid" alt="{{$data->name}}"></a>
                                                        @endif
                                                    @endif
                                                @endif
                                            </div>
                                        @endif
                                        <div class="discover-dtls mt-3">
                                            <div class="truncated-content">
                                            @if(($data->type == 1 && !$hasAttemptedObj) || ($data->type != 1 && !$hasAttemptedSub))
                                                @if($data->type == 1)
                                                    <a href="{{route('play.objective', $data->slug)}}" title="{{$data->name}}"><h4 class="discover-title">{{$data->name}}</h4></a>
                                                @else
                                                    <a href="{{route('play.quiz', $data->slug)}}" title="{{$data->name}}"><h4 class="discover-title">{{$data->name}}</h4></a>
                                                @endif
                                            @else
                                                @if($hasAttemptedObj || $hasAttemptedSub )
                                                    @if($data->reattempt == 1)
                                                        @if($data->type == 1)
                                                            <a href="{{route('play.objective', $data->slug)}}" title="{{$data->name}}"><h4 class="discover-title">{{$data->name}}</h4></a>
                                                        @else
                                                            <a href="{{route('play.quiz', $data->slug)}}" title="{{$data->name}}"><h4 class="discover-title">{{$data->name}}</h4></a>
                                                        @endif
                                                    @else
                                                    <a href="{{ route('report.quiz', ['quiz_slug' => $data->slug, 'user_slug' => $user->slug]) }}" title="{{$data->name}}"><h4 class="discover-title">{{$data->name}}</h4></a>
                                                    @endif
                                                @endif
                                            @endif
                                            </div>
                                            <h5 class="discover-sub-title">
                                                @if($data->type == 1)
                                                {{__('Objective')}}
                                                @else
                                                {{__('Subjective')}}
                                                @endif
                                            </h5>
                                            <ul class="discover-lst mb_20">
                                                <li>
                                                    <p class="discover-lst-txt">
                                                        <i class="flaticon-calendar"></i>{{__('Ends On')}}</p>
                                                    <h5 class="discover-lst-title">{{$data->end_date}}</h5>
                                                </li>
                                                <li><div class="line"></div></li>
                                                <li>
                                                    <p class="discover-lst-txt"><i class="flaticon-team-leader"></i>{{__('Players')}}</p>
                                                    <h5 class="discover-lst-title">
                                                    @if($data->type == 1)
                                                        {{ \App\Models\ObjectiveAnswer::where('quiz_id', $data->id)->distinct('user_id')->count() }}
                                                    @else
                                                        {{ \App\Models\SubjectiveAnswer::where('quiz_id', $data->id)->distinct('user_id')->count() }}
                                                    @endif
                                                    </h5>
                                                </li>
                                            </ul>
                                            <div class="row">
                                            @if(auth()->check())
                                                @php
                                                    $user = auth()->user();
                                                    $hasAttemptedobj = \App\Models\ObjectiveAnswer::where('quiz_id', $data->id)
                                                        ->where('user_id', $user->id)
                                                        ->exists();
                                                    $hasAttemptedsub = \App\Models\SubjectiveAnswer::where('quiz_id', $data->id)
                                                    ->where('user_id', $user->id)
                                                    ->exists();
                                                @endphp
                                                <div class="col-lg-7 col-6">
                                                    @if($data->type == 1)
                                                        @if(!$hasAttemptedobj)
                                                        <a href="{{route('play.objective', $data->slug)}}" title="{{$data->name}}" class="btn btn-primary play-btn">{{__('Play Now')}}</a>
                                                        @elseif ($data->reattempt == 1)
                                                        <a href="{{ route('play.objective', $data->slug) }}" title="{{ $data->name }}" class="btn btn-primary play-btn">
                                                            {{ __('Play Again') }}
                                                        </a>
                                                        @else
                                                        <a href="{{ route('report.quiz', ['quiz_slug' => $data->slug, 'user_slug' => $user->slug]) }}" title="{{ $data->name }}" class="btn btn-primary play-btn">
                                                            {{ __('Check Report') }}
                                                        </a>
                                                        @endif
                                                    @else
                                                        @if (!$hasAttemptedsub)
                                                        <a href="{{route('play.quiz', $data->slug)}}" title="{{$data->name}}" class="btn btn-primary play-btn">{{__('Play Now')}}</a>
                                                        @elseif ($data->reattempt == 1)
                                                            <a href="{{ route('play.quiz', $data->slug) }}" title="{{ $data->name }}" class="btn btn-primary play-btn">
                                                                {{ __('Play Again') }}
                                                            </a>
                                                        @else
                                                        <a href="{{ route('report.quiz', ['quiz_slug' => $data->slug, 'user_slug' => $user->slug]) }}" title="{{ $data->name }}" class="btn btn-primary play-btn">
                                                            {{ __('Check Report') }}
                                                        </a>
                                                        @endif
                                                    @endif
                                                </div>
                                                <div class="col-lg-5 col-6 text-end">
                                                    @if (($hasAttemptedsub || $hasAttemptedobj ) && $data->reattempt == 1)
                                                    <a href="{{ route('report.quiz', ['quiz_slug' => $data->slug, 'user_slug' => $user->slug]) }}" title="{{ $data->name }}" class="btn btn-primary play-btn">
                                                        {{ __('Report') }}
                                                    </a>
                                                    @else
                                                        <p class="entry-txt">{{__('Entry fees')}}</p>
                                                        @if($data->service =='1')
                                                        <p class="coin-txt"><i class="flaticon-coin-1"></i>{{$data->fees}}</p>
                                                        @else
                                                        <p class="coin-txt"><i class="flaticon-coin-1"></i>{{ __('Free')}}</p>
                                                        @endif
                                                    @endif
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif
    <!-- Discover End -->

    <!-- Different Zone start -->
    @if(!$zone->isEmpty() && isset($zone))
        @if($hsetting->zone == 1)
            <section id="different-zone" class="different-zone-main-block">
                <div class="container">
                    <div class="section wow bounceInLeft"  data-wow-duration="2s" data-wow-delay="0.2s">
                        <h3 class="section-title">{{__('Play Different Zone')}}</h3>
                    </div>
                    <div class="row">
                        @foreach ($zone as $data )
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="zone-block mb_30 wow bounceInUp"  data-wow-duration="2s" data-wow-delay="0.2s">
                                @if($data['image'] !== NULL && $data['image'] !== '')
                                    <img src="{{ asset('images/zone/' . $data->image) }}" class="img-fluid" alt="{{$data->name}}">
                                @else
                                    <img src="{{Avatar::create($data->name)->toBase64()}}" class="img-fluid" alt="{{$data->name}}">
                                @endif
                                <div class="zone-dtls">
                                    <h4 class="zone-title">{{$data->name}}</h4>
                                    <p class="zone-txt">{{ strip_tags(Str::limit($data['description'], 220, '...')) }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endif
    <!-- Different Zone end -->

    <!-- Testimonial Start -->
    @if(!$client->isEmpty() && isset($client))
        @if($hsetting->testimonial == 1)
            <section id="testimonial" class="testimonial-main-block">
                <div class="container">
                    <div class="section">
                        <h3 class="section-title">{{__('Testimonial')}}</h3>
                    </div>
                    <div class="testimonial-slider">
                        @foreach ($client as $data )
                        <div class="testimonial-block wow fadeInLeft" data-wow-duration="2s" data-wow-delay="0.2s">
                            @if($data['images'] !== NULL && $data['images'] !== '')
                            <div class="testimonial-img mb_20">
                                <img src="{{asset('images/testimonial/'.$data->images)}}" alt="{{$data->client_name}}" class="img-fluid client-img">
                            </div>
                            @else
                            <div class="testimonial-img mb_20">
                                <img src="{{ Avatar::create($data->name)->toBase64() }}" class="img-fluid" alt="{{$data->client_name}}">
                            </div>
                            @endif
                            <ul class="testimonial-lst">
                                @php
                                    $i;
                                @endphp
                                @for ($i=1;$i<=$data->rating;$i++)
                                    <li><i class="flaticon-star"></i></li>
                                @endfor
                            </ul>
                            <div class="testimonial-dtls text-center">
                                <h4 class="client-name mb_10">{{$data->client_name}}</h4>
                                <p class="client-comment">{{ strip_tags(Str::limit($data['details'], 250, '...')) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endif
    <!-- Testimonial End -->

    <!-- Blog Start -->
    @if(!$blog->isEmpty() && isset($blog))
        @if($hsetting->blogs == 1)
            <section id="blog" class="blog-main-block">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 col-6">
                            <div class="section wow bounceInLeft"  data-wow-duration="2s" data-wow-delay="0.2s">
                                <h3 class="section-title">{{__('Blogs')}}</h3>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6 text-end">
                            <a href="{{route('blog.page')}}" title="" class="btn btn-primary see-all-btn wow bounceInRight"  data-wow-duration="2s" data-wow-delay="0.2s">{{__('See all')}}</a>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($blog->take(3) as $data )
                        @php
                            $approvedCommentsCount = \App\Models\BlogComment::where('blog_id', $data->id)
                                                            ->where('approved', '1')
                                                            ->count();
                        @endphp
                        <div class="col-lg-4 col-md-6">
                            <div class="blog-block">
                                @if($data['thumbnail_img'] !== NULL && $data['thumbnail_img'] !== '')
                                <div class="blog-img mb_20">
                                    <a href="{{ route('blog.details', $data->slug) }}" title="{{ $data->title }}">
                                        <img src="{{ asset('images/blog/' . $data->banner_img) }}" alt="{{ $data->title }}" class="img-fluid">
                                    </a>
                                </div>
                                @else
                                <div class="blog-img mb_20">
                                    <a href="{{ route('blog.details', $data->slug) }}" title="{{ $data->title }}"><img src="{{Avatar::create($data->name)->toBase64()}}" class="img-fluid" alt="{{ $data->title }}"></a>
                                </div>
                                @endif
                                <div class="blog-dtls">
                                    <ul class="blog-lst">
                                        <li>
                                            <i class="flaticon-calendar"></i>
                                            {{ $data->created_at->toDateString() }}
                                        </li>
                                        <li>
                                            <i class="flaticon-chat"></i>
                                            {{ __( $approvedCommentsCount . ' comments') }}
                                        </li>
                                    </ul>
                                    <hr>
                                    <div class="truncated-content">
                                        <a href="{{ route('blog.details', $data->slug) }}" title="{{ $data->title }}">
                                            <h4 class="blog-heading mb_20">{{ $data->title }}</h4>
                                        </a>
                                    </div>
                                    <a href="{{ route('blog.details', $data->slug) }}" title="{{ $data->title }}">
                                        <p class="blog-txt mb_20">{{ strip_tags(Str::limit($data['desc'], 250, '...')) }}</p>
                                    </a>
                                    <a href="{{ route('blog.details', $data->slug) }}" class="btn btn-primary blog-btn" title="{{$data->title}}">{{ __('Read More') }} <i class="flaticon-right-arrow"></i></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endif
    <!-- Blog End -->

    <!-- Start Newsletter -->
    @if(!$newsletter->isEmpty() && isset($newsletter))
        @if($hsetting->newsletter == 1)
            <section id="newsletter" class="newsletter-main-block">
                <div class="container">
                    <div class="newsletter-block wow fadeIn" data-wow-duration="2.5s" data-wow-delay="0.2s">
                        <div class="row">
                            @foreach ($newsletter as $data )
                            <div class="col-lg-3 col-md-5 col-12">
                                @if($data['image'] !== NULL && $data['image'] !== '')
                                    <div class="newsletter-img">
                                        <img src="{{asset('images/newsletter/'.$data->image)}}" class="img-fluid" alt="{{$data->title}}">
                                    </div>
                                @else
                                    <div class="newsletter-img">
                                        <img src="{{Avatar::create($data->name)->toBase64()}}" class="img-fluid" alt="{{ $data->title }}">
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-9 col-md-7 col-12">
                                <div class="newsletter-dtls">
                                    <h3 class="newsletter-heading">{{$data->title}}</h3>
                                    <p class="newsletter-txt">{{$data->details}}</p>
                                </div>
                                <div class="newsletter-input-group mt-3">
                                    <form action="{{ route('newsletter.subscribe') }}" class="input-group" method="POST">
                                        @csrf
                                        <input type="email" name="email" autocomplete="on" class="form-control" placeholder="Enter Your Email" aria-label="Recipient's email" id="newsletter-form" aria-describedby="newsletter-button">
                                        <div class="newsletter-btn">
                                            <button type="submit" class="btn submit-btn" id="newsletter-button">{{$data->btn_text}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif
    <!-- End Newsletter -->
@endsection
