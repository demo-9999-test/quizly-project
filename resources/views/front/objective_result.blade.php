@extends('front.layouts.master')
@section('title', 'Quizz')
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
                    <h2 class="breadcrumb-title mb_30">{{__('Result')}}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Result')}} </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--end Breadcrumb-->

<!-- quiz result start -->
<div class="result-main-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section">
                    <h2 class="section-title">{{__('Your quiz result')}}</h2>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        @if($passingMarks<$userTotal)
                            <div class="result-block">
                                <div class="row align-items-center">
                                    <div class="col-lg-1 col-md-2 col-4">
                                        <span class="badge pass-badge text-bg-success"><i class="flaticon-like"></i></span>
                                    </div>
                                    <div class="col-lg-5 col-md-6 col-8">
                                        <h4 class="result-title passed-title">{{__('Congratulations! You Passed the Quiz')}}</h4>
                                        <h6 class="result-sub-title">
                                            {{__('Continue to next module')}}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        @else
                        <div class="result-block">
                            <div class="row align-items-center">
                                <div class="col-lg-1 col-md-2 col-4">
                                    <span class="badge fail-badge text-bg-danger"><i class="flaticon-thumb-down"></i></span>
                                </div>
                                <div class="col-lg-5 col-md-6 col-8">
                                    <h4 class="result-title failed-title">{{__('Unfortunately, You Failed the Quiz')}}</h4>
                                    <h6 class="result-sub-title">
                                        {{__('Better Luck Next Time!')}}
                                    </h6>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="quiz-student-detail">
                    <div class="row align-items-center">
                        <div class="col-lg-1 col-md-2 col-4">
                            <img src="{{ asset('images/users/'.$user->image) }}" class="img-fluid quiz-student-img" alt="{{$user->name}}">
                        </div>
                        <div class="col-lg-3 col-md-3 col-8">
                            <h4 class="quiz-student-name">{{$user->name}}</h4>
                            <h6 class="quiz-student-email"><a href="#" title="{{$user->name}}">{{$user->email}}</a></h6>
                            <h6 class="quiz-student-phone"><a href="#" title="{{$user->name}}" >{{$user->mobile}}</a></h6>
                        </div>
                        <div class="col-lg-4 col-md-3 text-center">
                            <div class="report-quiz-img">
                                <img src="{{asset('images/quiz/'.$quiz->image)}}" class="img-fluid mb_10" alt="{{$quiz->name}}">
                            </div>
                            <div class="report-quiz-dtls">
                                <h4 class="report-quiz-name">{{$quiz->name}}</h4>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-3 text-end">
                            <h4 class="score-heading">{{__('Your Score')}}</h4>
                            <h4 class="user-score">
                                {{$userTotal}}
                            </h4>
                            <h4 class="total-score">{{$totalMarks}}</h4>
                        </div>
                    </div>
                </div>
                <div class="row mb_30">
                    <div class="col-lg-3 col-md-3 text-center">
                        <div class="summary-block">
                            <h4 class="summary-title">{{__('Skipped questions')}}</h4>
                            <h3 class="summary-txt">{{ $userAnswer->whereNull('answer')->count() }}</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 text-center">
                        <div class="summary-block">
                            <h4 class="summary-title">{{__('Attempted questions')}}</h4>
                            <h3 class="summary-txt">{{ $userAnswer->whereNotNull('answer')->count() }}</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 text-center">
                        <div class="summary-block">
                            <h4 class="summary-title">{{__('Correct answers')}}</h4>
                            <h3 class="summary-txt">{{ $userAnswer->where('answer_approved', 1)->count() }}</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 text-center">
                        <div class="summary-block">
                            <h4 class="summary-title">{{__('Wrong answers')}}</h4>
                            <h3 class="summary-txt">{{ $userAnswer->where('answer_approved', 0)->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        @foreach ($userAnswer as $data)
                            @if($data->answer_approved === 1)
                                <div class="question-answer-block passed mb_20">
                                    <div class="row">
                                        <div class="col-lg-11 col-md-11 col-11">
                                            <h4 class="question-answer-title mb_30">  <span>{{('Q: ')}}</span> {{$data->question->question }}</h4>
                                            @if($data->question->ques_type === 'multiple_choice')
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-6 text-center">
                                                        <div class="result-option-block">
                                                            {{$data->question->option_a }}
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-6 text-center">
                                                        <div class="result-option-block">
                                                            {{$data->question->option_b }}
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-6 text-center">
                                                        <div class="result-option-block">
                                                            {{$data->question->option_c }}
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-6 text-center">
                                                        <div class="result-option-block">
                                                            {{$data->question->option_d }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif($data->question->ques_type === 'true_false')
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-6 text-center">
                                                        <div class="result-option-block">
                                                            {{$data->question->option_a }}
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-6 text-center">
                                                        <div class="result-option-block">
                                                            {{$data->question->option_b }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif($data->question->ques_type === 'match_following')
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-6">
                                                    <h4 class="column-heading mb_20">{{__('Column A')}}</h4>
                                                    <ul class="match-following-box">
                                                        @php
                                                        $i = 'A';
                                                        $data->question->option_a = explode('||', $data->question->option_a);
                                                        foreach ($data->question->option_a as $item) {
                                                            echo "<li>" . ($i++).') '. trim($item) . "</li>";
                                                        }
                                                        @endphp
                                                    </ul>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-6">
                                                    <h4 class="column-heading mb_20">{{__('Column B')}}</h4>
                                                    <ul class="match-following-box">
                                                        @php
                                                        $i = 1;
                                                        $data->question->option_b = explode('||', $data->question->option_b);
                                                        foreach ($data->question->option_b as $item) {
                                                            echo "<li>" . ($i++). ') ' . trim($item) . "</li>";
                                                        }
                                                        @endphp
                                                    </ul>
                                                </div>
                                            </div>
                                            @endif
                                            <h5 class="question-answer-txt mb_10">{{('Your Ans: ')}} {{$data->user_answer }}</h5>
                                            <h5 class="question-answer-txt">{{('Correct Ans: ')}} {{$data->question->correct_answer }}</h5>
                                        </div>
                                        <div class="col-lg-1 col-md-1 col-1 text-center">
                                            <div class="quetion-answer-icon quetion-answer-passed ">
                                                <i class="flaticon-check-mark"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                            <div class="question-answer-block failed mb_20">
                                <div class="row">
                                    <div class="col-lg-11 col-11">
                                        <h4 class="question-answer-title mb_30">  <span>{{('Q: ')}}</span> {{$data->question->question }}</h4>
                                        @if($data->question->ques_type === 'multiple_choice')
                                            <div class="row">
                                                <div class="col-lg-6 col-6 text-center">
                                                    <div class="result-option-block">
                                                        {{$data->question->option_a }}
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-6 text-center">
                                                    <div class="result-option-block">
                                                        {{$data->question->option_b }}
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-6 text-center">
                                                    <div class="result-option-block">
                                                        {{$data->question->option_c }}
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-6 text-center">
                                                    <div class="result-option-block">
                                                        {{$data->question->option_d }}
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($data->question->ques_type === 'true_false')
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-6 text-center">
                                                    <div class="result-option-block">
                                                        {{$data->question->option_a }}
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-6 text-center">
                                                    <div class="result-option-block">
                                                        {{$data->question->option_b }}
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($data->question->ques_type === 'match_following')
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-6">
                                                <h4 class="column-heading mb_20">{{__('Column A')}}</h4>
                                                <ul class="match-following-box">
                                                    @php
                                                    $i = 'A';
                                                    $data->question->option_a = explode('||', $data->question->option_a);
                                                    foreach ($data->question->option_a as $item) {
                                                        echo "<li>" . ($i++).') '. trim($item) . "</li>";
                                                    }
                                                    @endphp
                                                </ul>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-6">
                                                <h4 class="column-heading mb_20">{{__('Column B')}}</h4>
                                                <ul class="match-following-box">
                                                    @php
                                                    $i = 1;
                                                    $data->question->option_b = explode('||', $data->question->option_b);
                                                    foreach ($data->question->option_b as $item) {
                                                        echo "<li>" . ($i++). ') ' . trim($item) . "</li>";
                                                    }
                                                    @endphp
                                                </ul>
                                            </div>
                                        </div>
                                        @endif
                                        <h5 class="question-answer-txt mb_10">{{('Your Ans: ')}} {{$data->user_answer }}</h5>
                                        <h5 class="question-answer-txt">{{('Correct Ans: ')}} {{$data->question->correct_answer }}</h5>
                                    </div>
                                    <div class="col-lg-1 col-1 text-center">
                                        <div class="quetion-answer-icon quetion-answer-failed">
                                            <i class="flaticon-wrong"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 offset-lg-2">
                        <a href="{{route('home.page')}}" class="btn btn-primary">{{__('Home page')}}</a>
                    </div>
                    <div class="col-lg-3">
                        <a href="" class="btn btn-primary" id="downloadBtn">{{__('Download report')}}</a>
                    </div>
                    <div class="col-lg-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shareReportModal">{{__('Share report')}}</button>
                    </div>
                    <!-- quiz result end -->

                    <!-- Modal -->
                    <!-- quiz result share start -->
                    <div class="modal fade report-model" id="shareReportModal" tabindex="-1" aria-labelledby="shareReportModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="shareReportModalLabel">{{__('Share Report')}}</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <ul class="social-icons">
                                            <li>
                                                <a href="" title="{{__('facebook')}}" target="_blank">
                                                    <i class="flaticon-facebook-app-symbol"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="" title="{{__('twitter')}}" target="_blank">
                                                    <i class="flaticon-twitter"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="" title="{{__('instagram')}}" target="_blank">
                                                    <i class="flaticon-instagram"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="" title="{{__('whatsapp')}}" target="_blank">
                                                    <i class="flaticon-whatsapp"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- quiz result share end -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
