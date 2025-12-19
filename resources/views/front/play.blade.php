@extends('front.layouts.master')
@section('title', 'Play Quiz')
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
                    <h2 class="breadcrumb-title mb_30">{{__('Play quiz')}}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{__($quiz->name)}} </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--end Breadcrumb-->

<!--start Quiz question -->
@if($quiz->count() > 0 && isset($quiz))
@php
    $ques = App\Models\Subjective::where('quiz_id', $quiz->id)->get();
    $ques_count = $ques->count();
@endphp
<section id="quiz-question" class="quiz-question-main-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                    <h3 class="section-title">{{__('Answer the following question')}}</h3>
            </div>
            <div class="col-lg-3 text-end">
                <button class="btn btn-primary back-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">{{__('End Quiz')}}</button>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="exampleModalLabel">{{ __('You Really Want To Leave Quiz?') }}</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ __('If you click "Yes," your answers will be submitted. Are you sure you want to submit your answers?') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary modal-btn" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <a href="{{ route('home.page') }}" id="confirmLeave" title="{{ __('yes') }}" class="btn btn-danger modal-btn">{{ __('Yes') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="question-block">
                    <div class="question-top mb_30">
                        <div class="row">
                            <div class="col-lg-4">
                                @if($quiz->service == 1)
                                    <span class="badge question-badge">{{__('Coins:'.$quiz->fees)}}</span>
                                @else
                                    <span class="badge question-badge">{{__('Free')}}</span>
                                @endif
                            </div>
                            <div class="col-lg-4 text-center">
                                <h4 class="quiz-name">{{$quiz->name}}</h4>
                            </div>
                            <div class="col-lg-4">
                                <div class="quiz-timer text-end">
                                    <div class="timer-container">
                                        <h5 class="timer-heading">{{__('Timer:')}}</h5>
                                        <div class="timer" data-timer="{{ $quiz->timer * 60 }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form id="quizForm" action="{{ route('submit.quiz', ['id' => $quiz->id, 'question_id' => 0]) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                @foreach($ques as $key => $question)
                                <div class="question-display-block" id="question{{ $key }}" style="{{ $key == 0 ? '' : 'display: none;' }}">
                                    <div class="row">
                                        <div class="col-lg-12 text-center">
                                            <h5 class="question-number">{{ 'Question Number: ' . ($key + 1) . '/' . $ques_count }}</h5>
                                        </div>
                                        <div class="col-lg-12 text-center">
                                            <div class="quiz-question mb_30">
                                                <p class="question">{{ 'Q' . ($key + 1) . '. ' . $question['question'] }}</p>
                                            </div>
                                            @if (($question['image']))
                                            <div class="quiz-question-img">
                                                <img src="{{ asset('images/quiz/subjective/' . $question['image']) }}" class="img-fluid mb_30" alt="{{ $question['question'] }}">
                                            </div>
                                            @endif
                                            <div class="option-block">
                                                <div class="row mb_30">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <input type="hidden" name="question_id[]" value="{{ $question['id'] }}">
                                                            <textarea name="answer[]" class="form-control" rows="10"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="button" id="prevBtn" class="btn btn-md btn-primary prev-btn" style="display: none;">{{ __('Prev') }}</button>
                            </div>
                            <div class="col-lg-6 text-end">
                                <button type="button" id="nextBtn" class="btn btn-md btn-primary next-btn">{{ __('Next') }}</button>
                                <button type="submit" id="submitBtn" class="btn btn-md btn-primary" style="display: none;">{{ __('Finish') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--end Quiz question -->
@endif
@endsection

<!-- Quiz Question Script start -->
@section('scripts')
<script>
$(document).ready(function() {
    let currentQuestion = 0;
    const totalQuestions = {{ $ques_count }};

    function showQuestion(index) {
        $('.question-display-block').hide();
        $(`#question${index}`).show();

        if (index === 0) {
            $('#prevBtn').hide();
        } else {
            $('#prevBtn').show();
        }

        if (index === totalQuestions - 1) {
            $('#nextBtn').hide();
            $('#submitBtn').show();
        } else {
            $('#nextBtn').show();
            $('#submitBtn').hide();
        }
    }

    $('#nextBtn').click(function() {
        if (currentQuestion < totalQuestions - 1) {
            currentQuestion++;
            showQuestion(currentQuestion);
        }
    });

    $('#prevBtn').click(function() {
        if (currentQuestion > 0) {
            currentQuestion--;
            showQuestion(currentQuestion);
        }
    });
});
</script>
<!-- Quiz Question Script end -->
 
@endsection
