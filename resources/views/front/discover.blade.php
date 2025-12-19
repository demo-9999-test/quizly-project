@extends('front.layouts.master')
@section('title', 'Quizly | Discover')
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
                    <h2 class="breadcrumb-title mb_30">{{__('Discover')}}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Discover')}} </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--end Breadcrumb-->
<!-- Discover Start -->
<section id="discover" class="discover-main-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-9">
                <div class="section">
                    <h3 class="section-title">{{__('Discover More Quiz')}}</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    <div class="explore-categories">
                        <div class="input-group search-input">
                            <input type="text" class="form-control" id="searchInput11" placeholder="Search here..." autocomplete="off" value="{{ $searchQuery }}">
                            <span class="input-group-text">
                                <a href="javascript:void(0)" id="searchButton11">
                                    <i class="flaticon-search-interface-symbol"></i>
                                </a>
                            </span>
                        </div>
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <h4 class="accordion-header">
                                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">{{__('Categories')}}</button>
                                </h4>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                                  <div class="accordion-body">
                                      <ul class="explore-categories-lst">
                                          @foreach ($allCategories as $exploreCategory)
                                              <li>
                                                <a href="{{ route('category.single', $exploreCategory->slug) }}">{{ $exploreCategory->name }} <span class="text-end">{{ '('.$exploreCategory->quizzes->where('status',1)->count().')' }}</span>
                                                </a>
                                              </li>
                                          @endforeach
                                      </ul>
                                  </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h4 class="accordion-header">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                    {{__('Price')}}
                                  </button>
                                </h4>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show">
                                  <div class="accordion-body">
                                    <div class="form-check">
                                      <input class="form-check-input price-filter" type="radio" name="priceFilter" value="all" id="allPrices" {{ $priceFilter == 'all' ? 'checked' : '' }}>
                                      <label class="form-check-label" for="allPrices">{{__('All')}}</label>
                                    </div>
                                    <div class="form-check">
                                      <input class="form-check-input price-filter" type="radio" name="priceFilter" value="free" id="freeQuizzes" {{ $priceFilter == 'free' ? 'checked' : '' }}>
                                      <label class="form-check-label" for="freeQuizzes">{{__('Free')}}</label>
                                    </div>
                                    <div class="form-check">
                                      <input class="form-check-input price-filter" type="radio" name="priceFilter" value="paid" id="paidQuizzes" {{ $priceFilter == 'paid' ? 'checked' : '' }}>
                                      <label class="form-check-label" for="paidQuizzes">{{__('Paid')}}</label>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <!-- Type filter -->
                              <div class="accordion-item">
                                <h4 class="accordion-header">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                    {{__('Types')}}
                                  </button>
                                </h4>
                                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show">
                                  <div class="accordion-body">
                                    <div class="form-check">
                                      <input class="form-check-input type-filter" type="radio" name="typeFilter" value="all" id="allTypes" {{ $typeFilter == 'all' ? 'checked' : '' }}>
                                      <label class="form-check-label" for="allTypes">{{__('All')}}</label>
                                    </div>
                                    <div class="form-check">
                                      <input class="form-check-input type-filter" type="radio" name="typeFilter" value="objective" id="objectiveQuizzes" {{ $typeFilter == 'objective' ? 'checked' : '' }}>
                                      <label class="form-check-label" for="objectiveQuizzes">{{__('Objective')}}</label>
                                    </div>
                                    <div class="form-check">
                                      <input class="form-check-input type-filter" type="radio" name="typeFilter" value="subjective" id="subjectiveQuizzes" {{ $typeFilter == 'subjective' ? 'checked' : '' }}>
                                      <label class="form-check-label" for="subjectiveQuizzes">{{__('Subjective')}}</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="row">
                        @if($paginate->isEmpty())
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <img src="{{asset('images/nothing-here/nothing-01.jpg')}}" class="img-fluid mb_30" alt="{{__('Nothing here')}}">
                                    <h2>{{__('Seems like there is no active quiz')}}</h2>
                                </div>
                            </div>
                            @else
                            @foreach ($paginate as $data)
                                <div class="col-lg-12 mb_30" data-service="{{ $data->service }}" data-type="{{ $data->type }}">
                                    <div class="discover-block">
                                        <div class="row">
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
                                            <div class="col-lg-4">
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
                                            </div>
                                            <div class="col-lg-8">
                                                @if(($data->type == 1 && !$hasAttemptedObj) || ($data->type != 1 && !$hasAttemptedSub))
                                                    @if($data->type == 1)
                                                        <a href="{{route('play.objective', $data->slug)}}" title="{{$data->name}}"><h4 class="discover-title">{{$data->name}}</h4></a>
                                                        <a href="{{route('play.objective', $data->slug)}}"><p class="discover-txt">{{ strip_tags(Str::limit($data->description, 200, '...')) }}</p></a>
                                                    @else
                                                        <a href="{{route('play.quiz', $data->slug)}}" title="{{$data->name}}"><h4 class="discover-title">{{$data->name}}</h4></a>
                                                        <a href="{{route('play.quiz', $data->slug)}}"><p class="discover-txt">{{ strip_tags(Str::limit($data->description, 200, '...')) }}</p></a>
                                                    @endif
                                                @else
                                                    @if($hasAttemptedObj || $hasAttemptedSub )
                                                        @if($data->reattempt == 1)
                                                            @if($data->type == 1)
                                                                <a href="{{route('play.objective', $data->slug)}}" title="{{$data->name}}"><h4 class="discover-title">{{$data->name}}</h4></a>
                                                                <a href="{{route('play.objective', $data->slug)}}"><p class="discover-txt">{{ strip_tags(Str::limit($data->description, 200, '...')) }}</p></a>
                                                            @else
                                                                <a href="{{route('play.quiz', $data->slug)}}" title="{{$data->name}}"><h4 class="discover-title">{{$data->name}}</h4></a>
                                                                <a href="{{route('play.quiz', $data->slug)}}"><p class="discover-txt">{{ strip_tags(Str::limit($data->description, 200, '...')) }}</p></a>
                                                            @endif
                                                        @else
                                                        <a href="{{ route('report.quiz', ['quiz_slug' => $data->slug, 'user_slug' => $user->slug]) }}" title="{{$data->name}}"><h4 class="discover-title">{{$data->name}}</h4></a>
                                                        <a href="{{route('report.quiz', ['quiz_slug' => $data->slug, 'user_slug' => $user->slug])}}"><p class="discover-txt">{{ strip_tags(Str::limit($data->description, 200, '...')) }}</p></a>
                                                        @endif
                                                    @endif
                                                @endif
                                                <ul class="discover-lst mt-4 mb_30">
                                                    <li>
                                                        <p class="discover-lst-txt"><i class="flaticon-calendar"></i>{{__('Starts On')}}</p>
                                                        <h5 class="discover-lst-title">{{$data->start_date}}</h5>
                                                    </li>
                                                    <li><div class="line"></div></li>
                                                    <li>
                                                        <p class="discover-lst-txt"><i class="flaticon-calendar"></i>{{__('Ends On')}}</p>
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
                                                    <li><div class="line"></div></li>
                                                    <li>
                                                        <p class="discover-lst-txt">{{__('Type')}}</p>
                                                        @if($data->type==0)
                                                        <h5 class="discover-lst-title">{{__('subjective')}}</h5>
                                                        @else
                                                        <h5 class="discover-lst-title">{{__('objective')}}</h5>
                                                        @endif
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
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="pagination">
                        {{ $paginate->appends(['price_filter' => $priceFilter, 'type_filter' => $typeFilter, 'search' => $searchQuery])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Discover End -->
@endsection
