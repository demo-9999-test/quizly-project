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

                        <a href="{{ route('subjective.checkAnswers',['id'=>$quiz_id]) }}" class="btn btn-primary" title="{{ __('Back') }}"><i class="flaticon-back"></i>{{ __('Back') }}</a>
                    </div>
                </div>
            @endslot
        @endcomponent
        <!-- Start Contentbar -->
        <div class="contentbar">
            @include('admin.layouts.flash_msg')
            <div class="row">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="table-responsive">
                        @php
                                $counter = 1;
                        @endphp
                        <table class="table data-table display nowrap result-table" id="questionTable">
                            <thead>
                                <tr>
                                    <th>{{ __('#') }}</th>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Question') }}</th>
                                    <th>{{ __('Answer') }}</th>
                                    <th>{{ __('Check')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($question as $data )
                                <tr>
                                    <td width="10%">{{ $counter++ }}</td>
                                    <td width="20%"><img src="{{asset('images/quiz/subjective/'.$data->question->image)}}" alt=""></td>
                                    <td width="30%">{{$data->question->question}}</td>
                                    <td width="30%">{{$data->answer}}</td>
                                    <td width="10%">
                                        <form action="{{ route('subjective.toggleApprove', $data->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="quiz_id" value="{{ $quiz_id }}">
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <input type="hidden" name="question_id" value="{{ $data->question_id }}">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                       id="flexSwitchCheck{{ $data->id }}" name="answer_approved"
                                                       onchange="this.form.submit()"
                                                       {{ $data->answer_approved ? 'checked' : '' }}>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection
