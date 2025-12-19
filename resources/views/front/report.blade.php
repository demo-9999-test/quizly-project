@extends('front.layouts.master')
@section('title', 'Report')
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
                    <h2 class="breadcrumb-title mb_30">{{__('Report of your')}}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Report of your')}} </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--end Breadcrumb-->

<!--report section start-->
<section id="report" class="report-main-block">
    <div class="container">
        <div class="section wow bounceInLeft"  data-wow-duration="2s" data-wow-delay="0.2s">
            <h3 class="section-title">{{__('Report')}}</h3>
        </div>
        <div class="report-card">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="report-block mb_30">
                                <div class="user-report">
                                    <div class="row align-items-center">
                                        <div class="col-lg-4">
                                            <div class="user-report-img">
                                                <img src="{{ asset('/images/users/' . Auth::user()->image) }}" class="img-fluid user-image" alt="{{ Auth::user()->name }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="user-report-txt">
                                                <h4 class="user-name-report">{{ Auth::user()->name }}</h4>
                                                <p class="user-mail-report">{{ Auth::user()->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="quiz-report-details">
                        <h3 class="quiz-report-heading mb_30">{{$quiz->name}}</h3>
                    </div>
                    <div class="report-table mb_30">
                        @if ($quiz->type == 0)
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>{{ __('Total Questions') }}</th>
                                    <th>{{ __('Attempted Questions') }}</th>
                                    <th>{{ __('Questions Skipped') }}</th>
                                    <th>{{ __('Result') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $subAns->count() }}</td>
                                    @php
                                        $totalAnswers = $subAns->count();
                                        $nonNullAnswers = $subAns->filter(function ($answer) {
                                            return $answer->answer !== null;
                                        })->count();
                                        $nullAnswers = $subAns->filter(function ($answer) {
                                            return $answer->answer === null;
                                        })->count();
                                    @endphp
                                    <td>{{ $nonNullAnswers }} / {{ $totalAnswers }}</td>
                                    <td>{{ $nullAnswers }} / {{ $totalAnswers }}</td>
                                    <td>
                                        @if($quiz->approve_result == 1)
                                        <a href="{{ route('sub.front_result', ['quiz_id' => $quiz->id, 'user_id' => Auth::user()->id]) }}" class="btn btn-primary check-result-btn">{{ __('Check result') }}</a>
                                        @else
                                        <span class="badge" data-bs-toggle="tooltip" data-bs-placement="top" title="Your quiz result is pending. Our team is carefully reviewing your answers. Check back soon for your final score and detailed feedback!">
                                            {{__('Pending')}}
                                          </span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @else
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>{{ __('Total Questions') }}</th>
                                    <th>{{ __('Attempted Questions') }}</th>
                                    <th>{{ __('Questions Skipped') }}</th>
                                    <th>{{ __('Result') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $objAns->count() }}</td>
                                    @php
                                        $totalAnswers = $objAns->count();
                                        $nonNullAnswers = $objAns->filter(function ($user_answer) {
                                            return $user_answer->user_answer !== null;
                                        })->count();
                                        $nullAnswers = $objAns->filter(function ($user_answer) {
                                            return $user_answer->user_answer === null;
                                        })->count();
                                    @endphp
                                    <td>{{ $nonNullAnswers }} / {{ $totalAnswers }}</td>
                                    <td>{{ $nullAnswers }} / {{ $totalAnswers }}</td>
                                    <td>
                                        @if($quiz->approve_result == 1)
                                        <a href="{{ route('obj.front_result', ['quiz_id' => $quiz->id, 'user_id' => Auth::user()->id]) }}" class="btn btn-primary check-result-btn">{{ __('Check result') }}</a>
                                        @else
                                        <span class="badge" data-bs-toggle="tooltip" data-bs-placement="top" title="Your quiz result is pending. Our team is carefully reviewing your answers. Check back soon for your final score and detailed feedback!">
                                            {{__('Pending')}}
                                          </span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @endif
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-2">
                            <a href="{{route('home.page')}}" class="btn btn-primary">{{__('Home Page')}}</a>
                        </div>
                        @if($quiz->approve_result == 0)
                            @if($quiz->reattempt == 1)
                                <div class="col-lg-2">
                                    <a href="{{ route('try.again', ['quiz_id' => $quiz->id]) }}" class="btn btn-primary">{{__('Try again')}}</a>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--report section end-->

@endsection
