@extends('admin.layouts.master')
@section('title', 'Quiz')
@section('main-container')

    <div class="dashboard-card">
        @component('admin.components.breadcumb', ['secondaryactive' => 'active'])
            @slot('heading')
                {{ __('Add Question') }}
            @endslot
            @slot('menu1')
                {{ __('Add Question') }}
            @endslot
            @slot('button')

                <div class="col-md-6 col-lg-6">
                    <div class="widget-button">

                        <a href="{{ route('objective.checkAnswers',['id'=>$quiz_id]) }}" class="btn btn-primary" title="{{ __('Back') }}"><i class="flaticon-back"></i>{{ __('Back') }}</a>
                    </div>
                </div>
            @endslot
        @endcomponent
    
        <!-- Start Contentbar -->
        <div class="contentbar">
            @include('admin.layouts.flash_msg')
            <div class="client-detail-block">
                <div class="row">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="table-responsive">
                            @php
                                    $counter = 1;
                            @endphp
                            <table class="table data-table display nowrap result-table" id="example">
                                <thead>
                                    <tr>
                                        <th>{{ __('#') }}</th>
                                        <th>{{ __('Image') }}</th>
                                        <th>{{ __('Question') }}</th>
                                        <th>{{ __('User Answer') }}</th>
                                        <th>{{ __('Correct Answer')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($question as $data )
                                    <tr>
                                        <td width="10%">{{ $counter++ }}</td>
                                        <td width="20%">
                                            @if($data->question->ques_type == 'multiple_choice')
                                            <img src="{{asset('images/quiz/objective/multiple_choice/'.$data->question->image)}}" alt="">
                                            @elseif ($data->question->ques_type == 'true_false')
                                            <img src="{{asset('images/quiz/objective/true_false/'.$data->question->image)}}" alt="">
                                            @elseif($data->question->ques_type == 'fill_blank')
                                            <img src="{{asset('images/quiz/objective/true_false/'.$data->question->image)}}" alt="">
                                            @elseif($data->question->ques_type == 'match_following')
                                            <img src="{{asset('images/quiz/objective/match_following/'.$data->question->image)}}" alt="">
                                            @endif
                                        </td>
                                        <td width="30%">{{$data->question->question}}</td>
                                        <td width="20%">{{$data->user_answer}}</td>
                                        <td width="20%">
                                            {{$data->question->correct_answer}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
