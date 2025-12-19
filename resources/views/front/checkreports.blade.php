@extends('front.layouts.master')
@section('title', 'Quizly | My Reports')
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
                    <h2 class="breadcrumb-title mb_30">{{__('Reports')}}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Reports')}} </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->
<!-- Report page start -->
<section id="report-page" class="report-page-main-block">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="nav nav-pills mb_20" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active" id="v-pills-quiz-tab" data-bs-toggle="pill" data-bs-target="#v-pills-quiz" type="button" role="tab" aria-controls="v-pills-quiz" aria-selected="true">{{__('Quiz')}}</button>
                    <button class="nav-link" id="v-pills-invoice-tab" data-bs-toggle="pill" data-bs-target="#v-pills-invoice" type="button" role="tab" aria-controls="v-pills-invoice" aria-selected="false">{{__('Invoice')}}</button>
                </div>
            </div>
            <div class="col-md-12">
                <div class="tab-content" id="v-pills-tabContent">
                    <!-- Quiz Section -->
                    <div class="tab-pane fade show active" id="v-pills-quiz" role="tabpanel" aria-labelledby="v-pills-quiz-tab">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="report-user-block mb_10">
                                    <div class="report-user-icon"><i class="flaticon-medal-ribbon"></i></div>
                                    <h4 class="report-user-heading">{{__('Rank')}}</h4>
                                    <h3 class="report-user-number">{{$user->rank}}</h3>
                                </div>
                                <div class="report-user-block mb_10">
                                    <div class="report-user-icon"><i class="flaticon-coin"></i></div>
                                    <h4 class="report-user-heading">{{__('Coins')}}</h4>
                                    <h3 class="report-user-number">{{$user->coins}}</h3>
                                </div>
                                <div class="report-user-block">
                                    <div class="report-user-icon"><i class="flaticon-scoreboard"></i></div>
                                    <h4 class="report-user-heading">{{__('Score')}}</h4>
                                    <h3 class="report-user-number">{{$user->score}}</h3>
                                </div>
                            </div>
                            <div class="col-md-9">
                                @if($quizzes->isEmpty() && isset($quizzes))
                        <div class="nothing-here-block">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <img src="{{asset('images/nothing-here/nothing-01.jpg')}}" class="img-fluid mb_30" alt="{{__('Nothing here')}}">
                                    <h2>{{__('Seems like no report published yet')}}</h2>
                                    <p>{{__('Play quiz and wait until result is published')}}</p>
                                </div>
                            </div>
                        </div>
                        @else
                        @foreach($quizzes as $data)
                        <div class="discover-block mb_30">
                            <div class="row">
                                <div class="col-lg-4">
                                    @if($data['image'] !== NULL && $data['image'] !== '')
                                        <div class="discover-image">
                                            <button id="bookmark-btn-{{ $data->id }}" class="bookmark-btn btn btn-primary" data-quiz-id="{{ $data->id }}">
                                                <i class="flaticon-bookmark"></i>
                                            </button>
                                            @if($data->reattempt == 1)
                                                @if($data->approve_result == 0)
                                                    @if($data->type == 1)
                                                        <a href="{{route('play.objective', $data->slug)}}" title="{{$data->name}}"><img src="{{asset('images/quiz/'.$data->image)}}" class="img-fluid" alt="{{$data->name}}"></a>
                                                    @else
                                                        <a href="{{route('play.quiz', $data->slug)}}" title="{{$data->name}}"><img src="{{asset('images/quiz/'.$data->image)}}" class="img-fluid" alt="{{$data->name}}"></a>
                                                    @endif
                                                @else
                                                <a href="{{ route('report.quiz', ['quiz_slug' => $data->slug, 'user_slug' => $user->slug]) }}" title="{{ $data->name }}"><img src="{{asset('images/quiz/'.$data->image)}}" class="img-fluid" alt="{{$data->name}}"></a>
                                                @endif
                                            @else
                                            <a href="{{ route('report.quiz', ['quiz_slug' => $data->slug, 'user_slug' => $user->slug]) }}" title="{{ $data->name }}"><img src="{{asset('images/quiz/'.$data->image)}}" class="img-fluid" alt="{{$data->name}}"></a>
                                            @endif
                                        </div>
                                        @else
                                            <div class="discover-image">
                                                <button id="bookmark-btn-{{ $data->id }}" class="bookmark-btn btn btn-primary" data-quiz-id="{{ $data->id }}">
                                                    <i class="flaticon-bookmark"></i>
                                                </button>
                                                @if($data->reattempt == 1)
                                                    @if($data->approve_result == 0)
                                                        @if($data->type == 1)
                                                            <a href="{{route('play.objective', $data->slug)}}" title="{{$data->name}}"><img src="Avatar::create($data->name)->toBase64()" class="img-fluid" alt="{{$data->name}}"></a>
                                                        @else
                                                            <a href="{{route('play.quiz', $data->slug)}}" title="{{$data->name}}"><img src="Avatar::create($data->name)->toBase64()" class="img-fluid" alt="{{$data->name}}"></a>
                                                        @endif
                                                    @else
                                                        <a href="{{ route('report.quiz', ['quiz_slug' => $data->slug, 'user_slug' => $user->slug]) }}" title="{{ $data->name }}"><img src="Avatar::create($data->name)->toBase64()" class="img-fluid" alt="{{$data->name}}"></a>
                                                    @endif
                                                @else
                                                <a href="{{ route('report.quiz', ['quiz_slug' => $data->slug, 'user_slug' => $user->slug]) }}" title="{{ $data->name }}"><img src="Avatar::create($data->name)->toBase64()" class="img-fluid" alt="{{$data->name}}"></a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-lg-8">
                                        @if($data->reattempt == 1)
                                            @if($data->approve_result == 0)
                                                @if($data->type == 1)
                                                <a href="{{route('play.objective', $data->slug)}}" title="{{$data->name}}"><h4 class="discover-title">{{$data->name}}</h4></a>
                                                @else
                                                <a href="{{route('play.quiz', $data->slug)}}" title="{{$data->name}}"><h4 class="discover-title">{{$data->name}}</h4></a>
                                                @endif
                                            @else
                                            <a href="{{ route('report.quiz', ['quiz_slug' => $data->slug, 'user_slug' => $user->slug]) }}" title="{{$data->name}}"><h4 class="discover-title">{{$data->name}}</h4></a>
                                            @endif
                                        @else
                                        <a href="{{ route('report.quiz', ['quiz_slug' => $data->slug, 'user_slug' => $user->slug]) }}" title="{{$data->name}}"><h4 class="discover-title">{{$data->name}}</h4></a>
                                        @endif
                                        @if($data->reattempt == 1)
                                            @if($data->approve_result == 0)
                                                @if($data->type == 1)
                                                    <a href="{{route('play.objective', $data->slug)}}" title="{{$data->name}}"><p class="discover-txt">{{ strip_tags(Str::limit($data->description, 200, '...')) }}</p></a>
                                                @else
                                                    <a href="{{route('play.quiz', $data->slug)}}" title="{{$data->name}}"><p class="discover-txt">{{ strip_tags(Str::limit($data->description, 200, '...')) }}</p></a>
                                                @endif
                                            @else
                                            <a href="{{ route('report.quiz', ['quiz_slug' => $data->slug, 'user_slug' => $user->slug]) }}" title="{{$data->name}}"><p class="discover-txt">{{ strip_tags(Str::limit($data->description, 200, '...')) }}</p></a>
                                            @endif
                                        @else
                                        <a href="{{ route('report.quiz', ['quiz_slug' => $data->slug, 'user_slug' => $user->slug]) }}" title="{{$data->name}}"><p class="discover-txt">{{ strip_tags(Str::limit($data->description, 200, '...')) }}</p></a>
                                        @endif
                                        <ul class="discover-lst mb_30">
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
                                                        @if($data->approve_result == 0)
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
                                                        <a href="{{ route('report.quiz', ['quiz_slug' => $data->slug, 'user_slug' => $user->slug]) }}" title="{{ $data->name }}" class="btn btn-primary play-btn">
                                                            {{ __('Check Report') }}
                                                        </a>
                                                        @endif
                                                    @else
                                                        @if($data->approve_result == 0)
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
                                                        @else
                                                        <a href="{{ route('report.quiz', ['quiz_slug' => $data->slug, 'user_slug' => $user->slug]) }}" title="{{ $data->name }}" class="btn btn-primary play-btn">
                                                            {{ __('Check Report') }}
                                                        </a>
                                                        @endif
                                                    @endif
                                                </div>
                                                <div class="col-lg-5 col-6 text-end">
                                                    @if($data->approve_result == 0)
                                                        @if (($hasAttemptedsub || $hasAttemptedobj ) && $data->reattempt == 1)
                                                        <a href="{{ route('report.quiz', ['quiz_slug' => $data->slug, 'user_slug' => $user->slug]) }}" title="{{ $data->name }}" class="btn btn-primary play-btn">
                                                            {{ __('Report') }}
                                                        </a>
                                                        @endif
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
                            </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-invoice" role="tabpanel" aria-labelledby="v-pills-invoice-tab">
                        <div class="table-responsive">
                            <table class="table transaction-table">
                                <thead>
                                    <tr>
                                        <th>{{__('Package Name')}}</th>
                                        <th>{{__('Transaction Id')}}</th>
                                        <th>{{__('Date')}}</th>
                                        <th>{{__('Status')}}</th>
                                        <th>{{__('Total Amount')}}</th>
                                        <th>{{__('Check Details')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($checkouts as $data )
                                    <tr>
                                        <td>{{$data->package->pname }}</td>
                                        <td>{{$data->transaction_id}}</td>
                                        <td>{{$data->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            @if($data->status == 'success')
                                            <p class="success-txt">{{$data->status}}</p>
                                            @elseif ($data->status == 'failed')
                                            <p class="error-txt">{{$data->status}}</p>
                                            @else
                                            <p class="warning-txt">{{$data->status}}</p>
                                            @endif
                                        </td>
                                        <td>{{$data->currency_icon}} {{ $data->total_amount}}</td>
                                        <td><a href="{{ route('front.invoice', ['user_slug' => $user->slug, 'transaction_id' => $data->transaction_id]) }}" class="btn btn-primary">{{ __('Details') }}</a></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6">{{__('No data available')}}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination">
                            {{ $checkouts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
<!-- Report page end -->
@endsection
